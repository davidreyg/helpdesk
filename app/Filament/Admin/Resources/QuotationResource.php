<?php

namespace App\Filament\Admin\Resources;

use App\Enums\CurrencyEnum;
use App\Enums\DiscountTypeEnum;
use App\Enums\PaymentTypeEnum;
use App\Filament\Admin\Resources\QuotationResource\Pages;
use App\Models\Quotation;
use App\Utilities\CurrencyConverter;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Livewire\Component;
use Wallo\FilamentSelectify\Components\ButtonGroup;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'tabler-businessplan';

    public static function getModelLabel(): string
    {
        return trans_choice('Quotation|Quotations', 1);
    }

    public static function getPluralModelLabel(): string
    {
        return trans_choice('Quotation|Quotations', 2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->label(__('Company'))
                    ->searchable()
                    ->relationship('company', 'name')
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->label(__('Code'))
                    ->default(fn (): string => 'COT-' . str_pad(Quotation::generateNextNumber() . '', 7, '0', STR_PAD_LEFT))
                    ->disabled()
                    ->required()
                    ->maxLength(100),
                Forms\Components\Select::make('currency')
                    ->label(__('Currency'))
                    ->required()
                    ->live()
                    ->hint(new HtmlString(\Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.currency" />')))
                    ->options(CurrencyEnum::class),
                Forms\Components\Select::make('payment_type')
                    ->label(__('Payment Type'))
                    ->required()
                    ->options(PaymentTypeEnum::class),
                Forms\Components\TextInput::make('requester_name')
                    ->label(__('Requester Name'))
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('project')
                    ->label(__('Project'))
                    ->required()
                    ->maxLength(100),
                Section::make('Items')
                    ->schema([
                        TableRepeater::make('items')
                            ->hiddenLabel()
                            ->relationship('quotationItems')
                            ->addActionLabel(__('Add'))
                            ->afterStateUpdated(function ($livewire): void {
                                // Aquí detectamos si se eliminó un ítem
                                self::updateQuotationTotals($livewire);
                            })
                            ->headers([
                                Header::make('Qty')
                                    ->label(__('Quantity'))
                                    ->width('80px'),
                                Header::make('Product')
                                    ->label(__('Product') . '/' . __('Service')),
                                Header::make('Unit')
                                    ->label(__('Description')),
                                Header::make('Unit')
                                    ->label(__('Brand')),
                                Header::make('Unit')
                                    ->label(__('Unit'))
                                    ->width('150px'),
                                Header::make('Price')
                                    ->label(__('Price'))
                                    ->width('150px'),
                                Header::make('Total')
                                    // ->label(__('Price'))
                                    ->width('150px'),
                            ])
                            ->schema([
                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->maxValue(999)
                                    ->live(true)
                                    ->hint(
                                        fn (TextInput $component): HtmlString => new HtmlString(
                                            \Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="{{$state}}" />', ['state' => $component->getStatePath()])
                                        )
                                    )
                                    ->afterStateUpdated(function (Get $get, Set $set, $livewire): void {
                                        self::updateItemTotals($get, $set, $livewire);
                                        self::updateQuotationTotals($livewire);
                                    }),
                                TextInput::make('product')
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('description')
                                    ->required()
                                    ->maxLength(200),
                                TextInput::make('brand')
                                    ->required()
                                    ->maxLength(100),
                                TextInput::make('unit')
                                    ->required()
                                    ->maxLength(50),
                                TextInput::make('price')
                                    ->required()
                                    ->default(0)
                                    ->live(true)
                                    ->hint(
                                        fn (TextInput $component): HtmlString => new HtmlString(
                                            \Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="{{$state}}" />', ['state' => $component->getStatePath()])
                                        )
                                    )
                                    ->afterStateUpdated(function (Get $get, Set $set, $livewire): void {
                                        self::updateItemTotals($get, $set, $livewire);
                                        self::updateQuotationTotals($livewire);
                                    })
                                    ->money(fn (Get $get): mixed => $get('../../currency')),
                                TextInput::make('total')
                                    ->readOnly()
                                    ->hiddenLabel()
                                    ->money(fn (Get $get): mixed => $get('../../currency'))
                                    ->afterStateHydrated(function (Get $get, Set $set, $livewire): void {
                                        self::updateItemTotals($get, $set, $livewire);
                                        self::updateQuotationTotals($livewire);
                                    }),
                            ]),
                    ]),
                Section::make('Descuento')
                    ->description('Aplique descuento a la cotización.')
                    ->schema([
                        Toggle::make('has_discount')
                            ->label('Aplicar descuento')
                            ->hint(fn (Toggle $component): HtmlString => new HtmlString(\Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="{{$state}}" />', ['state' => $component->getStatePath()])))
                            ->live()
                            ->afterStateUpdated(function (Set $set, $livewire) {
                                $set('discount_type', null);
                                $set('discount_amount', null);
                                $set('discount_value', null);
                                self::updateDiscount($livewire);
                            }),
                        ButtonGroup::make('discount_type')
                            ->hiddenLabel()
                            ->live()
                            ->options(DiscountTypeEnum::class)
                            ->gridDirection('row')
                            ->visible(fn (Get $get): bool => $get('has_discount'))
                            ->afterStateUpdated(function (Set $set, $livewire) {
                                $set('discount_amount', null);
                                $set('discount_value', null);
                                self::updateDiscount($livewire);
                            }),
                        Group::make([
                            TextInput::make('discount_amount')
                                ->visible(fn (Get $get): string => $get('discount_type') === DiscountTypeEnum::PERCENT->value)
                                ->required()
                                ->minValue(0)
                                ->live(true)
                                ->hint(fn (TextInput $component): HtmlString => new HtmlString(\Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="{{$state}}" />', ['state' => $component->getStatePath()])))
                                ->prefix('%')
                                ->mask(moneyMask('PEN'))
                                ->afterStateUpdated(function (Get $get, Set $set, $livewire): void {
                                    self::updateDiscount($livewire);
                                }),
                            TextInput::make('discount_value')
                                ->required()
                                ->readOnly(fn (Get $get): string => $get('discount_type') === DiscountTypeEnum::PERCENT->value)
                                ->live(true)
                                ->hint(fn (TextInput $component): HtmlString => new HtmlString(\Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="{{$state}}" />', ['state' => $component->getStatePath()])))
                                ->money(fn (Get $get) => $get('currency'))
                                ->afterStateUpdated(function (Get $get, Set $set, $livewire): void {
                                    self::updateDiscount($livewire);
                                }),
                        ])
                            ->columnSpanFull()
                            ->columns(2)
                            ->visible(fn (Get $get) =>(bool) $get('discount_type')),
                    ])
                    ->columns(2)
                    ->columnSpan(1),
                ViewField::make('subTotal')
                    ->view('filament.admin.forms.components.total')
                    ->viewData([
                        'min' => 1,
                        'max' => 5,
                    ]),
                Forms\Components\Textarea::make('notes')
                    ->label(__('Notes'))
                    ->columnSpanFull(),
                TableRepeater::make('extra_conditions')
                    ->label(__('Extra Conditions'))
                    ->default([
                        [
                            'name' => 'Tiempo de Entrega:',
                            'value' => '2 días despues de la girada la orden de compra',
                        ],
                    ])
                    ->headers([
                        Header::make('name')->label(__('Name')),
                        Header::make('name')->label('Value'),
                    ])
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('value')
                            ->required()
                            ->maxLength(200),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->latest())
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Attention Date'))
                    ->date()
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company.name')
                    ->label(__('Company'))
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('currency')
                    ->label(__('Currency')),
                Tables\Columns\TextColumn::make('total')
                    ->formatStateUsing(fn (string $state, Quotation $record): \Akaunting\Money\Money => money($state, $record->currency->value)),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('company')
                    ->label(__('Company'))
                    ->relationship('company', 'name')
                    ->searchable(),
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\Action::make('print')
                    ->hiddenLabel()
                    ->color('warning')
                    ->tooltip(__('Print'))
                    ->icon('tabler-printer')
                    ->url(fn (Quotation $record): string => route('quotation-pdf', [
                        'quotation' => $record->id,
                    ]))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()->hiddenLabel()->tooltip(__('Edit')),
                Tables\Actions\DeleteAction::make()->hiddenLabel()->tooltip(__('Delete')),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'edit' => Pages\EditQuotation::route('/{record}/edit'),
        ];
    }

    // This function updates totals based on the selected products and quantities
    public static function updateItemTotals(Get $get, Set $set, Component $livewire): void
    {
        // Retrieve the state path of the form. Most likely it's `data` but it could be something else.
        $currency = $get('../../currency') ?? 'PEN';
        $qty = (int) ($get('quantity')) !== 0 ? (int) ($get('quantity')) : 1;
        if ($qty === 1) {
            $set('quantity', 1);
        }

        $price = empty($get('price')) ? ($set('price', '0.00') ?: '0.00') : ($get('price'));
        $priceInt = CurrencyConverter::prepareForAccessor($price, $currency);

        $total = $priceInt * $qty;
        $totalConverted = CurrencyConverter::prepareForMutator($total, $currency);
        $set('total', $totalConverted);
    }

    public static function updateQuotationTotals(Component $livewire): void
    {
        // @phpstan-ignore method.notFound
        $statePath = $livewire->getFormStatePath();
        // Retrieve the state path of the form. Most likely it's `data` but it could be something else.
        $data = data_get($livewire, $statePath);
        $currency = data_get($livewire, "{$statePath}.currency", 'PEN') ?? 'PEN';
        $totalSum = collect($data['items'])
            ->pluck('total')
            ->filter()
            ->map(fn ($item): int => CurrencyConverter::prepareForAccessor($item, $currency))
            ->sum();
        data_set($livewire, $statePath . '.subTotal', $totalSum);
        data_set($livewire, $statePath . '.baseTotal', $totalSum);
        $hasDiscount = data_get($livewire, "{$statePath}.has_discount");
        if ($hasDiscount) {
            self::updateDiscount($livewire);
        }
    }

    public static function updateDiscount(Component $livewire): void
    {
        // @phpstan-ignore method.notFound
        $statePath = $livewire->getFormStatePath();
        // Retrieve the state path of the form. Most likely it's `data` but it could be something else.
        $data = data_get($livewire, $statePath);
        $currency = $data['currency'];
        $discountCalculated = 0;
        $subTotal = $data['baseTotal'];

        $discountAmount = $data['discount_amount'];
        if ($discountAmount === '' || empty($discountAmount)) {
            $discountAmount = '0';
        }
        $discountValue = $data['discount_value'];
        if ($discountValue === '' || empty($discountValue)) {
            $discountValue = '0';
        }
        switch ($data['discount_type']) {
            case DiscountTypeEnum::PERCENT->value:
                $discountCalculated = ($data['baseTotal'] * CurrencyConverter::prepareForAccessor($discountAmount, $currency)) / 10000;
                $subTotal = $data['baseTotal'] - $discountCalculated;
                data_set($livewire, $statePath . '.discount_value', CurrencyConverter::prepareForMutator($discountCalculated, $currency));
                break;
            case DiscountTypeEnum::FIXED->value:
                $subTotal = $data['baseTotal'] - CurrencyConverter::prepareForAccessor($discountValue ?? '0', $currency);
                break;
            default:
                // code...
                break;
        }

        data_set($livewire, $statePath . '.subTotal', $subTotal);
    }
}

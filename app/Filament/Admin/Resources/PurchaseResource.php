<?php

namespace App\Filament\Admin\Resources;

use App\Enums\CurrencyEnum;
use App\Filament\Admin\Resources\PurchaseResource\Pages;
use App\Models\Purchase;
use App\Utilities\CurrencyConverter;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
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

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'tabler-shopping-cart';

    public static function getModelLabel(): string
    {
        return trans_choice('Purchase Order|Purchase Orders', 1);
    }

    public static function getPluralModelLabel(): string
    {
        return trans_choice('Purchase Order|Purchase Orders', 2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label(__('Code'))
                    ->default(fn (): string => 'COM-' . str_pad(Purchase::generateNextNumber() . '', 7, '0', STR_PAD_LEFT))
                    ->disabled()
                    ->required()
                    ->maxLength(100),
                Forms\Components\Select::make('currency')
                    ->label(__('Currency'))
                    ->required()
                    ->live()
                    ->hint(new HtmlString(\Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.currency" />')))
                    ->options(CurrencyEnum::class),
                Forms\Components\TextInput::make('supplier_name')
                    ->label(__('Supplier Name'))
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('issue')
                    ->label(__('Issue'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reference')
                    ->label(__('Reference'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('attention')
                    ->label(__('Attention'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('company_id')
                    ->label(__('Company'))
                    ->searchable()
                    ->nullable()
                    ->relationship('company', 'name'),
                Section::make('Items')
                    ->schema([
                        TableRepeater::make('items')
                            ->hiddenLabel()
                            ->relationship('itemPurchases')
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
                                    ->label(__('Part Number') . '/' . __('Service')),
                                Header::make('Unit')
                                    ->label(__('Description')),
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
                ViewField::make('subTotal')
                    ->view('filament.admin.forms.components.total')
                    ->columnSpanFull()
                    ->viewData([
                        'min' => 1,
                        'max' => 5,
                    ]),
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
                    ->formatStateUsing(fn (string $state, Purchase $record): \Akaunting\Money\Money => money($state, $record->currency->value)),
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
                    ->url(fn (Purchase $record): string => route('purchase-pdf', [
                        'purchase' => $record->id,
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
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
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
        // dump($totalSum);
    }
}

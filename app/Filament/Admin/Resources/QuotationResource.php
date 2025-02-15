<?php

namespace App\Filament\Admin\Resources;

use App\Enums\CurrencyEnum;
use App\Filament\Admin\Resources\QuotationResource\Pages;
use App\Filament\Admin\Resources\QuotationResource\RelationManagers;
use App\Models\Quotation;
use App\Utilities\CurrencyConverter;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('Quotation');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->label(__('Customer'))
                    ->relationship('customer', 'name')
                    ->required(),
                Forms\Components\TextInput::make('code')
                    ->label(__('Code'))
                    ->required()
                    ->maxLength(100),
                Forms\Components\Select::make('currency')
                    ->label(__('Currency'))
                    ->required()
                    ->live()
                    ->hint(new HtmlString(\Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="data.currency" />')))
                    ->options(CurrencyEnum::class),
                Section::make('Items')
                    ->schema([
                        TableRepeater::make('items')
                            ->hiddenLabel()
                            ->relationship('quotationItems')
                            ->headers([
                                Header::make('Qty')
                                    ->label(__('Quantity'))
                                    ->width('80px'),
                                Header::make('Desc')
                                    ->label(__('Description')),
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
                                    ->maxValue(99)
                                    ->live()
                                    ->hint(
                                        fn(TextInput $component) =>
                                        new HtmlString(
                                            \Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="{{$state}}" />', ['state' => $component->getStatePath()])
                                        )
                                    )
                                    ->afterStateUpdated(function (Get $get, Set $set, $livewire) {
                                        self::updateTotals($get, $set, $livewire);
                                    }),
                                TextInput::make('description')
                                    ->required()
                                    ->maxLength(200),
                                TextInput::make('unit')
                                    ->required()
                                    ->maxLength(50),
                                TextInput::make('price')
                                    ->required()
                                    ->default(0)
                                    ->live(true)
                                    ->hint(
                                        fn(TextInput $component) =>
                                        new HtmlString(
                                            \Blade::render('<x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="{{$state}}" />', ['state' => $component->getStatePath()])
                                        )
                                    )
                                    ->afterStateUpdated(function (Get $get, Set $set, $livewire) {
                                        self::updateTotals($get, $set, $livewire);
                                    })
                                    ->money(fn(Get $get) => $get('../../currency')),
                                TextInput::make('total')
                                    ->readOnly()
                                    ->hiddenLabel()
                                    ->money(fn(Get $get) => $get('../../currency'))
                                    ->afterStateHydrated(function (Get $get, Set $set) {
                                        $price = $get('price') ?? 0;
                                        $quantity = $get('quantity') ?? 0;
                                        $currency = $get('../../currency');

                                        if ($price && $quantity) {
                                            $priceInt = CurrencyConverter::prepareForAccessor($price, $currency);
                                            $total = $priceInt * $quantity;
                                            $totalConverted = CurrencyConverter::prepareForMutator($total, $currency);
                                            $set('total', $totalConverted);
                                        } else {
                                            $set('total', '-');
                                        }
                                    }),
                            ])
                    ]),

                Forms\Components\Textarea::make('notes')
                    ->label(__('Notes'))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label(__('Customer'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency')
                    ->label(__('Currency'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
    public static function updateTotals(Get $get, Set $set, Component $livewire): void
    {
        // Retrieve the state path of the form. Most likely it's `data` but it could be something else.
        $statePath = $livewire->getFormStatePath();
        $qty = floatval($get('quantity'));
        $price = floatval($get('price'));
        $priceInt = CurrencyConverter::prepareForAccessor($price, $get('../../currency'));


        $total = $priceInt * $qty;
        $totalConverted = CurrencyConverter::prepareForMutator($total, $get('../../currency'));
        $set('total', $totalConverted);
    }
}

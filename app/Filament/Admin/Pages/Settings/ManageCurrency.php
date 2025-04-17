<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Settings\CurrencySettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Illuminate\Contracts\Support\Htmlable;

class ManageCurrency extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'tabler-settings-dollar';

    protected static ?int $navigationSort = 99;

    protected static string $settings = CurrencySettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__(__('filament-translation-manager::messages.navigation_group')))
                            ->icon('tabler-settings-dollar')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('code')->label(__('Code'))->required(),
                                        Forms\Components\TextInput::make('name')->label(__('Name'))->required(),
                                        Forms\Components\TextInput::make('precision')->label(__('Precision'))->numeric()->required(),
                                        Forms\Components\TextInput::make('symbol')->label(__('Symbol'))->required(),
                                        Forms\Components\TextInput::make('decimal_mark')->label(__('Decimal Separator'))->required(),
                                        Forms\Components\TextInput::make('thousands_separator')->label(__('Thousand Separator'))->required(),
                                        Forms\Components\Toggle::make('symbol_first')->inline(false)->label(__('Symbol First'))->required(),
                                    ])
                                    ->columns(3),
                            ]),
                    ])
                    ->columnSpan([
                        'md' => 2,
                    ]),
            ]);
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-translation-manager::messages.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('Currency');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Currency');
    }

    public function getHeading(): string|Htmlable
    {
        return __('Currency');
    }

    // public function getSubheading(): string|Htmlable|null
    // {
    //     return 'Gestionar la configuracion de la moneda';
    // }
}

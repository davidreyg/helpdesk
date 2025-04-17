<?php

namespace App\Filament\Admin\Pages\Settings;

use App\Settings\GeneralSettings;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Filament\Support\Facades\FilamentView;

use function Filament\Support\is_app_url;

use Illuminate\Contracts\Support\Htmlable;

class ManageGeneral extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = GeneralSettings::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'fluentui-settings-20';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public string $themePath = '';

    public string $twConfigPath = '';

    public function mount(): void
    {
        $this->fillForm();
    }

    protected function fillForm(): void
    {
        $settings = app(static::getSettings());
        $data = $this->mutateFormDataBeforeFill($settings->toArray());
        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Site')
                    ->label(fn () => __('page.general_settings.sections.site'))
                    ->description(fn () => __('page.general_settings.sections.site.description'))
                    ->icon('fluentui-web-asset-24-o')
                    ->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('brand_name')
                                ->label(fn () => __('page.general_settings.fields.brand_name'))
                                ->required(),
                            Forms\Components\Select::make('site_active')
                                ->label(fn () => __('page.general_settings.fields.site_active'))
                                ->options([
                                    0 => 'Not Active',
                                    1 => 'Active',
                                ])
                                ->native(false)
                                ->required(),
                        ]),
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\Grid::make()->schema([
                                Forms\Components\TextInput::make('brand_logoHeight')
                                    ->label(fn () => __('page.general_settings.fields.brand_logoHeight'))
                                    ->required()
                                    ->columnSpan(2),
                                Forms\Components\FileUpload::make('brand_logo')
                                    ->label(fn () => __('page.general_settings.fields.brand_logo'))
                                    ->image()
                                    ->directory('sites')
                                    ->visibility('public')
                                    ->moveFiles()
                                    ->preserveFilenames()
                                    ->required()
                                    ->columnSpan(2),
                            ])
                                ->columnSpan(2),
                            Forms\Components\FileUpload::make('site_favicon')
                                ->label(fn () => __('page.general_settings.fields.site_favicon'))
                                ->image()
                                ->directory('sites')
                                ->visibility('public')
                                ->moveFiles()
                                ->preserveFilenames()
                                ->acceptedFileTypes(['image/x-icon', 'image/vnd.microsoft.icon'])
                                ->required(),
                        ])->columns(4),
                    ]),
            ])
            ->columns(3)
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->mutateFormDataBeforeSave($this->form->getState());
        $settings = app(static::getSettings());
        $settings->fill($data);
        $settings->save();
        Notification::make()
            ->title('Settings updated.')
            ->success()
            ->send();
        $this->redirect(static::getUrl(), navigate: FilamentView::hasSpaMode() && is_app_url(static::getUrl()));
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-translation-manager::messages.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('page.general_settings.navigationLabel');
    }

    public function getTitle(): string | Htmlable
    {
        return __('page.general_settings.title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('page.general_settings.heading');
    }

    public function getSubheading(): string | Htmlable | null
    {
        return __('page.general_settings.subheading');
    }
}

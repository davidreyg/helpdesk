<?php

namespace App\Filament\Admin\Pages;

use Illuminate\Contracts\Support\Htmlable;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackups;

class Backups extends BaseBackups
{
    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    public function getHeading(): string | Htmlable
    {
        return 'Application Backups';
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-translation-manager::messages.navigation_group');
    }
}

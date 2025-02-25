<?php

use Filament\Support\Colors\Color;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('general.brand_name', 'Sistema de Gestion Incidentes');
        $this->migrator->add('general.brand_logo', 'sites/logo.jpg');
        $this->migrator->add('general.brand_logoHeight', '3rem');
        $this->migrator->add('general.site_active', true);
        $this->migrator->add('general.site_favicon', 'sites/favicon.ico');
    }
};

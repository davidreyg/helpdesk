<?php

use Filament\Support\Colors\Color;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('general.brand_name', 'Sistema de Gestion de RR.HH');
        $this->migrator->add('general.brand_logo', 'images/logo.jpg');
        $this->migrator->add('general.brand_logoHeight', '3rem');
        $this->migrator->add('general.site_active', true);
        $this->migrator->add('general.site_favicon', 'favicon.ico');
    }
};

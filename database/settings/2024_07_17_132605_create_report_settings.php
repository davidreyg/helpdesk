<?php

use App\Enums\Setting\Font;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        ;
        $this->migrator->add('report.logo', NULL);
        $this->migrator->add('report.show_logo', false);
        $this->migrator->add('report.header', 'Reporte');
        $this->migrator->add('report.sub_header', NULL);
        $this->migrator->add('report.terms', NULL);
        $this->migrator->add('report.footer', NULL);
        $this->migrator->add('report.accent_color', '#4F46E5');
        $this->migrator->add('report.font', Font::DEFAULT );
        $this->migrator->add('report.report_template', 'default');
    }
};

<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('currency.name', 'Sol Peruano');
        $this->migrator->add('currency.code', 'PEN');
        $this->migrator->add('currency.precision', 2);
        $this->migrator->add('currency.symbol', 'S/.');
        $this->migrator->add('currency.symbol_first', true);
        $this->migrator->add('currency.decimal_mark', '.');
        $this->migrator->add('currency.thousands_separator', ',');
    }
};

<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class CurrencySettings extends Settings
{
    public string $name;
    public string $code;
    public int $precision;
    public string $symbol;
    public bool $symbol_first;
    public string $decimal_mark;
    public string $thousands_separator;

    public static function group(): string
    {
        return 'currency';
    }
}

<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $brand_name;

    public ?string $brand_logo = null;

    public string $brand_logoHeight;

    public bool $site_active;

    public ?string $site_favicon = null;

    public static function group(): string
    {
        return 'general';
    }
}

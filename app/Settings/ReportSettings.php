<?php

namespace App\Settings;

use App\Enums\Setting\Font;
use Spatie\LaravelSettings\Settings;

class ReportSettings extends Settings
{
    public ?string $logo = null;

    public bool $show_logo;

    public string $header;

    public ?string $sub_header = null;

    public ?string $terms = null;

    public ?string $footer = null;

    public string $accent_color;

    public Font $font;

    public string $report_template;

    public static function group(): string
    {
        return 'report';
    }
}

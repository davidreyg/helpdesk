<?php

namespace App\Settings;

use App\Enums\Setting\Font;
use Spatie\LaravelSettings\Settings;

class ReportSettings extends Settings
{
    public ?string $logo;
    public bool $show_logo;
    public string $header;
    public ?string $sub_header;
    public ?string $terms;
    public ?string $footer;
    public string $accent_color;
    public Font $font;
    public string $report_template;

    public static function group(): string
    {
        return 'report';
    }
}

<?php

namespace App\View\Components;

use App\Models\Quotation;
use App\Settings\GeneralSettings;
use App\Settings\ReportSettings;
use Closure;
use Filament\Panel\Concerns\HasFont;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class QuotationPdf extends Component
{
    use HasFont;

    public string $fontFam;

    public Htmlable $fontHtml;

    public function __construct(public Quotation $datos, public ReportSettings $reportSettings, public GeneralSettings $generalSettings)
    {
        $this->fontFam = $this->reportSettings->font->getLabel();
        $this->fontHtml = $this->font($this->reportSettings->font->getLabel())->getFontHtml();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.pdf.quotation-pdf');
    }
}

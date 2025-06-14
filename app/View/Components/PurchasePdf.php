<?php

namespace App\View\Components;

use App\Models\Purchase;
use App\Settings\AppearanceSettings;
use App\Settings\ReportSettings;
use Closure;
use Filament\Panel\Concerns\HasFont;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PurchasePdf extends Component
{
    use HasFont;

    public function __construct(public Purchase $datos, public ReportSettings $reportSettings, public AppearanceSettings $appearanceSettings) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.pdf.purchase-pdf');
    }
}

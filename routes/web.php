<?php

use App\Actions\PdfGenerator;
use App\Enums\ReportTypeEnum;
use App\Models\Purchase;
use App\Models\Quotation;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    $recipient = auth()->user();

    Notification::make()
        ->title('Saved successfully')
        ->success()
        ->broadcast($recipient);
});

Route::get('/pdf/quotations/{quotation}', function (Quotation $quotation) {
    return PdfGenerator::make()
        ->filename($quotation->code)
        ->handle(ReportTypeEnum::COTIZACION, $quotation);
})->middleware([])->name('quotation-pdf');

Route::get('/pdf/purchases/{purchase}', function (Purchase $purchase) {
    return PdfGenerator::make()
        ->filename($purchase->code)
        ->handle(ReportTypeEnum::ORDEN_COMPRA, $purchase);
})->name('purchase-pdf');

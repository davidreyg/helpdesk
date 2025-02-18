<?php

use App\Actions\PdfGenerator;
use App\Enums\ReportTypeEnum;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pdf/test', function () {
    return PdfGenerator::make()
        ->filename('cotizacion')
        ->handle(ReportTypeEnum::COTIZACION, collect([]));
})->middleware([])->name('cotizacion-pdf');

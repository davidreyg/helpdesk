<?php

namespace App\Filament\Admin\Resources\QuotationResource\Pages;

use App\Filament\Admin\Resources\QuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

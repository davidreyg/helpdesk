<?php

namespace App\Filament\Admin\Resources\QuotationResource\Pages;

use App\Enums\ReportTypeEnum;
use App\Filament\Admin\Resources\QuotationResource;
use App\Models\Quotation;
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
            Actions\Action::make('print')
                ->label(__('Print'))
                ->icon('tabler-printer')
                ->url(fn(Quotation $record): string => route('quotation-pdf', [
                    'quotation' => $record->id
                ]))
                ->openUrlInNewTab()
        ];
    }
}

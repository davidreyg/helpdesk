<?php

namespace App\Filament\Admin\Resources\QuotationResource\Pages;

use App\Filament\Admin\Resources\QuotationResource;
use App\Models\Quotation;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        // Si getRecord no devuelve Quotation, podemos crear una instancia de Quotation
        $quotation = new Quotation();
        $quotation->fill($record->toArray()); // Copia los atributos del record a la instancia Quotation

        $data['code'] = $quotation->code;  // Ahora accedes a las propiedades de Quotation

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('print')
                ->label(__('Print'))
                ->icon('tabler-printer')
                ->url(fn(Quotation $record): string => route('quotation-pdf', [
                    'quotation' => $record->id,
                ]))
                ->openUrlInNewTab(),
        ];
    }
}

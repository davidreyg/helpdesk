<?php

namespace App\Filament\Admin\Resources\PurchaseResource\Pages;

use App\Filament\Admin\Resources\PurchaseResource;
use App\Models\Purchase;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchase extends EditRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();
        $data['code'] = $record->code;  // Ahora accedes a las propiedades de Purchase

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('print')
                ->label(__('Print'))
                ->icon('tabler-printer')
                ->url(fn (Purchase $record): string => route('purchase-pdf', [
                    'purchase' => $record->id,
                ]))
                ->openUrlInNewTab(),
        ];
    }
}

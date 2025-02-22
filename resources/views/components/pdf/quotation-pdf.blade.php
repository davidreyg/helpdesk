<div>
    {{-- TITLE --}}
    <div class="flex justify-center items-center">
        <div class="text-center max-w-2xl">
            <span class="text-3xl font-bold uppercase text-red-800">{{ __('Quotation') }}</span>
        </div>

    </div>

    {{-- CLIENT DATA --}}
    <div class="grid grid-cols-2 mt-6 justify-start items-center gap-2">
        <div class="">
            <span class="font-bold">Cliente:</span>
            <span>{{ $quotation->customer->name }}</span>
        </div>
        <div class="">
            <span class="font-bold">RUC / DNI:</span>
            <span>{{ $quotation->customer->document_number }}</span>
        </div>
        <div class="">
            <span class="font-bold">Contacto:</span>
            <span>{{ $quotation->customer->phone }} / {{ $quotation->customer->email }}</span>
        </div>
        <div class="">
            <span class="font-bold">{{ __('Address') }}:</span>
            <span>{{ $quotation->customer->address }}</span>
        </div>
        <div class="">
            <span class="font-bold">{{ __('validation.attributes.created_at') }}:</span>
            <span>{{ $quotation->created_at->format('Y-m-d') }}</span>
        </div>
    </div>

    {{-- ITEMS --}}
    <div class="overflow-hidden border border-gray-300 rounded-lg mt-6">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-700 divide-y divide-gray-300">
                <tr>
                    <th class="px-4 py-2 text-center font-bold w-4">Cantidad</th>
                    <th class="px-4 py-2 text-center font-bold">Descripcion</th>
                    <th class="px-4 py-2 text-center font-bold">Unidad</th>
                    <th class="px-4 py-2 text-center font-bold">P. Unitario</th>
                    <th class="px-4 py-2 text-center font-bold">Total</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($quotation->quotationItems as $item)
                    <tr>
                        <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->description }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->unit }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->price }}</td>
                        <td class="px-4 py-2 text-center">@money($item->total, $quotation->currency->value)</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="px-4 py-2 text-right" colspan="4">SubTotal:</td>
                    <td class="px-4 py-2 text-center">@money($quotation->subTotal, $quotation->currency->value)</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 text-right" colspan="4">I.G.V:</td>
                    <td class="px-4 py-2 text-center">@money($quotation->igv, $quotation->currency->value)</td>
                </tr>
                <tr>
                    <th class="px-4 py-2 text-right" colspan="4">Total:</th>
                    <th class="px-4 py-2 text-center">@money($quotation->total, $quotation->currency->value)</th>
                </tr>
                <!-- Agrega más filas según sea necesario -->
            </tbody>
        </table>
    </div>
</div>

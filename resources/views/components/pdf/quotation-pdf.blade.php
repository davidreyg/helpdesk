<div>
    {{-- TITLE --}}
    <div class="flex justify-center items-center">
        <div class="text-center max-w-2xl">
            <span class="text-3xl font-bold uppercase text-red-800">{{ __('Quotation') }}</span>
            <p>{{ $quotation->code }}</p>
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

    {{-- FOOTER --}}
    <div class="grid grid-cols-1 gap-4 mt-8">
        <p class="font-bold italic text-sm">CONDICIONES GENERALES:</p>
        <ol class="list-disc list-inside">

            <li class="italic text-sm">Los precios estan expresados en <span
                    class="font-bold text-red-500">{{ $quotation->currency->name }}</span>
                Para pagos en <span class="font-bold text-red-500">{{ $quotation->currency->getOpposite() }}</span>
                se considerara tasa de cambio
                oficial</li>
            <li class="italic text-sm">Validez de la oferta: 10 Días</li>
            <li class="italic text-sm">Forma de pago: contado </li>
            <li class="italic text-sm">Cuentas Bancarias:
                <!-- Lista ordenada anidada (nivel 1.1) -->
                <ol class="list-decimal ml-8">
                    <li class="italic text-sm">
                        Scotiabank DOLARES N° 280-0008873 CCI: 009-280-212800008873-99
                    </li>
                    <li class="italic text-sm">
                        Scotiabank SOLES N° 152-0030634 CCI: 009-048-201520030634-04
                    </li>
                </ol>
            </li>
            <li class="italic text-sm">Tiempo de Entrega: 2 días despues de la girada la orden de compra</li>
        </ol>
    </div>
</div>

@php
    $quotation = $datos;
@endphp
<div>
    {{-- TITLE --}}
    <div class="flex justify-center items-center">
        <div class="text-center max-w-2xl">
            <span class="text-3xl font-bold uppercase text-red-800">{{ trans_choice('Quotation|Quotations', 1) }}</span>
            <p>{{ $quotation->code }}</p>
        </div>

    </div>

    {{-- CLIENT DATA --}}
    <div class="grid grid-cols-2 mt-6 justify-start items-center gap-2">
        <div class="">
            <span class="font-bold">Cliente:</span>
            <span>{{ $quotation->company->name }}</span>
        </div>
        <div class="">
            <span class="font-bold">RUC:</span>
            <span>{{ $quotation->company->document_number }}</span>
        </div>
        <div class="">
            <span class="font-bold">Contacto:</span>
            <span>{{ $quotation->company->phone }} / {{ $quotation->company->email }}</span>
        </div>
        <div class="">
            <span class="font-bold">{{ __('Address') }}:</span>
            <span>{{ $quotation->company->address }}</span>
        </div>
        <div class="">
            <span class="font-bold">{{ __('validation.attributes.created_at') }}:</span>
            <span>{{ $quotation->created_at->format('Y-m-d') }}</span>
        </div>
        <div class="">
            <span class="font-bold">{{ __('Project') }}:</span>
            <span>{{ $quotation->project }}</span>
        </div>
    </div>

    @php
        $symbol = money('3', $quotation->currency->value)->getCurrency()->getSymbol();
    @endphp
    {{-- ITEMS --}}
    <div class="overflow-hidden border border-gray-300 rounded-lg mt-6 text-xs">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-700 divide-y divide-gray-300">
                <tr>
                    <th class="px-2 py-2 text-center font-bold">Cantidad</th>
                    <th class="px-2 py-2 text-center font-bold">Producto/Servicio</th>
                    <th class="px-2 py-2 text-center font-bold">Descripcion</th>
                    <th class="px-2 py-2 text-center font-bold">Marca</th>
                    <th class="px-2 py-2 text-center font-bold max-w-24">Unidad</th>
                    <th class="px-2 py-2 text-center font-bold">PU ({{ $symbol }})</th>
                    <th class="px-2 py-2 text-center font-bold">Total ({{ $symbol }})</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($quotation->quotationItems as $item)
                    <tr>
                        <td class="px-2 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="px-2 py-2 text-center ">{{ $item->product }}</td>
                        <td class="px-2 py-2 text-center max-w-72">{{ $item->description }}</td>
                        <td class="px-2 py-2 text-center ">{{ $item->brand }}</td>
                        <td class="px-2 py-2 text-center max-w-28">{{ $item->unit }}</td>
                        <td class="px-2 py-2 text-center">{{ $item->price }}</td>
                        @php
                            $simpleTotal = money($item->total, $quotation->currency->value)->formatSimple();
                        @endphp
                        <td class="px-2 py-2 text-center">{{ $simpleTotal }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="px-2 py-2 text-right" colspan="6">SubTotal:</td>
                    <td class="px-2 py-2 text-center">@money($quotation->subTotal, $quotation->currency->value)</td>
                </tr>
                <tr>
                    <td class="px-2 py-2 text-right" colspan="6">I.G.V:</td>
                    <td class="px-2 py-2 text-center">@money($quotation->igv, $quotation->currency->value)</td>
                </tr>
                <tr>
                    <th class="px-2 py-2 text-right" colspan="6">Total:</th>
                    <th class="px-2 py-2 text-center">@money($quotation->total, $quotation->currency->value)</th>
                </tr>
                <!-- Agrega más filas según sea necesario -->
            </tbody>
        </table>

    </div>

    <div class="mt-6">
        <p class="font-bold italic">{{ __('Notes') }}:</p>
        <p class="text-ellipsis">
            {{ $quotation->notes }}
        </p>
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
                    <li class="italic text-sm">
                        BBVA SOLES N° 0011-0370-4201000434-27 CCI: 011-370-000100043427-42
                    </li>
                </ol>
            </li>
            @if (isset($quotation->extra_condititons))
                @foreach ($quotation->extra_conditions as $item)
                    <li class="italic text-sm">{{ $item['name'] }}: {{ $item['value'] }}</li>
                @endforeach
            @endif
        </ol>
    </div>
</div>

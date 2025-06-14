@php
    $purchase = $datos;
@endphp
<div>
    {{-- TITLE --}}
    <div class="flex justify-center items-center">
        <div class="text-center max-w-2xl">
            <span
                class="text-3xl font-bold uppercase text-red-800">{{ trans_choice('Purchase Order|Purchase Orders', 1) }}</span>
            <p>{{ $purchase->code }}</p>
        </div>

    </div>

    {{-- CLIENT DATA --}}
    <div class="grid grid-rows-2 mt-6 justify-start items-center gap-2">
        <div class="">
            <span class="font-bold">Señores:</span>
            <span>{{ $purchase->supplier_name }}</span>
        </div>
        <div class="">
            <span class="font-bold">Presente.</span>
        </div>
    </div>

    <div class="grid grid-rows-2 mt-6 justify-start items-center gap-2">
        <div class="">
            <span class="font-bold">Asunto:</span>
            <span>{{ $purchase->issue }} </span>
        </div>
        <div class="">
            <span class="font-bold">{{ __('Reference') }}:</span>
            <span>{{ $purchase->reference }}</span>
        </div>
        <div class="">
            <span class="font-bold">{{ __('Attention') }}:</span>
            <span>{{ $purchase->attention }}</span>
        </div>
    </div>
    <p class="mt-6 text-xs italic">Sirvase importar el siguiente producto según cotización y detalle adjunto.</p>

    @php
        $symbol = money('3', $purchase->currency->value)->getCurrency()->getSymbol();
    @endphp
    {{-- ITEMS --}}
    <div class="overflow-hidden border border-gray-300 rounded-lg mt-2 text-xs">
        <table class="w-full table-auto">
            <thead class="bg-gray-200 text-gray-700 divide-y divide-gray-300">
                <tr>
                    <th class="px-2 py-2 text-center font-bold">{{ __('Quantity') }}</th>
                    <th class="px-2 py-2 text-center font-bold">{{ __('Product') }} / {{ __('Part Number') }}</th>
                    <th class="px-2 py-2 text-center font-bold">{{ __('Description') }}</th>
                    <th class="px-2 py-2 text-center font-bold">PU ({{ $symbol }})</th>
                    <th class="px-2 py-2 text-center font-bold">Total ({{ $symbol }})</th>
                </tr>
            </thead>
            <tbody class="">
                @foreach ($purchase->itemPurchases as $item)
                    <tr>
                        <td class="px-2 py-2 text-center">{{ $item->quantity }}</td>
                        <td class="px-2 py-2 text-center ">{{ $item->product }}</td>
                        <td class="px-2 py-2 text-center max-w-72">{{ $item->description }}</td>
                        <td class="px-2 py-2 text-center">{{ $item->price }}</td>
                        @php
                            $simpleTotal = money($item->total, $purchase->currency->value)->formatSimple();
                        @endphp
                        <td class="px-2 py-2 text-center">{{ $simpleTotal }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="px-2 py-2 text-right" colspan="4">SubTotal:</td>
                    <td class="px-2 py-2 text-center">@money($purchase->subTotal, $purchase->currency->value)</td>
                </tr>
                <tr>
                    <td class="px-2 py-2 text-right" colspan="4">I.G.V:</td>
                    <td class="px-2 py-2 text-center">@money($purchase->igv, $purchase->currency->value)</td>
                </tr>
                <tr>
                    <th class="px-2 py-2 text-right" colspan="4">Total:</th>
                    <th class="px-2 py-2 text-center">@money($purchase->total, $purchase->currency->value)</th>
                </tr>
                <!-- Agrega más filas según sea necesario -->
            </tbody>
        </table>

    </div>

    @if ($purchase->company)
        <div class="grid grid-rows-2 mt-20 justify-start items-center gap-2">
            <div class="">
                <span class="font-bold">Datos del usuario final:</span>
                <span>{{ $purchase->company->name }}</span>
            </div>
        </div>
    @endif
</div>

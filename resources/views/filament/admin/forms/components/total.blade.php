@php
    $subTotal = $getState() ?? 0;
    $igv = $subTotal * 0.18;
    $total = $subTotal + $igv;
    $currency = $this->data['currency'] ?? 'PEN';
@endphp

<div class="w-full">

    <x-filament::section>
        <x-slot name="heading">
            {{-- User details --}}
            Detalles
        </x-slot>

        {{-- Content --}}
        <x-filament-tables::container>
            <div class="divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10">
                <table class="w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                    <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                        <x-filament-tables::row>
                            <x-filament-tables::cell class="text-center">
                                <div class="px-3 py-4 text-sm text-right leading-6 text-gray-950 dark:text-white">
                                    {{ __('Direct Cost') }}
                                </div>
                            </x-filament-tables::cell>
                            <x-filament-tables::cell>
                                <div class="px-3 py-4 text-sm leading-6 text-gray-950 dark:text-white">
                                    @money($subTotal, $currency)
                                </div>
                            </x-filament-tables::cell>
                        </x-filament-tables::row>
                        <x-filament-tables::row>
                            <x-filament-tables::cell class="text-center">
                                <div class="px-3 py-4 text-sm text-right leading-6 text-gray-950 dark:text-white">
                                    I.G.V. :
                                </div>
                            </x-filament-tables::cell>
                            <x-filament-tables::cell>
                                <div class="px-3 py-4 text-sm leading-6 text-gray-950 dark:text-white">
                                    @money($igv, $currency)
                                </div>
                            </x-filament-tables::cell>
                        </x-filament-tables::row>
                        <x-filament-tables::row>
                            <x-filament-tables::cell class="text-center">
                                <div class="px-3 py-4 text-sm text-right leading-6 text-gray-950 dark:text-white">
                                    Total :
                                </div>
                            </x-filament-tables::cell>
                            <x-filament-tables::cell>
                                <div class="px-3 py-4 text-sm leading-6 text-gray-950 dark:text-white">
                                    @money($total, $currency)
                                </div>
                            </x-filament-tables::cell>
                        </x-filament-tables::row>
                    </tbody>
                </table>
            </div>
            <div class="es-table__footer-ctn border-t border-gray-200"></div>
        </x-filament-tables::container>
    </x-filament::section>

</div>

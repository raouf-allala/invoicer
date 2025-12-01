@props(['quote', 'settings'])

<div class="max-w-[800px] mx-auto bg-white p-8 text-sm text-black font-sans">
    <table class="w-full border-collapse">
        <thead class="table-header-group">
            <tr>
                <td colspan="5" class="pb-8">
                    <!-- Header -->
                    <div class="flex justify-between items-start">
                        <div class="w-1/2">
                            <h1 class="font-bold text-xl uppercase mb-2">{{ $quote->issuer_details['name'] }}</h1>
                            <div class="text-xs space-y-0.5 text-gray-600">
                                <p>{{ $quote->issuer_details['address'] }}</p>
                                @if(isset($quote->issuer_details['rc']))
                                <p>RC: {{ $quote->issuer_details['rc'] }}</p> @endif
                                @if(isset($quote->issuer_details['nif']))
                                <p>NIF: {{ $quote->issuer_details['nif'] }}</p> @endif
                                @if(isset($quote->issuer_details['ai']))
                                <p>AI: {{ $quote->issuer_details['ai'] }}</p> @endif
                                @if(isset($quote->issuer_details['nis']))
                                <p>NIS: {{ $quote->issuer_details['nis'] }}</p> @endif
                                @if(isset($quote->issuer_details['capital']))
                                <p>Capital social: {{ $quote->issuer_details['capital'] }}</p> @endif
                                @if(isset($quote->issuer_details['bank_account']))
                                <p>Compte bancaire: {{ $quote->issuer_details['bank_account'] }}</p> @endif
                                <p>TEL: {{ $quote->issuer_details['phone'] }}</p>
                                <p>EMAIL: {{ $quote->issuer_details['email'] }}</p>
                            </div>
                        </div>
                        <div class="w-1/2 flex justify-end items-center">
                            @if ($settings->logo)
                                <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="h-20 object-contain">
                            @else
                                <h2 class="text-2xl font-bold text-gray-400">{{ $quote->issuer_details['name'] }}</h2>
                            @endif
                        </div>
                    </div>

                    <!-- Title -->
                    <div class="flex items-center my-8">
                        <div class="flex-grow border-t border-gray-400"></div>
                        <h2 class="mx-4 text-2xl font-bold uppercase">{{ __('Devis') }}</h2>
                        <div class="flex-grow border-t border-gray-400"></div>
                    </div>

                    <!-- Info Block -->
                    <div class="flex justify-between">
                        <div class="w-1/2">
                            <p class="text-xs text-gray-500 mb-1">{{ __('Customer') }}</p>
                            <h3 class="font-bold text-lg uppercase mb-1">{{ $quote->customer_details['name'] }}</h3>
                            <div class="text-xs text-gray-600 space-y-0.5">
                                <p>{{ $quote->customer_details['address'] }}</p>
                                @if(isset($quote->customer_details['rc']))
                                <p>RC: {{ $quote->customer_details['rc'] }}</p> @endif
                                @if(isset($quote->customer_details['nif']))
                                <p>NIF: {{ $quote->customer_details['nif'] }}</p> @endif
                                @if(isset($quote->customer_details['ai']))
                                <p>AI: {{ $quote->customer_details['ai'] }}</p> @endif
                                @if(isset($quote->customer_details['nis']))
                                <p>NIS: {{ $quote->customer_details['nis'] }}</p> @endif
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="grid grid-cols-2 gap-y-1 text-sm">
                                <div class="font-bold">{{ __('Date') }}:</div>
                                <div>
                                    {{ \Carbon\Carbon::parse($quote->quote_date)->locale(app()->getLocale())->isoFormat('DD MMMM YYYY') }}
                                </div>
                                <div class="font-bold">{{ __('Number') }}:</div>
                                <div>{{ $quote->quote_number }}</div>
                                {{-- <div class="font-bold">{{ __('Valid Until') }}:</div>
                                <div>
                                    {{
                                    \Carbon\Carbon::parse($quote->due_date)->locale(app()->getLocale())->isoFormat('DD
                                    MMMM YYYY') }}
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="bg-black text-white text-xs uppercase">
                <th class="py-2 px-2 border border-gray-600 w-12">{{ __('No.') }}</th>
                <th class="py-2 px-2 border border-gray-600 text-left">{{ __('Description') }}</th>
                <th class="py-2 px-2 border border-gray-600 w-24 whitespace-nowrap">{{ __('Rate') }}</th>
                <th class="py-2 px-2 border border-gray-600 w-16">{{ __('Qty') }}</th>
                <th class="py-2 px-2 border border-gray-600 w-28 whitespace-nowrap">{{ __('Amount') }}</th>
            </tr>
        </thead>
        <tbody class="text-sm table-row-group">
            @php
                $totalHT = 0;
            @endphp
            @foreach ($quote->items as $index => $item)
                @php
                    $amount = $item['rate'] * $item['quantity'];
                    $totalHT += $amount;
                @endphp
                <tr class="break-inside-avoid">
                    <td class="py-2 px-2 border border-gray-400 text-center font-bold">{{ $index + 1 }}</td>
                    <td class="py-2 px-2 border border-gray-400">
                        <div>{!! $item['name'] !!}</div>
                    </td>
                    <td class="py-2 px-2 border border-gray-400 text-center whitespace-nowrap">
                        {{ number_format($item['rate'], 2, '.', ' ') }}
                        DZD
                    </td>
                    <td class="py-2 px-2 border border-gray-400 text-center">{{ $item['quantity'] }}</td>
                    <td class="py-2 px-2 border border-gray-400 text-center whitespace-nowrap">
                        {{ number_format($amount, 2, '.', ' ') }} DZD
                    </td>
                </tr>
            @endforeach
            <tr class="break-inside-avoid">
                <td colspan="4" class="py-2 px-2 border border-gray-400 text-right font-bold">{{ __('Total') }}</td>
                <td class="py-2 px-2 border border-gray-400 text-center font-bold">
                    {{ number_format($totalHT, 2, '.', ' ') }} DZD
                </td>
            </tr>
            {{-- <tr class="break-inside-avoid">
                <td colspan="4" class="py-2 px-2 border border-gray-400 text-right font-bold">{{ __('Tax') }} (19%)</td>
                <td class="py-2 px-2 border border-gray-400 text-center font-bold">
                    {{ number_format($totalHT * 0.19, 2, '.', ' ') }} DZD
                </td>
            </tr> --}}
            {{-- <tr class="break-inside-avoid">
                <td colspan="4" class="py-2 px-2 border border-gray-400 text-right font-bold">{{ __('Total') }} TTC</td>
                <td class="py-2 px-2 border border-gray-400 text-center font-bold">
                    {{ number_format($totalHT * 1.19, 2, '.', ' ') }} DZD
                </td>
            </tr> --}}

            {{-- <tr class="break-inside-avoid">
                <td colspan="4" class="py-2 px-2 border border-gray-400 text-right font-bold">{{ __('Total') }} TTC</td>
                <td class="py-2 px-2 border border-gray-400 text-center font-bold">
                    {{ number_format($totalHT, 2, '.', ' ') }} DZD
                </td>
            </tr> --}}

            <!-- Spacer Row -->
            <tr class="break-inside-avoid">
                <td colspan="5" class="py-4 border-none"></td>
            </tr>

            <!-- Amount in Words -->
            <tr class="break-inside-avoid">
                <td colspan="5" class="border-none">
                    <div class="mb-8 text-sm">
                        <p class="uppercase text-gray-600 mb-1">ARRÊTÉ LE PRÉSENT DEVIS A LA SOMME DE</p>
                        <p class="font-bold uppercase">
                            @php
                                // $totalTTC = $totalHT * 1.19;
                                $totalTTC = $totalHT;
                                $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::SPELLOUT);
                                echo $formatter->format($totalTTC) . ' DINARS ALGÉRIENS';
                            @endphp
                        </p>
                    </div>
                </td>
            </tr>

            <!-- Footer (QR & Signature) -->
            {{-- <tr class="break-inside-avoid">
                <td colspan="5" class="border-none">
                    <div class="flex justify-end items-end mt-4">
                        <div class="text-center">
                            @if ($settings->stamp)
                            <img src="{{ asset('storage/' . $settings->stamp) }}" alt="Stamp"
                                class="h-24 object-contain">
                            @endif
                        </div>
                    </div>
                </td>
            </tr> --}}
        </tbody>
    </table>
</div>
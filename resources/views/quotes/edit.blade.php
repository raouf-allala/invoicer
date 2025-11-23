<x-layouts.sidebar>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Quote') }} #{{ $quote->quote_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="post" action="{{ route('quotes.update', $quote) }}"
                x-data="invoiceEditor({{ json_encode($quote->items) }})">
                @csrf
                @method('PUT')
                <!-- Hidden input for items -->
                <input type="hidden" name="items" :value="JSON.stringify(items)">

                <div class="max-w-[800px] mx-auto bg-white p-8 text-sm text-black font-sans shadow-lg">
                    <!-- Header -->
                    <div class="flex justify-between items-start">
                        <div class="w-1/2">
                            <h1 class="font-bold text-xl uppercase mb-2">
                                {{ $quote->issuer_details['name'] ?? __('Company Name') }}
                            </h1>
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
                                <p>TEL: {{ $quote->issuer_details['phone'] }}</p>
                                <p>EMAIL: {{ $quote->issuer_details['email'] }}</p>
                            </div>
                        </div>
                        <div class="w-1/2 flex justify-end items-center">
                            @if ($settings->logo)
                                <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="h-20 object-contain">
                            @else
                                <h2 class="text-2xl font-bold text-gray-400">
                                    {{ $quote->issuer_details['name'] ?? __('Logo') }}
                                </h2>
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
                    <div class="flex justify-between mb-8">
                        <div class="w-1/2">
                            <p class="text-xs text-gray-500 mb-1">{{ __('Customer') }}</p>
                            <select name="customer_id"
                                class="block w-full border-none p-0 text-lg font-bold uppercase focus:ring-0 bg-transparent"
                                required>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ $quote->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            <div class="text-xs text-gray-500 mt-1">
                                (Address details will update on save)
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="grid grid-cols-2 gap-y-1 text-sm items-center">
                                <div class="font-bold">{{ __('Date') }}:</div>
                                <input type="date" name="quote_date" value="{{ $quote->quote_date->format('Y-m-d') }}"
                                    class="border-none p-0 text-sm focus:ring-0 bg-transparent">
                                <div class="font-bold">{{ __('Number') }}:</div>
                                <div>{{ $quote->quote_number }}</div>
                                <div class="font-bold">{{ __('Valid Until') }}:</div>
                                <input type="date" name="due_date"
                                    value="{{ $quote->due_date ? $quote->due_date->format('Y-m-d') : '' }}"
                                    class="border-none p-0 text-sm focus:ring-0 bg-transparent">
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <table class="w-full border-collapse border border-black mb-4">
                        <thead>
                            <tr class="bg-black text-white text-xs uppercase">
                                <th class="py-2 px-2 border border-gray-600 w-12">{{ __('No.') }}</th>
                                <th class="py-2 px-2 border border-gray-600 text-left">{{ __('Description') }}</th>
                                <th class="py-2 px-2 border border-gray-600 w-24">{{ __('Rate') }}</th>
                                <th class="py-2 px-2 border border-gray-600 w-16">{{ __('Qty') }}</th>
                                <th class="py-2 px-2 border border-gray-600 w-28">{{ __('Amount') }}</th>
                                <th class="py-2 px-2 border border-gray-600 w-8"></th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <template x-for="(item, index) in items" :key="index">
                                <tr>
                                    <td class="py-2 px-2 border border-gray-400 text-center font-bold"
                                        x-text="index + 1"></td>
                                    <td class="py-2 px-2 border border-gray-400">
                                        <div x-init="initQuill($el, index)" class="h-auto min-h-[50px]"></div>
                                    </td>
                                    <td class="py-2 px-2 border border-gray-400 text-center">
                                        <input type="number" x-model="item.rate" step="0.01"
                                            class="w-full border-none text-center p-0 focus:ring-0 bg-transparent"
                                            placeholder="0.00">
                                    </td>
                                    <td class="py-2 px-2 border border-gray-400 text-center">
                                        <input type="number" x-model="item.quantity" min="1"
                                            class="w-full border-none text-center p-0 focus:ring-0 bg-transparent"
                                            placeholder="1">
                                    </td>
                                    <td class="py-2 px-2 border border-gray-400 text-center">
                                        <span x-text="calculateTotal(item) + ' DZD'"></span>
                                    </td>
                                    <td class="py-2 px-2 border border-gray-400 text-center">
                                        <button type="button" @click="removeItem(index)"
                                            class="text-red-500 hover:text-red-700" title="Remove Item">
                                            &times;
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <button type="button" @click="addItem()"
                        class="mb-4 text-blue-600 hover:text-blue-800 text-sm font-bold flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Add Item') }}
                    </button>

                    <!-- Totals -->
                    <div class="flex justify-end mb-8">
                        <div class="w-1/3 border border-black">
                            <div class="flex justify-between p-2 border-b border-gray-400">
                                <span class="font-bold">{{ __('Subtotal') }}</span>
                                <span x-text="subtotal + ' DZD'"></span>
                            </div>
                            <div class="flex justify-between p-2 border-b border-gray-400">
                                <span class="font-bold">{{ __('Tax') }} (19%)</span>
                                <span x-text="tax + ' DZD'"></span>
                            </div>
                            <div class="flex justify-between p-2 bg-gray-100">
                                <span class="font-bold">{{ __('Total') }}</span>
                                <span class="font-bold" x-text="total + ' DZD'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('quotes.show', $quote->quote_number) }}"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">{{ __('Cancel') }}</a>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Update Quote') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.sidebar>
<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Devis') }} — <span
                        class="text-sm font-normal tracking-wider text-gray-500">{{ $quote->quote_number }}</span>
                </h2>
                <a class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="{{ route('quotes.download', $quote) }}" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="size-4">
                        <path d="M12 17V3" />
                        <path d="m6 11 6 6 6-6" />
                        <path d="M19 21H5" />
                    </svg>
                    {{ __('Print') }}
                </a>
                @if($quote->status !== \App\Enums\QuoteStatus::CONVERTED)
                    <a class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                        href="{{ route('quotes.edit', $quote) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        {{ __('Edit') }}
                    </a>
                @endif
            </div>

            <div class="flex gap-2">
                <span
                    class="px-2 py-1 text-xs font-semibold rounded-full {{ $quote->status === \App\Enums\QuoteStatus::CONVERTED ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $quote->status->label() }}
                </span>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-6">
                <div class="lg:col-span-4">
                    <div class="overflow-hidden border border-gray-200 rounded-xl">
                        <x-quote :quote="$quote" :settings="$settings" />
                    </div>
                </div>
                <div class="space-y-6 lg:col-span-2">

                    @if($quote->status !== \App\Enums\QuoteStatus::CONVERTED)
                        <div
                            class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ __('Actions') }}</h5>
                            <form action="{{ route('quotes.convert', $quote) }}" method="POST">
                                @csrf
                                <x-primary-button class="w-full justify-center"
                                    onclick="return confirm('{{ __('Are you sure you want to convert this quote to an invoice?') }}')">
                                    {{ __('Convert to Invoice') }}
                                </x-primary-button>
                            </form>
                        </div>
                    @else
                        <div
                            class="p-6 bg-green-50 border border-green-200 rounded-lg shadow dark:bg-green-900 dark:border-green-700">
                            <h5 class="mb-2 text-lg font-bold tracking-tight text-green-900 dark:text-green-100">
                                {{ __('Converted') }}</h5>
                            <p class="mb-3 font-normal text-green-700 dark:text-green-200">
                                {{ __('This quote has been converted to an invoice.') }}</p>
                            @if($quote->convertedInvoice)
                                <a href="{{ route('invoices.show', $quote->convertedInvoice->invoice_number) }}"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    {{ __('View Invoice') }}
                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif

                    <x-link class="block" href="{{ route('customers.show', $quote->customer) }}">
                        <div
                            class="flex items-center gap-4 p-6 bg-white border border-gray-200 dark:bg-gray-800 sm:rounded-lg">
                            <div>
                                <div>{{ $quote->customer->name }}</div>
                                <div class="text-gray-500">{{ $quote->customer->email }}</div>
                            </div>
                        </div>
                    </x-link>

                    <div
                        class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <form action="{{ route('quotes.destroy', $quote) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium text-sm"
                                onclick="return confirm('{{ __('Are you sure you want to delete this quote?') }}')">
                                {{ __('Delete Quote') }}
                            </button>
                        </form>
                    </div>

                </div>

            </div>
        </div>

</x-layouts.sidebar>
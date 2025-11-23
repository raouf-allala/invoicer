@props(['quote'])

<x-link class="block" href="{{ route('quotes.show', $quote->quote_number) }}">
    <div class="p-4 bg-white border border-gray-200 sm:p-8 dark:bg-gray-800 sm:rounded-2xl">
        <div class="grid items-center gap-4 md:grid-cols-3 lg:grid-cols-5">
            <div class="flex flex-col flex-1 gap-2">
                <div class="text-sm text-gray-500">{{ __('Number') }}</div>
                <div class="dark:text-white">{{ strtoupper($quote->quote_number) }}</div>
            </div>
            <div class="flex flex-col flex-1 gap-2">
                <div class="text-sm text-gray-500">{{ __('Billed To') }}</div>
                <div class="dark:text-white">{{ $quote->customer->name }}</div>
            </div>
            <div class="flex flex-col flex-1 gap-2">
                <div class="text-sm text-gray-500">{{ __('Date') }}</div>
                <div class="dark:text-white">{{ $quote->quote_date->format('Y-m-d') }}</div>
            </div>
            <div class="flex flex-col flex-1 gap-2">
                <div class="text-sm text-gray-500">{{ __('Total') }}</div>
                <div class="text-lg font-medium md:text-base">
                    {{ $quote->total }} DZD
                </div>
            </div>
            <div class="flex flex-col flex-1 gap-2 lg:items-end">
                <div class="text-sm text-gray-500 md:hidden">{{ __('Status') }}</div>
                <div class="flex gap-2">
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $quote->status === \App\Enums\QuoteStatus::CONVERTED ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $quote->status->label() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-link>
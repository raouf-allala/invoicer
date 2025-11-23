<x-layouts.sidebar>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Quotes') }}
            </h2>
            <x-primary-button href="{{ route('quotes.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                {{ __('Create Quote') }}
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

            <!-- Filters -->
            <div
                class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-xl border border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <form class="flex flex-wrap gap-4 w-full" action="{{ route('quotes.index') }}" method="GET" x-data
                    x-on:change="$el.submit()">
                    <div class="flex items-center gap-2">
                        <x-input-label for="sort" class="whitespace-nowrap">{{ __('Sort by') }}</x-input-label>
                        <x-select name="sort" class="text-sm">
                            <option value="created_at" {{ request()->query('sort') == 'created_at' ? 'selected' : '' }}>
                                {{ __('Latest') }}</option>
                            <option value="total" {{ request()->query('sort') == 'total' ? 'selected' : '' }}>
                                {{ __('Amount') }}</option>
                        </x-select>
                    </div>
                    <div class="flex items-center gap-2">
                        <x-input-label for="status" class="whitespace-nowrap">{{ __('Status') }}</x-input-label>
                        <x-select name="status" class="text-sm">
                            <option value="all" {{ request()->query('status') == 'all' ? 'selected' : '' }}>
                                {{ __('All Statuses') }}</option>
                            @foreach(\App\Enums\QuoteStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ request()->query('status') == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <x-table>
                <x-slot name="header">
                    <x-table.th>{{ __('Number') }}</x-table.th>
                    <x-table.th>{{ __('Customer') }}</x-table.th>
                    <x-table.th>{{ __('Date') }}</x-table.th>
                    <x-table.th>{{ __('Valid Until') }}</x-table.th>
                    <x-table.th>{{ __('Status') }}</x-table.th>
                    <x-table.th align="right">{{ __('Amount') }}</x-table.th>
                    <x-table.th></x-table.th>
                </x-slot>
                @forelse ($quotes as $quote)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <x-table.td class="font-medium text-gray-900 dark:text-white">
                            <a href="{{ route('quotes.show', $quote->quote_number) }}" class="hover:underline">
                                {{ $quote->quote_number }}
                            </a>
                        </x-table.td>
                        <x-table.td>
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">
                                    {{ substr($quote->customer->name, 0, 1) }}
                                </div>
                                {{ $quote->customer->name }}
                            </div>
                        </x-table.td>
                        <x-table.td>{{ $quote->quote_date }}</x-table.td>
                        <x-table.td>{{ $quote->due_date }}</x-table.td>
                        <x-table.td>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ $quote->status->label() }}
                            </span>
                        </x-table.td>
                        <x-table.td align="right" class="font-bold">
                            {{ number_format($quote->total, 2) }} DZD
                        </x-table.td>
                        <x-table.td align="right">
                            <a href="{{ route('quotes.show', $quote->quote_number) }}"
                                class="text-gray-400 hover:text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </x-table.td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <p>{{ __('No quotes found.') }}</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </x-table>

            {{ $quotes->links() }}

        </div>
    </div>
</x-layouts.sidebar>
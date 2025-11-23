<x-layouts.sidebar>
	<x-slot name="header">
		<div class="flex items-center justify-between">
			<div class="flex items-center gap-4">
				<h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
					{{ __('Invoice') }} — <span
						class="text-sm font-normal tracking-wider text-gray-500">{{ $invoice->invoice_number }}</span>
				</h2>
				<a class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
					href="{{ route('invoices.download', ['invoice' => $invoice->invoice_number]) }}" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
						stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
						class="size-4">
						<path d="M12 17V3" />
						<path d="m6 11 6 6 6-6" />
						<path d="M19 21H5" />
					</svg>
					{{ __('Invoice PDF') }}
				</a>
				<a class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-800 bg-white border border-gray-200 rounded-lg shadow-sm gap-x-2 hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
					href="{{ route('invoices.edit', $invoice) }}">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
						stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
					</svg>
					{{ __('Edit') }}
				</a>
			</div>

			<div class="flex gap-2">
				@foreach ($invoice->statuses as $status)
					<x-status-badge :status="$status" />
				@endforeach
			</div>
		</div>
	</x-slot>
	<div class="py-12">
		<div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
			<div class="grid gap-6 lg:grid-cols-6">
				<div class="lg:col-span-4">
					<div class="overflow-hidden border border-gray-200 rounded-xl">
						<x-invoice :invoice="$invoice" :settings="$settings" />
					</div>
				</div>
				<div class="space-y-6 lg:col-span-2">
					<form action="{{ route('invoices.update-status', $invoice->id) }}" method="POST">
						@csrf
						@method('PATCH')
						<div class="flex gap-2">
							<x-select name="status" class="form-select" required>
								@foreach(\App\Enums\InvoiceStatus::fillableStatuses() as $status)
									<option value="{{ $status->value }}" {{ $invoice->status->value === $status->value ? 'selected' : '' }}>
										{{ $status->label() }}
									</option>
								@endforeach
							</x-select>
							<x-primary-button class="whitespace-nowrap">{{ __('Update Status') }}</x-primary-button>
						</div>
					</form>
					<x-link class="block" href="{{ route('customers.show', $invoice->customer) }}">
						<div
							class="flex items-center gap-4 p-6 bg-white border border-gray-200 dark:bg-gray-800 sm:rounded-lg">
							<div>
								<div>{{ $invoice->customer->name }}</div>
								<div class="text-gray-500">{{ $invoice->customer->email }}</div>
							</div>
						</div>
					</x-link>
					<livewire:notes :invoice-id="$invoice->id"></livewire:notes>
				</div>

			</div>
		</div>

</x-layouts.sidebar>
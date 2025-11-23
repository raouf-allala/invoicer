<x-layouts.sidebar>
	<div class="py-10">
		<div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

			<!-- Header -->
			<div class="mb-8">
				<h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Dashboard') }}</h1>
				<p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
					{{ __('Welcome back') }}, {{ Auth::user()->name }}.
					{{ __('Here\'s what\'s happening with your business today.') }}
				</p>
			</div>

			<!-- Stats Grid -->
			<div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">

				<!-- Revenue -->
				<x-dashboard.stat-card title="{{ __('Total Revenue') }}"
					value="{{ Illuminate\Support\Number::abbreviate($paidInvoicesTotal) }} DZD" color="emerald">
					<x-slot name="icon">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
							stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</x-slot>
				</x-dashboard.stat-card>

				<!-- Pending Revenue -->
				<x-dashboard.stat-card title="{{ __('Pending Revenue') }}"
					value="{{ Illuminate\Support\Number::abbreviate($currentInvoicesTotal) }} DZD" color="amber">
					<x-slot name="icon">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
							stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</x-slot>
				</x-dashboard.stat-card>

				<!-- Net Invoices -->
				<x-dashboard.stat-card title="{{ __('Net Invoices') }}" value="{{ $netInvoices }}" color="indigo">
					<x-slot name="icon">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
							stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
						</svg>
					</x-slot>
				</x-dashboard.stat-card>

				<!-- Total Customers -->
				<x-dashboard.stat-card title="{{ __('Total Customers') }}" value="{{ $totalCustomers }}" color="blue">
					<x-slot name="icon">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
							stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
						</svg>
					</x-slot>
				</x-dashboard.stat-card>

			</div>

			<!-- Secondary Stats Grid -->
			<div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-3">
				<!-- Paid Invoices Count -->
				<x-dashboard.stat-card title="{{ __('Paid Invoices') }}" value="{{ $paidInvoices }}" color="green"
					description="Fully paid invoices">
					<x-slot name="icon">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
							stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</x-slot>
				</x-dashboard.stat-card>

				<!-- Current Invoices Count -->
				<x-dashboard.stat-card title="{{ __('Current Invoices') }}" value="{{ $currentInvoices }}"
					color="yellow" description="Awaiting payment">
					<x-slot name="icon">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
							stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</x-slot>
				</x-dashboard.stat-card>

				<!-- Overdue Invoices Count -->
				<x-dashboard.stat-card title="{{ __('Overdue Invoices') }}" value="{{ $overdueInvoices }}" color="red"
					description="Past due date">
					<x-slot name="icon">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
							stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round"
								d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</x-slot>
				</x-dashboard.stat-card>
			</div>

			<!-- Recent Activity -->
			<div class="bg-white border border-gray-100 shadow-sm rounded-2xl dark:bg-gray-800 dark:border-gray-700">
				<div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-700">
					<h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Recent Invoices') }}</h2>
					<a href="{{ route('invoices.index') }}"
						class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
						{{ __('View All') }} &rarr;
					</a>
				</div>
				<div class="p-6">
					<div class="space-y-4">
						@forelse ($invoices as $invoice)
							<x-invoices.list-item :invoice="$invoice" />
						@empty
							<x-invoices.empty />
						@endforelse
					</div>
				</div>
			</div>

		</div>
	</div>
</x-layouts.sidebar>
<x-layouts.sidebar>
	<x-slot name="header">
		<div class="flex items-center justify-between">
			<h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
				{{ __('Customers') }}
			</h2>
			<x-primary-button href="{{ route('customers.create') }}">
				<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
					stroke="currentColor" stroke-width="2">
					<path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
				</svg>
				{{ __('Add Customer') }}
			</x-primary-button>
		</div>
	</x-slot>

	<div class="py-6">
		<div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">

			<!-- Table -->
			<x-table>
				<x-slot name="header">
					<x-table.th>{{ __('Name') }}</x-table.th>
					<x-table.th>{{ __('Email') }}</x-table.th>
					<x-table.th>{{ __('Phone') }}</x-table.th>
					<x-table.th>{{ __('Address') }}</x-table.th>
					<x-table.th align="right">{{ __('Actions') }}</x-table.th>
				</x-slot>
				@forelse ($customers as $customer)
					<tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
						<x-table.td class="font-medium text-gray-900 dark:text-white">
							<div class="flex items-center gap-2">
								<div
									class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold">
									{{ substr($customer->name, 0, 1) }}
								</div>
								{{ $customer->name }}
							</div>
						</x-table.td>
						<x-table.td>{{ $customer->email }}</x-table.td>
						<x-table.td>{{ $customer->phone }}</x-table.td>
						<x-table.td class="truncate max-w-xs">{{ $customer->address }}</x-table.td>
						<x-table.td align="right">
							<div class="flex items-center justify-end gap-2">
								<a href="{{ route('customers.edit', $customer) }}"
									class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
								<form action="{{ route('customers.destroy', $customer) }}" method="POST"
									onsubmit="return confirm('{{ __('Are you sure?') }}')">
									@csrf
									@method('DELETE')
									<button type="submit"
										class="text-red-600 hover:text-red-900">{{ __('Delete') }}</button>
								</form>
							</div>
						</x-table.td>
					</tr>
				@empty
					<tr>
						<td colspan="5" class="px-6 py-12 text-center text-gray-500">
							<div class="flex flex-col items-center justify-center">
								<svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
									viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
									</path>
								</svg>
								<p>{{ __('No customers found.') }}</p>
							</div>
						</td>
					</tr>
				@endforelse
			</x-table>

			{{ $customers->links() }}

		</div>
	</div>
</x-layouts.sidebar>
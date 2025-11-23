<x-app-layout>
	<div class="py-20 pt-40" id="home">
		<div class="px-6 mx-auto max-w-7xl md:px-12 xl:px-6">
			<div class="relative ml-auto">
				<div class="mx-auto text-center lg:w-2/3">
					<h1 class="text-5xl font-bold dark:text-white md:text-6xl xl:text-7xl">
						{{ __('Simple Invoicing for Freelancers.') }}
					</h1>
					<p class="mt-8 text-slate-800 dark:text-slate-300">
						{{ __('Manage your invoices...') }}
					</p>
					<div class="flex flex-wrap justify-center mt-16 gap-y-4 gap-x-6">
						<a href="#"
							class="relative flex items-center justify-center w-full px-6 h-11 before:absolute before:inset-0 before:rounded-full before:bg-indigo-600 before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 sm:w-max">
							<span class="relative text-base font-medium text-white">{{ __('Get Started') }}</span>
						</a>
						<a href="#"
							class="relative flex items-center justify-center w-full px-6 h-11 before:absolute before:inset-0 before:rounded-full before:border before:border-transparent before:bg-indigo-600/10 before:bg-gradient-to-b before:transition before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 dark:before:border-gray-700 dark:before:bg-gray-800 sm:w-max">
							<span
								class="relative text-base font-medium text-indigo-600 dark:text-white">{{ __('Learn More') }}</span>
						</a>
					</div>
					<div
						class="justify-between hidden py-8 mt-16 border-t border-b border-gray-100 sm:flex dark:border-gray-800">
						<div class="text-center">
							<h6 class="text-lg font-semibold dark:text-white">{{ __('Hassle-Free') }}</h6>
							<p class="mt-2 text-slate-500 dark:text-slate-400">
								{{ __('Invoicing without the extra fluff.') }}</p>
						</div>
						<div class="text-center">
							<h6 class="text-lg font-semibold dark:text-white">{{ __('Reports & Analytics') }}</h6>
							<p class="mt-2 text-slate-500 dark:text-slate-400">{{ __('Track your invoices...') }}</p>
						</div>
						<div class="text-center">
							<h6 class="text-lg font-semibold dark:text-white">{{ __('Customizable') }}</h6>
							<p class="mt-2 text-slate-500 dark:text-slate-400">{{ __('Personalize logos...') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
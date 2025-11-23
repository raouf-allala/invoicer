<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	{{-- Fonts --}}
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

	{{-- Scripts --}}
	@livewireStyles
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<style>
		[x-cloak] {
			display: none !important;
		}
	</style>
</head>

<body class="font-sans antialiased bg-gray-50 text-slate-600 dark:bg-slate-900 dark:text-slate-400"
	x-data="{ sidebarOpen: false }">
	<div class="min-h-screen flex">

		{{-- Sidebar --}}
		<div x-bind:class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
			class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-xl lg:shadow-none border-r border-slate-800">

			<div class="flex flex-col h-full">
				<!-- Logo -->
				<div class="flex items-center justify-center h-16 border-b border-slate-800">
					<span class="text-xl font-bold tracking-wider uppercase text-indigo-500">Invoo</span>
				</div>

				<!-- Nav Links -->
				<nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
					<x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="dashboard">
						{{ __('Dashboard') }}
					</x-nav-link>

					<div class="pt-4 pb-2">
						<p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
							{{ __('Business') }}
						</p>
					</div>

					<x-nav-link :href="route('invoices.index')" :active="request()->routeIs('invoices.*')"
						icon="document-text">
						{{ __('Invoices') }}
					</x-nav-link>

					<x-nav-link :href="route('quotes.index')" :active="request()->routeIs('quotes.*')"
						icon="clipboard-document-list">
						{{ __('Quotes') }}
					</x-nav-link>

					<x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')"
						icon="users">
						{{ __('Customers') }}
					</x-nav-link>

					<div class="pt-4 pb-2">
						<p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
							{{ __('Configuration') }}
						</p>
					</div>

					<x-nav-link :href="route('settings.edit')" :active="request()->routeIs('settings.*')"
						icon="cog-6-tooth">
						{{ __('Settings') }}
					</x-nav-link>
				</nav>

				<!-- User Profile / Footer -->
				<div class="p-4 border-t border-slate-800">
					<div class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-800 transition-colors cursor-pointer"
						x-data="{ open: false }" @click="open = !open" @click.outside="open = false">
						<div
							class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-sm">
							{{ substr(Auth::user()->name, 0, 1) }}
						</div>
						<div class="flex-1 min-w-0">
							<p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
							<p class="text-xs text-slate-400 truncate">{{ Auth::user()->email }}</p>
						</div>

						<!-- Dropdown Menu (Simplified for sidebar footer) -->
						<div x-show="open" x-transition
							class="absolute bottom-16 left-4 w-56 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-100 dark:border-slate-700 py-1 z-50">
							<a href="{{ route('profile.edit') }}"
								class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700">
								{{ __('Profile') }}
							</a>
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<button type="submit"
									class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-slate-700">
									{{ __('Log Out') }}
								</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- Mobile Overlay --}}
		<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
			class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>

		{{-- Main Content --}}
		<div class="flex-1 flex flex-col min-w-0 overflow-hidden">

			{{-- Top Header (Mobile Toggle + Page Title/Actions) --}}
			<header
				class="bg-white dark:bg-slate-900 border-b border-gray-200 dark:border-slate-800 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
				<div class="flex items-center gap-4">
					<button @click="sidebarOpen = true"
						class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-slate-200">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M4 6h16M4 12h16M4 18h16"></path>
						</svg>
					</button>

					@isset($header)
						<div class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
							{{ $header }}
						</div>
					@endisset
				</div>

				<div class="flex items-center gap-4">
					<!-- Language Switcher could go here -->
				</div>
			</header>

			{{-- Main Scrollable Area --}}
			<main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-slate-950 p-4 sm:p-6 lg:p-8">
				<x-alert class="mb-4" />
				{{ $slot }}
			</main>
		</div>
	</div>
	@livewireScriptConfig
</body>

</html>
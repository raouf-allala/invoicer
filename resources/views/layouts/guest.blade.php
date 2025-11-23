<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

	<!-- Scripts -->
	@livewireStyles
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900">
	<div
		class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0 dark:bg-gray-900 relative">
		<div class="absolute top-4 right-4">
			<x-dropdown align="right" width="48">
				<x-slot name="trigger">
					<button
						class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
						<div class="uppercase">{{ app()->getLocale() }}</div>
						<div class="ms-1">
							<svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
								<path fill-rule="evenodd"
									d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
									clip-rule="evenodd" />
							</svg>
						</div>
					</button>
				</x-slot>
				<x-slot name="content">
					<x-dropdown-link :href="route('lang.switch', 'en')">English</x-dropdown-link>
					<x-dropdown-link :href="route('lang.switch', 'fr')">Français</x-dropdown-link>
					<x-dropdown-link :href="route('lang.switch', 'ar')">العربية</x-dropdown-link>
				</x-slot>
			</x-dropdown>
		</div>
		<div>
			<a href="/">
				<x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
			</a>
		</div>

		<div
			class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
			{{ $slot }}
		</div>
	</div>
	@livewireScriptConfig
</body>

</html>
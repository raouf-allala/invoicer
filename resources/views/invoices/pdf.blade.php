<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	{{-- Fonts --}}
	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

	{{-- Scripts --}}
	@livewireStyles
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<style>
		@media print {
			@page {
				size: A4;
				margin: 10mm;
			}

			body {
				margin: 0;
				-webkit-print-color-adjust: exact;
				background-color: white;
			}

			/* Reset constraints */
			.max-w-\[800px\] {
				max-width: none !important;
				width: 100% !important;
				padding: 0 !important;
				margin: 0 !important;
			}

			/* Force table structure */
			table {
				width: 100% !important;
				border-collapse: separate !important;
				/* Changed from collapse to separate for Chrome support */
				border-spacing: 0 !important;
				page-break-inside: auto;
			}

			thead {
				display: table-header-group !important;
			}

			tfoot {
				display: table-footer-group !important;
			}

			tr {
				page-break-inside: avoid;
				page-break-after: auto;
			}

			/* Fix borders when using border-collapse: separate */
			td,
			th {
				border-color: #000 !important;
				/* Ensure borders are black */
			}

			/* Ensure content isn't hidden */
			* {
				overflow: visible !important;
			}
		}
	</style>
</head>

<body onload="window.print()">
	<main>
		<x-invoice :invoice="$invoice" :settings="$settings" />
	</main>
	@livewireScriptConfig
</body>

</html>
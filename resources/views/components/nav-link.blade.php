@props(['active' => false, 'icon' => null])

@php
	$classes = ($active ?? false)
		? 'flex items-center gap-3 px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg transition-colors group'
		: 'flex items-center gap-3 px-3 py-2 text-sm font-medium text-slate-400 rounded-lg hover:text-white hover:bg-slate-800 transition-colors group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
	@if($icon)
		@if($icon === 'dashboard')
			<svg class="w-5 h-5 opacity-75 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"
				stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round"
					d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
			</svg>
		@elseif($icon === 'document-text')
			<svg class="w-5 h-5 opacity-75 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"
				stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round"
					d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
			</svg>
		@elseif($icon === 'clipboard-document-list')
			<svg class="w-5 h-5 opacity-75 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"
				stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round"
					d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
			</svg>
		@elseif($icon === 'users')
			<svg class="w-5 h-5 opacity-75 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"
				stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round"
					d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
			</svg>
		@elseif($icon === 'cog-6-tooth')
			<svg class="w-5 h-5 opacity-75 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"
				stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round"
					d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
				<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
			</svg>
		@endif
	@endif
	{{ $slot }}
</a>
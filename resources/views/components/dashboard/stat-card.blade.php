@props(['title', 'value', 'icon', 'color' => 'indigo', 'description' => null])

<div class="p-6 bg-white border border-gray-100 shadow-sm rounded-2xl dark:bg-gray-800 dark:border-gray-700">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $title }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
            @if($description)
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $description }}</p>
            @endif
        </div>

        <div
            class="flex items-center justify-center w-12 h-12 rounded-xl bg-{{ $color }}-50 text-{{ $color }}-600 dark:bg-{{ $color }}-900/20 dark:text-{{ $color }}-400">
            {{ $icon }}
        </div>
    </div>
</div>
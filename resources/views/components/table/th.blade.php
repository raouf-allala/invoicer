@props(['align' => 'left'])

@php
    $classes = 'px-6 py-3 text-xs font-medium tracking-wider text-gray-500 uppercase dark:text-gray-400';
    if ($align === 'right')
        $classes .= ' text-right';
    elseif ($align === 'center')
        $classes .= ' text-center';
    else
        $classes .= ' text-left';
@endphp

<th {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</th>
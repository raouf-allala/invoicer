@props(['align' => 'left'])

@php
    $classes = 'px-6 py-4 text-sm text-gray-800 whitespace-nowrap dark:text-gray-200';
    if ($align === 'right')
        $classes .= ' text-right';
    elseif ($align === 'center')
        $classes .= ' text-center';
    else
        $classes .= ' text-left';
@endphp

<td {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</td>
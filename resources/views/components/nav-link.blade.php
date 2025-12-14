@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 pt-1 border-b-4 border-blue-600 text-lg font-bold leading-5 text-black focus:outline-none focus:border-blue-800 transition duration-150 ease-in-out bg-blue-50'
            : 'inline-flex items-center px-4 pt-1 border-b-4 border-transparent text-lg font-bold leading-5 text-black hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 focus:outline-none focus:text-blue-600 focus:border-blue-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

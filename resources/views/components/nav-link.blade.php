{{-- resources/views/components/nav-link.blade.php --}}
@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center gap-2 px-1 pt-1 border-b-2 border-primary-500 text-body-sm font-semibold leading-5 text-primary-700 focus:outline-none focus:border-primary-600 transition-all duration-200'
    : 'inline-flex items-center gap-2 px-1 pt-1 border-b-2 border-transparent text-body-sm font-medium leading-5 text-muted hover:text-heading hover:border-border focus:outline-none focus:text-heading focus:border-dark-300 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
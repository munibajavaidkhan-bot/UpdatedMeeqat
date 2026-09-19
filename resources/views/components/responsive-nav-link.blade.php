{{-- resources/views/components/responsive-nav-link.blade.php --}}
@props(['active'])

@php
$classes = ($active ?? false)
    ? 'flex items-center gap-3 w-full ps-3 pe-4 py-3 border-l-4 border-primary-500 text-body-sm font-semibold text-primary-700 bg-primary-50 focus:outline-none focus:text-primary-800 focus:bg-primary-100 focus:border-primary-600 transition-all duration-200'
    : 'flex items-center gap-3 w-full ps-3 pe-4 py-3 border-l-4 border-transparent text-body-sm font-medium text-body hover:text-heading hover:bg-dark-50 hover:border-border focus:outline-none focus:text-heading focus:bg-dark-50 focus:border-dark-300 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
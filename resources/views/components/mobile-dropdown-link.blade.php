@props(['active'])

@php
$classes = ($active ?? false)
  ? 'inline-flex text-black text-16p py-3 hover:text-gold items-center gap-1 font-medium focus:outline-none transition duration-150 ease-in-out'
  : 'inline-flex text-black text-16p py-3 gap-1 items-center hover:text-gold font-medium transition duration-150 ease-in-out pl-4';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
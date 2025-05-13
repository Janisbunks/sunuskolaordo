@props(['active'])

@php
$classes = ($active ?? false)
  ? 'inline-flex text-black text-17p pl-2.5 py-3 hover:text-gold items-center gap-1 focus:outline-none font-medium transition duration-150 ease-in-out'
  : 'inline-flex text-black text-17p pl-2.5 py-3 gap-1 items-center hover:text-gold transition duration-150 font-medium ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
@props(['active'])

@php
$classes = ($active ?? false)
  ? 'inline-flex items-center text-black'
  : 'inline-flex group gap-1 items-center text-black';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

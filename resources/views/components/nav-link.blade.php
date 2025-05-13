@props(['active'])

@php
$classes = ($active ?? false)
  ? 'inline-flex items-center text-white'
  : 'inline-flex group gap-1 items-center text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

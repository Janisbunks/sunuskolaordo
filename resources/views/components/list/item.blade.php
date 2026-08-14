@aware (['variant', 'icon'])

@php
  $classes = match ($variant) {
    'secondary' => 'text-secondary',
    'white' => 'text-white',
    default => 'text-black',
  };

  $icon = match ($icon) {
    'check' => 'check',
    'badge' => 'badge',
    default => 'check',
  };
@endphp

<li class="flex items-start gap-3">
  <x-dynamic-component :component="'icon-' . $icon" class="shrink-0 {{ $classes }}" />
  <div {{ $attributes->merge(['class' => '']) }}>{{ $slot }}</div>
</li>

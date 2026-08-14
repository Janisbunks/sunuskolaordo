@props (['variant' => 'yellow' , 'icon' => 'check'])

<ul {{ $attributes->merge(['class' => '']) }}>
  {{ $slot }}
</ul>

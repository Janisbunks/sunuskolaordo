@props (['width' => 'large', 'position' => 'center', 'type' => 'p', 'color' => 'black'])

@php
    $tag = in_array($type, ['p','h1', 'h2', 'h3', 'h4']) ? $type : 'p';
    $textAlignment = match($position) {
        'center' => 'text-center',
        'right' => 'text-right',
        default => 'text-left',
    };
    $linePosition = match($position) {
        'center' => 'mx-auto',
        'right' => 'mr-0 ml-auto',
        default => 'ml-0',
    };
    $textColor = match($color) {
        'primary' => 'text-primary',
        'white' => 'text-white',
        default => 'text-balck',
    };
@endphp

<{{ $tag }} class="font-bold mb-0 {{ $textColor }} {{ $textAlignment }}"> {{ $slot }} </{{ $tag }}>

<hr
  class="bg-primary text-34px xl:text-50px mt-2.5 mb-5 {{ $linePosition }} {{ $width === 'small' ? 'w-[100px]' : 'w-[200px]' }} h-[4px] border-0"
/>

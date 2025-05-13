@php
$element = $attributes->get('element', 'a');
if ($element === 'a' && !$attributes->has('href')) {
    $element = 'button';
}

$defaultClasses = 'inline-flex group justify-center gap-2 items-center font-bold';

$variants = [
    'white' => '',
    'transparent-white' => 'border border-white text-white hover:bg-white hover:text-black',
    'transparent-black' => 'border border-black text-black hover:bg-black hover:text-white',
    'black' => 'text-white bg-black hover:bg-white hover:text-black',
];

$sizes = [
    'small' => 'py-3 px-6',
    'base' => 'py-5 px-8',
    'rounded-full' => 'rounded-full w-10 h-10',
];
@endphp

<{{ $element }}
    class="{{ $defaultClasses }} {{ $variants[$attributes->get('variant', 'white')] }} {{ $sizes[$attributes->get('size', 'base')] }} {{ $attributes->get('class') }}"

    @foreach ($attributes->except(['class', 'variant', 'size', 'element']) as $key => $value)
        {{ $key }}="{{ $value }}"
    @endforeach
>
    {{ $slot }}
</{{ $element }}>

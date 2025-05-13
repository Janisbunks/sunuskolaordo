@php
$types = [
    'white' => 'text-white [&>span]:border-white',
    'black' => 'text-black [&>span]:border-black',
];
@endphp

<div x-data="{ isOpen: false }">
    <div x-show="isOpen" x-transition:enter="transition ease-out duration-300" 
       x-transition:enter-start="opacity-0 transform" 
       x-transition:enter-end="opacity-100 transform scale-100"
       class="transition-all ease-in-out duration-300" x-cloak>
        {{ $slot }}
    </div>
    <button @click="isOpen = !isOpen" class="font-inter text-15px font-semibold leading-150 {{ $types[$attributes->get('type', 'black')] }}" x-bind:class="{'hidden': isOpen}">
        <span x-show="!isOpen" class="flex items-center tracking-wider text-[15px] gap-1.25 uppercase hover:text-secondary transition ease-out duration-300">
            Read More
            <x-icon-arrow-down />
        </span>
    </button>
</div>
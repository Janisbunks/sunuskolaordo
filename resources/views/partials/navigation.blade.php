<nav class="flex-1 block">
  <div class="hidden lg:flex items-center gap-8 justify-center">
      @foreach ($navigation as $item)
        @if ($item->children)
          <div x-data="{ open: false }" x-cloak @mouseenter="open = true" @mouseleave="open = false" class="relative !ml-0 !mr-6.25">
            <x-nav-link class="h-full hover:text-cyan-500" href="{{ $item->url }}" :active="$item->active">
              {!! $item->label !!}
              <x-icon-arrow-down class="[&_path]:group-hover:stroke-cyan-500" />
            </x-nav-link>
            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="absolute left-0 pt-4 rounded-15p w-56 z-50" style="display: none;">
              @foreach ($item->children as $child)
                @if ($child->children)
                  <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative !ml-0 bg-white">
                    <x-dropdown-link class="h-full text-black" href="{{ $child->url }}" :active="$child->active">
                      {!! $child->label !!}
                    </x-dropdown-link>
                  </div>
                @else
                  <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative !ml-0 bg-white">
                    <x-dropdown-link class="h-full text-black" href="{{ $child->url }}" :active="$child->active">
                      {!! $child->label !!}
                    </x-dropdown-link>
                  </div>
                @endif
              @endforeach
            </div>
          </div>
        @else
          <x-nav-link href="{{ $item->url }}" :active="$item->active" class="!ml-0 mr-6.25 last:mr-0 hover:text-cyan-500">
            {!! $item->label !!}
          </x-nav-link>
        @endif
      @endforeach
  </div>
</nav>
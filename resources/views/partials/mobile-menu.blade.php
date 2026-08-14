<nav>
  <div
    :class="{ block: open, hidden: !open }"
    x-show="open"
    class="hidden bg-white mt-5 xl:hidden px-4 py-4 h-[75vh] overflow-y-scroll"
    x-transition:enter.duration.300ms
  >
    <div>
      @if ($navigation)
        @foreach ($navigation as $item)
          @if ($item->children)
            <div
              x-data="{ open: false }"
              x-cloak
              x-on:click="open = !open"
              class="relative !ml-0 mt-0 border-t border-grey"
              @click.stop
            >
              <x-mobile-nav-link href="{{ $item->url }}" :active="$item->active">
                {!! $item->label !!}
                <div
                  x-bind:class="{ 'rotate-180': open }"
                  class="absolute right-4 transition-transform duration-200 pointer-events-none z-[40]"
                >
                  <svg class="[&_path]:group-hover:fill-white -rotate-90" xmlns="http://www.w3.org/2000/svg" width="6" height="7" viewBox="0 0 6 7" fill="none">
                    <path d="M3 5L0 2H6L3 5Z" fill="#000" />
                  </svg>
                </div>
              </x-mobile-nav-link>
              <div
                x-show="open"
                :class="{ 'z-20 -mb-px': open }"
                class="relative bg-lightDark"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2"
                display="none"
              >
                @foreach ($item->children as $child)
                  @if ($child->children)
                    <div
                      x-data="{ open: false }"
                      x-on:click="open = !open"
                      class="relative !ml-0 mt-0 border-t border-grey"
                      @click.stop
                    >
                      <x-mobile-nav-link href="{{ $child->url }}" class="pl-4" :active="$child->active">
                        {!! $child->label !!}
                        <div
                          x-bind:class="{ 'rotate-180': open }"
                          class="absolute right-4 transition-transform duration-200 pointer-events-none z-[50]"
                        >
                          <svg class="[&_path]:group-hover:fill-white -rotate-90" xmlns="http://www.w3.org/2000/svg" width="6" height="7" viewBox="0 0 6 7" fill="none">
                            <path d="M3 5L0 2H6L3 5Z" fill="#000" />
                          </svg>
                        </div>
                      </x-mobile-nav-link>
                    </div>
                  @else
                    <div
                      x-data="{ open: true }"
                      class="relative !ml-0 mt-0 border-t border-grey pl-4"
                      x-transition:enter="transition ease-out duration-300"
                      x-transition:enter-start="opacity-0 transform -translate-y-2"
                      x-transition:enter-end="opacity-100 transform translate-y-0"
                      x-transition:leave="transition ease-in duration-300"
                      x-transition:leave-start="opacity-100 transform translate-y-0"
                      x-transition:leave-end="opacity-0 transform -translate-y-2"
                      display
                    >
                      <x-mobile-nav-link href="{{ $child->url }}" :active="$child->active">
                        {!! $child->label !!}
                      </x-mobile-nav-link>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          @else
            <div x-data="{ open: true }" class="relative !ml-0 mt-0 border-t first:border-t-0 border-grey">
              <x-mobile-nav-link href="{{ $item->url }}" :active="$item->active" class="!ml-0 !mr-5">
                {!! $item->label !!}
              </x-mobile-nav-link>
            </div>
          @endif
        @endforeach
      @endif
    </div>
  </div>
</nav>

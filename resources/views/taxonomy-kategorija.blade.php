@extends('layouts.app')

@section('before-content')
  @include('sections.hero')
  <main class="container py-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-12">
        @while(have_posts())
          @php
            the_post();
            $sizes = get_field('product_sizes');
          @endphp

          <article class="group relative flex flex-col">
            {{-- Image Container --}}
            <div class="overflow-hidden rounded-2xl bg-gray-100 mb-6 relative">
              @if(has_post_thumbnail())
                {!! get_the_post_thumbnail(null, 'large', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105', 'loading' => 'lazy']) !!}
              @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 italic bg-gray-50">
                  Nav attēla
                </div>
              @endif

              {{-- Quick "View" Overlay (Pure CSS, PageSpeed Friendly) --}}
              <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>

            {{-- Product Info --}}
            <div class="flex flex-col flex-grow">
              <h2 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition">
                <a href="{{ get_permalink() }}" class="after:absolute after:inset-0">
                  {{ get_the_title() }}
                </a>
              </h2>

              @if($sizes && !empty($sizes))
                <p class="text-xs text-gray-500 mt-2">
                  Pieejamie izmēri: <span class="font-medium">{{ implode(', ', $sizes) }}</span>
                </p>
              @endif
            </div>

            {{-- Subtle separator line for mobile --}}
            <div class="mt-6 h-px bg-gray-100 sm:hidden"></div>
          </article>
        @endwhile
      </div>

  </main>
@endsection
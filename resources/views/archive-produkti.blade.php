@extends ('layouts.app')

@section ('before-content')
  @include ('sections.hero')

  @php
  $terms = get_terms([
      'taxonomy'   => 'kategorija',
      'hide_empty' => true,
  ]);
  @endphp

  <section class="py-8">
    <div class="container">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @if ($terms && !is_wp_error($terms))
          @foreach ($terms as $term)
            @php
          $link = get_term_link($term);
          $image_id = get_field('kategorijas_bilde', $term);
        @endphp

            <a
              href="{{ $link }}"
              class="group relative block h-[300px] lg:h-[500px] overflow-hidden rounded-3xl shadow-2xl"
            >
              @if ($image_id)
                {!! wp_get_attachment_image($image_id, 'large', false, [
                'class' => 'absolute inset-0 object-cover w-full h-full transition-transform duration-700 group-hover:scale-110 opacity-80',
                'loading' => 'lazy',
                'alt' => $term->name
            ]) !!}
              @else
                <div class="absolute inset-0 bg-gradient-to-br from-gray-700 to-indigo-900 opacity-50"></div>
              @endif

              <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>

              <div class="absolute inset-0 flex flex-col justify-end p-10">
                <div class="transform transition-all duration-500 translate-y-4 group-hover:translate-y-0">
                  <span
                    class="inline-block px-4 py-1.5 mb-4 text-xs font-bold tracking-widest text-black uppercase bg-white/20 backdrop-blur-md rounded-full border border-white/30"
                  >
                    {{ $term->count }} {{ _n('Produkts', 'Produkti', $term->count, 'radicle') }}
                  </span>

                  <h3 class="text-4xl font-extrabold text-black mb-4 tracking-tight">{{ $term->name }}</h3>

                  <div class="flex items-center text-indigo-400 font-bold overflow-hidden">
                    <span
                      class="h-[2px] w-0 bg-indigo-500 transition-all duration-500 group-hover:w-12 mr-0 group-hover:mr-4"
                    ></span>
                    <span
                      class="opacity-0 -translate-x-10 transition-all duration-500 group-hover:opacity-100 group-hover:translate-x-0"
                    >
                      Apskatīt
                    </span>
                  </div>
                </div>
              </div>

              {{-- Glassy Border Highlight --}}
              <div class="absolute inset-0 rounded-3xl border border-white/10 pointer-events-none"></div>
            </a>
          @endforeach
        @endif
      </div>
    </div>
  </section>
@endsection

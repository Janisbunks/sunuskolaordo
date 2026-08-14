<section class="relative min-h-[650px] h-full flex items-center justify-center overflow-hidden">
  <!-- Background Image with Modern Picture Element -->
  <picture class="absolute inset-0 w-full h-full">
    <source srcset="@asset('images/backgrounds/bg-hero.jpg?as=webp')" type="image/webp" />
    <source srcset="@asset('images/backgrounds/bg-hero.jpg')" type="image/jpg" />
    <img
      src="@asset('images/backgrounds/bg-hero.jpg')"
      alt="Hero Background"
      class="w-full h-full object-cover object-center"
      loading="eager"
    />
  </picture>
  <div class="absolute inset-0 bg-black/50"></div>
  <!-- Content container -->
  <div class="relative z-10 w-full mx-auto text-center">
    <div class="rounded-2xl p-4">
      <div>
        @hasfield ('h1')
        <h1 class="text-white text-5xl md:text-6xl lg:text-8xl font-bold leading-tight">
          @field ('h1')
        </h1>
        @elseif (is_archive('produkti'))
        <h1 class="text-white text-5xl md:text-6xl lg:text-8xl font-bold leading-tight">Aprīkojums</h1>
        @elseif (is_home())
        <h1 class="text-white text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">Raksti</h1>
        @else
        <h1 class="text-white text-5xl md:text-6xl lg:text-7xl font-bold leading-tight lg:max-w-[750px] lg:mx-auto">
          @title
        </h1>
        @if (is_page(65))
          <p class="block text-2xl font-normal text-white mt-2">Suņu Trenere &amp; Uzvedības Speciāliste</p>
        @endif
        @endif
      </div>
      @if (is_front_page())
        <div class="space-y-6 mt-6">
          <p class="text-white/90 text-xl md:text-2xl lg:text-3xl font-medium leading-relaxed max-w-3xl mx-auto">Nordarbības Tev un Tavam mīlulim - no maza dinozaura kucēna uz gudru, pieaugušu suni!</p>
          <p class="text-white/80 text-lg md:text-xl lg:text-2xl font-normal">Par saprastu un mīlētu suni!</p>

          <div>
            <a
              href="#nodarbibas"
              class="inline-flex items-center px-8 py-4 bg-white text-black font-semibold rounded-full hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
            >
              Skatīt nodarbības
              <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
              </svg>
            </a>
          </div>
        </div>
      @endif
    </div>
    @if (is_single(59))
      @php
        // Get all locations to count them for grid layout
        $allLocations = [];
        if (have_rows('pamatpaklausibas_nodarbibas', 'option')) {
          while (have_rows('pamatpaklausibas_nodarbibas', 'option')) {
            the_row();
            if (have_rows('single_location')) {
              while (have_rows('single_location')) {
                the_row();
                $allLocations[] = [
                  'title' => get_sub_field('title'),
                  'date' => get_sub_field('date'),
                  'space' => get_sub_field('space'),
                ];
              }
            }
          }
        }

        $locationCount = count($allLocations);

        // Determine grid classes based on count
        if ($locationCount === 2) {
          $gridClass = 'grid gap-6 grid-cols-1 md:grid-cols-2';
        } elseif ($locationCount >= 3) {
          $gridClass = 'grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
        } else {
          $gridClass = 'grid gap-6 grid-cols-1';
        }
      @endphp

      @if (!empty($allLocations))
        <div class="mt-10 max-w-6xl mx-auto">
          <div class="rounded-2xl p-6 md:p-8 bg-black/50 backdrop-blur border border-white/20">
            <!-- Heading -->
            <h2
              class="text-3xl md:text-4xl font-extrabold text-center mb-8 bg-gradient-to-r from-yellow-300 via-pink-300 to-purple-400 bg-clip-text text-white"
            >
              Tuvākais pamatpaklausības kurss grupā
            </h2>

            <!-- Cards -->
            <div class="{{ $gridClass }}">
              @hasoptions ('pamatpaklausibas_nodarbibas')
                @options ('pamatpaklausibas_nodarbibas')
                  @fields ('single_location')
                    <div
                      class="relative overflow-hidden rounded-xl p-6 bg-gradient-to-br from-green-500/20 to-emerald-500/10 border border-green-400/40"
                    >
                      <div class="absolute top-0 right-0 w-24 h-24 bg-green-400/20 rounded-full blur-2xl"></div>

                      @hassub ('title')
                      <p class="text-2xl font-bold text-white mb-1">📍
                      @sub ('title')</p>
                      @endsub

                      @hassub ('date')
                      <p class="text-lg text-white/90">@sub ('date')</p>
                      @endsub

                      @hassub ('space')
                      <span
                        class="inline-block px-4 py-2 rounded-full bg-white/20 text-white font-semibold text-lg border border-white/30"
                      >
                        @sub ('space')
                      </span>
                      @endsub

                      <a
                        href="#formHeading"
                        class="block mt-2 w-fit mx-auto px-4 py-2 rounded-full bg-white text-black font-bold text-lg hover:bg-black hover:text-white transition"
                      >
                        Pieteikties
                      </a>
                    </div>
                  @endfields
                @endoptions
              @endhasoptions
            </div>
          </div>
        </div>
      @endif
    @endif
  </div>

  <!-- Scroll Indicator -->
  @if (is_front_page())
    <div class="absolute bottom-8 left-0 right-0 z-20 animate-bounce">
      <div class="flex justify-center">
        <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
          <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
        </div>
      </div>
    </div>
  @endif
</section>

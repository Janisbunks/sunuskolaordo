<section class="relative min-h-[650px] h-full flex items-center justify-center overflow-hidden">
  <!-- Background Image with Modern Picture Element -->
  <picture class="absolute inset-0 w-full h-full">
    <source srcset="@asset('images/backgrounds/bg-hero.jpg?as=webp')" type="image/webp">
    <source srcset="@asset('images/backgrounds/bg-hero.jpg')" type="image/jpg">
    <img
      src="@asset('images/backgrounds/bg-hero.jpg')"
      alt="Hero Background"
      class="w-full h-full object-cover object-center"
      loading="eager"
    >
  </picture>
  <div class="absolute inset-0 bg-black/50"></div>
  <!-- Content container -->
  <div class="relative z-10 w-full mx-auto text-center">
    <div class="{{ !is_page(65) ? 'border border-white/50' : '' }} rounded-2xl p-4">
      <div>
        @hasfield('h1')
          <h1 class="text-white text-5xl md:text-6xl lg:text-8xl font-bold leading-tight">
            @field('h1')
          </h1>
        @elseif(is_home())
          <h1 class="text-white text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
            Raksti
          </h1>
        @else
          <h1 class="text-white text-5xl md:text-6xl lg:text-7xl font-bold leading-tight lg:max-w-[750px] lg:mx-auto">
            @title
          </h1>
          @if(is_page(65))
            <p class="block text-2xl font-normal text-white mt-2">Suņu Trenere &amp; Uzvedības Speciāliste</p>
          @endif
        @endif
      </div>
      @if(is_front_page())
        <div class="space-y-6 mt-6">
          <p class="text-white/90 text-xl md:text-2xl lg:text-3xl font-medium leading-relaxed max-w-3xl mx-auto">
            Nordarbības Tev un Tavam mīlulim - no maza dinozaura kucēna uz gudru, pieaugušu suni!
          </p>
          <p class="text-white/80 text-lg md:text-xl lg:text-2xl font-normal">
            Par saprastu un mīlētu suni!
          </p>

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
    @if(is_single(59))
  <div class="mt-10 max-w-6xl mx-auto">
    <div class="rounded-2xl p-6 md:p-8 bg-black/50 backdrop-blur border border-white/20">

      <!-- Heading -->
      <h2 class="text-3xl md:text-4xl font-extrabold text-center mb-8
        bg-gradient-to-r from-yellow-300 via-pink-300 to-purple-400
        bg-clip-text text-white">
        Tuvākais pamatpaklausības kurss grupā
      </h2>

      <!-- Cards -->
      <div class="grid gap-6 grid-cols-1 lg:grid-cols-3">
<div class="relative overflow-hidden rounded-xl p-6 bg-gradient-to-br from-green-500/20 to-emerald-500/10 border border-green-400/40">
          <div class="absolute top-0 right-0 w-24 h-24 bg-green-400/20 rounded-full blur-2xl"></div>
            <p class="text-2xl font-bold text-white mb-1">📍 PetCity Viesturdārzs</p>
            <p class="text-lg text-white/90">
              No <strong>04.02</strong> · Trešdienās · <strong>11:00</strong>
            </p>
            <span class="inline-block px-4 py-2 rounded-full bg-white/20 text-white font-semibold text-lg border border-white/30">
              3 brīvas vieta
            </span>
            <a href="#formHeading"
              class="block mt-2 w-fit mx-auto px-4 py-2 rounded-full bg-white text-black font-bold text-lg hover:bg-black hover:text-white transition"
            >
              Pieteikties
            </a>
        </div>
        <!-- Ogre -->
        <div class="relative overflow-hidden rounded-xl p-6 bg-gradient-to-br from-green-500/20 to-emerald-500/10 border border-green-400/40">
          <div class="absolute top-0 right-0 w-24 h-24 bg-green-400/20 rounded-full blur-2xl"></div>
            <p class="text-2xl font-bold text-white mb-1">📍 Ogre</p>
            <p class="text-lg text-white/90">
              No <strong>30.01</strong> · Piektdienās · <strong>18:30</strong>
            </p>
            <span class="inline-block px-4 py-2 rounded-full bg-white/20 text-white font-semibold text-lg border border-white/30">
              4 brīvas vietas
            </span>
            <a href="#formHeading"
              class="block mt-2 w-fit mx-auto px-4 py-2 rounded-full bg-white text-black font-bold text-lg hover:bg-black hover:text-white transition"
            >
              Pieteikties
            </a>
        </div>

        <!-- Kekava -->
        <div class="relative overflow-hidden rounded-xl p-6
                    bg-gradient-to-br from-blue-500/20 to-indigo-500/10
                    border border-blue-400/40">
          <div class="absolute top-0 right-0 w-24 h-24 bg-blue-400/20 rounded-full blur-2xl"></div>

          <p class="text-2xl font-bold text-white mb-1">📍 Ķekava</p>
          <p class="text-lg text-white/90">
            No <strong>09.02</strong> · Pirmdienās · <strong>18:30</strong>
          </p>

          <span class="inline-block px-4 py-2 rounded-full bg-white/20 text-white font-semibold text-lg border border-white/30">
  1 brīva vietas
</span>

<a href="#formHeading"
   class="block mt-2 w-fit mx-auto px-4 py-2 rounded-full bg-white text-black font-bold text-lg hover:bg-black hover:text-white transition"
>
  Pieteikties
</a>
        </div>

      </div>
    </div>
  </div>
@endif
  </div>

  <!-- Breadcrumb for Non-Front Pages -->
  @if(!is_front_page())
    <div class="absolute bottom-8 left-0 right-0 z-20">
      <div class="container px-4 mx-auto">
        <x-breadcrumb />
      </div>
    </div>
  @endif

  <!-- Scroll Indicator -->
  @if(is_front_page())
    <div class="absolute bottom-8 left-0 right-0 z-20 animate-bounce">
      <div class="flex justify-center">
        <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
          <div class="w-1 h-3 bg-white/70 rounded-full mt-2 animate-pulse"></div>
        </div>
      </div>
    </div>
  @endif
</section>
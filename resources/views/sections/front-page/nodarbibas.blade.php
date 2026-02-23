@query([
  'post_type' => 'nodarbibas',
  'posts_per_page' => -1,
  'orderby' => 'date',
  'order'   => 'ASC',
])
<section class="py-16 lg:py-24 relative overflow-hidden" id="nodarbibas">
  <!-- Modern background elements -->
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

  <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Modern header section -->
      <div class="text-center mb-16">
        <div class="inline-flex items-center space-x-2 text-white/90 font-medium text-sm uppercase tracking-wider mb-4">
          <span class="w-8 h-px bg-white/90"></span>
          <span>Mūsu Pakalpojumi</span>
          <span class="w-8 h-px bg-white/90"></span>
        </div>
        <h2 class="text-4xl lg:text-5xl font-bold text-white/90 leading-tight mb-6">
          Nodarbību piedāvājums
        </h2>
        <p class="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
          Profesionālas suņu apmācības un socializācijas nodarbības, kas palīdzēs jūsu četrkājainajam draugam kļūt par labāko versiju
        </p>
      </div>

      @hasposts
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
        @posts
        @php
          global $post;
          $permalink = get_permalink($post->ID);
        @endphp

        <!-- Modern card design -->
        <div class="group relative">
          <a
            class="block bg-white rounded-2xl p-6 h-full shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-black/10 hover:border-blue-400/30 relative overflow-hidden"
            title="@title"
            aria-label="@title"
            href="@permalink"
            style="box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.2), 0 10px 10px -5px rgba(59, 130, 246, 0.1);"
          >
            <!-- Card background gradient on hover -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

            <!-- Content wrapper -->
            <div class="relative z-10">
              <!-- Icon section -->
              <div class="mb-4 flex justify-center">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                  <div class="text-xl text-black">
                    @field('svg')
                  </div>
                </div>
              </div>

              <!-- Title -->
              <h3 class="text-lg font-bold text-black mb-3 text-center transition-colors duration-300">
                @title
              </h3>

              <!-- Description -->
              <p class="text-black font-extrabold text-xs mb-4 leading-relaxed text-center">
                @field('description')
              </p>

              <!-- Pricing section -->
              <div class="text-center space-y-1">
                <div class="text-xl font-bold text-black mb-1">
                  @field('pricing')
                </div>
                <p class="text-xs text-gray-400 font-medium">
                  @field('subtitle')
                </p>
              </div>

              <!-- Hover indicator -->
              <div class="mt-4 flex justify-center">
                <div class="w-6 h-6 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                  <svg class="w-3 h-3 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </div>
              </div>
            </div>
          </a>
        </div>
        @endposts
      </div>
      @endhasposts

      <!-- Call to action section -->
      <div class="text-center mt-16 w-fit mx-auto">
        <div class="bg-white rounded-2xl p-8 shadow-lg border border-white/10">
          <h3 class="text-2xl font-bold text-black mb-4">
            Vai vēlaties uzzināt vairāk?
          </h3>
          <p class="text-black mb-6 max-w-2xl mx-auto">
            Sazinieties ar mums, lai noskaidrotu, kura nodarbība ir vispiemērotākā jūsu suņa vajadzībām
          </p>
          <!-- From Uiverse.io by Mubashir222 -->
          <a href="{{get_permalink(52)}}"
          class="relative inline-flex items-center justify-center px-8 py-2.5 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-md group"
          >
          <span
            class="absolute w-0 h-0 transition-all duration-500 ease-out bg-orange-400 rounded-full group-hover:w-56 group-hover:h-56"
          ></span>
          <span class="absolute bottom-0 left-0 h-full -ml-2">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-auto h-full opacity-100 object-stretch"
              viewBox="0 0 487 487"
            >
              <path
                fill-opacity=".1"
                fill-rule="nonzero"
                fill="#FFF"
                d="M0 .3c67 2.1 134.1 4.3 186.3 37 52.2 32.7 89.6 95.8 112.8 150.6 23.2 54.8 32.3 101.4 61.2 149.9 28.9 48.4 77.7 98.8 126.4 149.2H0V.3z"
              ></path>
            </svg>
          </span>
          <span class="absolute top-0 right-0 w-12 h-full -mr-3">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="object-cover w-full h-full"
              viewBox="0 0 487 487"
            >
              <path
                fill-opacity=".1"
                fill-rule="nonzero"
                fill="#FFF"
                d="M487 486.7c-66.1-3.6-132.3-7.3-186.3-37s-95.9-85.3-126.2-137.2c-30.4-51.8-49.3-99.9-76.5-151.4C70.9 109.6 35.6 54.8.3 0H487v486.7z"
              ></path>
            </svg>
          </span>
          <span
            class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-gray-200"
          ></span>
          <span class="relative text-base font-semibold">Uzraksti man ziņu!</span>
        </a>
        </div>
      </div>
    </div>
  </div>
</section>
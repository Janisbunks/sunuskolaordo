@query('posts', 'post', 'post_type=post')
<section class="py-16 relative bg-gradient-to-br from-gray-50 to-white overflow-hidden">
  <!-- Subtle background elements -->
  <div class="absolute inset-0">
    <div class="absolute top-0 right-0 w-64 h-64 bg-blue-100/30 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-orange-100/20 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>
  </div>

  <div class="{{$container}} relative z-10">
    <!-- Modern header -->
    <div class="text-center mb-12">
      <div class="inline-flex items-center space-x-2 text-orange-600 font-medium text-sm uppercase tracking-wider mb-4">
        <span class="w-8 h-px bg-orange-400"></span>
        <span>Mūsu Raksti</span>
        <span class="w-8 h-px bg-orange-400"></span>
      </div>
      <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-4">
        Jaunākie Raksti
      </h2>
      <p class="text-lg text-gray-600 max-w-2xl mx-auto">
        Noderīgi padomi un informācija par suņu apmācību un uzvedību
      </p>
    </div>

    <!-- Blog grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
      @hasposts
        @posts
        <a href="@permalink" class="group block bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-200" title="@title" aria-label="@title">
          <!-- Image container -->
          <div class="relative overflow-hidden aspect-[4/3]">
            @thumbnail('w-full h-full object-cover transition-transform duration-500 group-hover:scale-105')
            <!-- Category badge -->
            <div class="absolute top-4 left-4 z-20">
              <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/90 backdrop-blur-sm text-gray-700">
                Raksts
              </span>
            </div>
          </div>

          <!-- Content -->
          <div class="p-6">
            <!-- Date -->
            <time class="text-sm text-gray-500 mb-3 block">
              @published('j. F Y')
            </time>

            <!-- Title -->
            <h3 class="text-xl font-bold text-center text-gray-900 mb-3 line-clamp-2 group-hover:text-orange-600 transition-colors duration-300">
              @title
            </h3>

            <!-- Excerpt -->
            <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
              {{ Str::limit(strip_tags(get_the_excerpt()), 120) }}
            </p>

            <!-- Read more link -->
            <div class="flex items-center justify-between">
              <span class="text-orange-600 font-medium text-sm group-hover:text-orange-700 transition-colors duration-300">
                Lasīt vairāk
              </span>
              <svg class="w-4 h-4 text-orange-600 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </div>
          </div>
        </a>
        @endposts
      @endhasposts
    </div>

    <!-- View all posts button -->
    @hasposts
    <div class="pt-4 text-center">
      <a href="/raksti/"
      class="relative inline-flex items-center justify-center px-8 py-2.5 overflow-hidden tracking-tighter text-white bg-gray-800 rounded-md group"
      >
      <span
        class="absolute w-0 h-0 transition-all duration-500 ease-out bg-orange-600 rounded-full group-hover:w-56 group-hover:h-56"
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
      <span class="relative text-base font-semibold">Skatīt Visus Rakstus</span>
    </a>
    </div>
    @endhasposts
  </div>
</section>

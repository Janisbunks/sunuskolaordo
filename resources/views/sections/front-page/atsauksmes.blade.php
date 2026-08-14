<section class="py-8 relative overflow-hidden">
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
  <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="text-center mb-8">
        <div class="inline-flex items-center space-x-2 text-white/90 font-medium text-sm uppercase tracking-wider mb-4">
          <span class="w-8 h-px bg-white/90"></span>
          <span>Klientu Atsauksmes</span>
          <span class="w-8 h-px bg-white/90"></span>
        </div>
        <h2 class="text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">Atsauksmes</h2>
        <p class="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">Ko mūsu klienti saka par mūsu suņu apmācības pakalpojumiem un rezultātiem</p>
      </div>
      <div class="relative">
        @hasoption ('atsauksmes')
        @options ('atsauksmes')
          <div class="swiper swiper-atsauksmes lg:max-w-3xl xl:max-w-5xl mx-auto">
            <div class="swiper-wrapper">
              @options ('atsauksme_single')
                <div class="swiper-slide bg-white/80 rounded-2xl p-4">
                  <div class="flex justify-center mb-6">
                    <div
                      class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center"
                    >
                      <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                      </svg>
                    </div>
                  </div>
                  <div class="text-center">
                    <div class="text-black text-lg md:text-xl leading-relaxed italic [&_p]:mb-2.5">
                      @sub ('description')
                    </div>
                  </div>
                </div>
              @endoptions
            </div>
          </div>
          <div class="swiper-button-prev hidden md:block"><x-icon-swiper-arrow-left /></div>
          <div class="swiper-button-next hidden md:block"><x-icon-swiper-arrow-right /></div>
        @endoptions
        @endhasoptions
      </div>
    </div>
  </div>
</section>

@push ('after-scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const swiper = new Swiper('.swiper-atsauksmes', {
        direction: 'horizontal',
        loop: true,
        spaceBetween: 40,
        autoHeight: true,
        slidesPerView: 1,
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      });
    });
  </script>
@endpush

<section class="py-6 relative bg-gradient-to-br from-rose-50 via-pink-50 to-fuchsia-50 overflow-hidden">
  <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Modern header section -->
      <div class="text-center mb-4 lg:mb-16">
        <div
          class="inline-flex items-center space-x-2 text-orange-400 font-medium text-sm uppercase tracking-wider mb-4"
        >
          <span class="w-8 h-px bg-orange-400"></span>
          <span>Sazināties</span>
          <span class="w-8 h-px bg-orange-400"></span>
        </div>
        <h2 id="formHeading" class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
          @if (is_single(59))
            PIETEIKTIES NODARBĪBĀM
          @else
            Uzraksti man ziņu!
          @endif
        </h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">Sazinieties ar mani, lai noskaidrotu vairāk par suņu apmācības pakalpojumiem</p>
      </div>
      <div class="relative group max-w-[800px] w-full mx-auto">
        <div
          class="bg-white/80 backdrop-blur-sm rounded-2xl p-4 shadow-xl border border-white/20 hover:border-rose-200/50 transition-all duration-300"
        >
          <div
            class="absolute inset-0 bg-gradient-to-br from-rose-50/50 to-pink-50/50 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"
          ></div>

          <div class="relative z-10">
            <div class="space-y-6">
              @if (is_single(59))
                {!! do_shortcode('[contact-form-7 id="6235fcd" title="Pieteikumu Forma Pamatpaklausibas nodarbibam"]') !!}
              @else
                {!! do_shortcode('[contact-form-7 id="1c40f1b" title="Pieteikumu Forma"]') !!}
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

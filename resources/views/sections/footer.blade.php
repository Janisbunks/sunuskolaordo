<footer class="py-8 relative bg-black overflow-hidden" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 50%, #020617 100%);">
  <!-- Modern background elements -->
  <div class="absolute inset-0">
    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-bl from-blue-400/10 to-indigo-400/10 rounded-full blur-3xl translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-gradient-to-tr from-indigo-400/8 to-blue-400/8 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>
    <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-gradient-to-r from-blue-300/5 to-indigo-300/5 rounded-full blur-2xl -translate-x-1/2 -translate-y-1/2"></div>
  </div>

  <div class="{{ $container }} relative z-10">
    <!-- Main footer content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
      <!-- Logo and social media section -->
      <div class="lg:col-span-6">
        <div class="space-y-6">
          <x-logo type="primary" class="[&_img]:max-h-[90px] [&_img]:filter [&_img]:brightness-0 [&_img]:invert"/>
          <p class="text-gray-300 leading-relaxed">
            Profesionāla suņu apmācība un uzvedības korekcija. Palīdzam jums un jūsu mīlulim kļūt par labāko komandu!
          </p>
          <div class="flex gap-4 items-center">
            <x-social-media />
          </div>
        </div>
      </div>

      <!-- Navigation section -->
      <div class="lg:col-span-3">
        <div class="space-y-6">
          <h3 class="text-white text-xl font-bold mb-6 relative">
            Navigācija
            <div class="absolute bottom-0 left-0 w-12 h-0.5 bg-gradient-to-r from-orange-500 to-red-500"></div>
          </h3>
          @include('partials.footer-menu')
        </div>
      </div>

      <!-- Contact section -->
      <div class="lg:col-span-3">
        <div class="space-y-6">
          <h3 class="text-white text-xl font-bold mb-6 relative">
            Kontakti
            <div class="absolute bottom-0 left-0 w-12 h-0.5 bg-gradient-to-r from-orange-500 to-red-500"></div>
          </h3>
          <div class="space-y-3">
            <a
              class="text-gray-300 hover:text-white group flex items-center gap-3 transition-all duration-300 hover:translate-x-1"
              href="tel:{{str_replace(' ', '', trim(get_field('contact_information', 'option')['phone_number']))}}"
              title="Zvaniet Man!"
              aria-label="Zvaniet Man!"
            >
              <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                <svg class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
              </div>
              <span class="font-medium">{{ get_field('contact_information', 'option')['phone_number']; }}</span>
            </a>

            <a
              class="text-gray-300 hover:text-white group flex items-center gap-3 transition-all duration-300 hover:translate-x-1"
              href="mailto:sunuskolaordo@inbox.lv"
              title="Sūtiet mums ziņu!"
              aria-label="Sūtiet mums ziņu!"
            >
              <div class="w-6 h-6 bg-gradient-to-r from-orange-500 to-red-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                <svg class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
              </div>
              <span class="font-medium">sunuskolaordo@inbox.lv</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Divider -->
    <div class="border-t border-gray-800 my-4"></div>

    <!-- Copyright section -->
    <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-gray-400">
      <div class="flex items-center gap-2">
        <p class="mb-0">© {{ date('Y') }} {!! $siteName !!}</p>
      </div>
      <div class="flex items-center gap-6 text-sm">
        <a href="@permalink(52)" class="hover:text-white transition-colors duration-300">Kontakti</a>
        <span class="text-gray-600">•</span>
        <a href="#" class="hover:text-white transition-colors duration-300">Privātuma politika</a>
      </div>
    </div>
  </div>

  {{-- Floating Cart Button --}}
  @include('partials.floating-cart')

  {{-- Order Success Modal --}}
  @if(isset($_GET['order_success']) && $_GET['order_success'] == '1')
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50"
         style="display: none;">

      <div x-show="show"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 scale-90"
           x-transition:enter-end="opacity-100 scale-100"
           x-transition:leave="transition ease-in duration-200"
           x-transition:leave-start="opacity-100 scale-100"
           x-transition:leave-end="opacity-0 scale-90"
           @click.away="show = false"
           class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative">

        {{-- Close button --}}
        <button @click="show = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        {{-- Success Icon --}}
        <div class="flex justify-center mb-6">
          <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center">
            <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
        </div>

        {{-- Title --}}
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-4">Paldies!</h2>

        {{-- Message --}}
        <div class="text-center space-y-3 mb-8">
          <p class="text-lg text-gray-700">
            Jūsu pasūtījums ir veiksmīgi iesniegts!
          </p>
          <p class="text-gray-600">
            Rēķins ir nosūtīts uz jūsu e-pastu.
          </p>
          <p class="text-gray-600">
            Sazināsimies ar jums <strong class="text-emerald-600">1-2 darba dienu</strong> laikā, lai apstiprinātu pasūtījumu un piegādes detaļas.
          </p>
        </div>

        {{-- Action Buttons --}}
        <div class="space-y-3">
          <a href="{{ url('/produkti') }}"
             class="block w-full bg-emerald-600 text-white text-center py-3 rounded-xl font-semibold hover:bg-emerald-700 transition">
            Turpināt Iepirkties
          </a>
          <button @click="show = false"
                  class="block w-full bg-gray-100 text-gray-700 text-center py-3 rounded-xl font-semibold hover:bg-gray-200 transition">
            Aizvērt
          </button>
        </div>

      </div>
    </div>
  @endif
</footer>

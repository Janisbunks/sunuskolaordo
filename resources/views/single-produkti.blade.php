@extends('layouts.app')

@section('before-content')
  @include('sections.hero')
  @while(have_posts())
    @php
      the_post();

      // Get size/price variants from options
      $productVariant = get_field('product_variant', 'option');
      $variants = $productVariant['variant'] ?? [];
      $variantMap = collect($variants)->keyBy('size')->toArray();

      // Get selected sizes for this product
      $sizes = get_field('product_sizes');
    @endphp

    <script>
      function productData() {
        return {
          selectedSize: '',
          quantity: 1,
          variants: {},
          showToast: false,
          toastMessage: '',
          cartUrl: '',

          init(url, variants) {
            this.cartUrl = url;
            this.variants = variants;
          },

          get currentPrice() {
            if (!this.selectedSize || !this.variants[this.selectedSize]) {
              return 0;
            }
            return parseFloat(this.variants[this.selectedSize].price) || 0;
          },

          get totalPrice() {
            return (this.currentPrice * this.quantity).toFixed(2);
          },

          incrementQuantity() {
            this.quantity++;
          },

          decrementQuantity() {
            if (this.quantity > 1) {
              this.quantity--;
            }
          },

          async addToCart(event) {
            event.preventDefault();

            if (!this.selectedSize) {
              this.showToastMessage('Lūdzu, izvēlies izmēru!', 'error');
              return;
            }

            const formData = new FormData(event.target);
            formData.append('action', 'add_to_cart');
            formData.set('quantity', this.quantity);
            formData.set('size', this.selectedSize);

            try {
              const response = await fetch(this.cartUrl, {
                method: 'POST',
                body: formData
              });

              const data = await response.json();

              if (data.success) {
                this.showToastMessage('Pievienots grozā!', 'success');
                window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.data.cart }));
              } else {
                this.showToastMessage(data.data?.message || 'Kļūda!', 'error');
              }
            } catch (error) {
              console.error('Cart error:', error);
              this.showToastMessage('Kļūda pievienojot grozam!', 'error');
            }
          },

          showToastMessage(message, type = 'success') {
            this.toastMessage = message;
            this.showToast = true;
            setTimeout(() => {
              this.showToast = false;
            }, 3000);
          }
        }
      }
    </script>

    <div class="bg-white min-h-screen"
         x-data="{
           ...productData(),
           showSizeTable: false
         }"
         data-variants="{{ base64_encode(json_encode($variantMap)) }}"
         data-cart-url="{{ admin_url('admin-ajax.php') }}"
         x-init="init($el.dataset.cartUrl, JSON.parse(atob($el.dataset.variants)))"
         @open-size-table.window="showSizeTable = true">

        {{-- Toast Notification --}}
        <div x-show="showToast"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="fixed top-6 right-6 z-50 bg-emerald-600 text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3"
            style="display: none;">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span x-text="toastMessage" class="font-medium"></span>
        </div>

        {{-- Size Table Modal --}}
        <div x-show="showSizeTable"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="showSizeTable = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75"
            style="display: none;">
          <div @click.stop
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 scale-95"
               x-transition:enter-end="opacity-100 scale-100"
               x-transition:leave="transition ease-in duration-200"
               x-transition:leave-start="opacity-100 scale-100"
               x-transition:leave-end="opacity-0 scale-95"
               class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full relative">
            <button @click="showSizeTable = false"
                    class="absolute top-4 right-4 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition z-10">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
            <div class="p-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-4">Izmēru tabula</h3>
              <img src="{{ home_url('/content/uploads/2026/04/ordo-izmeru-tabula.jpg') }}"
                   alt="Izmēru tabula"
                   class="w-full h-auto rounded-lg">
            </div>
          </div>
        </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16">

        <div class="grid lg:grid-cols-2 gap-8 lg:gap-16">

          {{-- LEFT: Product Image --}}
          <div class="lg:sticky lg:top-8 h-fit">
            <div class="aspect-square w-full max-w-[400px] md:only:max-w-[500px] overflow-hidden rounded-2xl bg-gray-50 mx-auto">
              @if(has_post_thumbnail())
                {!! get_the_post_thumbnail(null, 'large', [
                  'class' => 'w-full h-full object-cover',
                  'loading' => 'eager'
                ]) !!}
              @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                  <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                  </svg>
                </div>
              @endif
            </div>
          </div>

          {{-- RIGHT: Product Info --}}
          <div class="flex flex-col">

              {{-- Product Title --}}
              <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-3">
                {{ get_the_title() }}
              </h1>

              {{-- Dynamic Price --}}
              <div class="mb-6">
                <div x-show="selectedSize && currentPrice > 0" x-cloak>
                  <div class="text-4xl font-bold text-black mb-1" x-text="totalPrice + ' €'"></div>
                  <div class="text-sm text-gray-500">
                    <span x-text="currentPrice.toFixed(2) + ' €'"></span> × <span x-text="quantity"></span>
                  </div>
                </div>
                <div x-show="!selectedSize" x-cloak>
                  <div class="text-2xl font-medium text-gray-400">Izvēlies izmēru</div>
                </div>
              </div>

              {{-- Description --}}
              @if(get_the_content())
                {!! the_content() !!}
              @endif

              {{-- Selection Form --}}
              <form x-on:submit="addToCart($event)" class="space-y-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ get_the_ID() }}">

                {{-- Sizes --}}
                @if($sizes)
                  <div>
                    <div class="flex items-center justify-between mb-3">
                      <label class="block text-sm font-bold text-gray-900">Izmēri</label>
                      <button type="button"
                              @click="$dispatch('open-size-table')"
                              class="text-sm text-black font-bold hover:text-emerald-700 underline">
                        Skatīt izmēru tabulu
                      </button>
                    </div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                      @foreach($sizes as $size)
                        @php
                          $variant = $variantMap[$size] ?? null;
                          $sizePrice = $variant['price'] ?? '';
                        @endphp
                        <label class="cursor-pointer">
                          <input type="radio"
                            name="size"
                            value="{{ $size }}"
                            x-model="selectedSize"
                            class="sr-only">
                          <div class="h-full flex flex-col items-center justify-center px-4 py-3 rounded-lg border-2 transition-all duration-150"
                                :class="selectedSize === '{{ $size }}' ? 'border-black bg-black text-white' : 'border-gray-200 bg-white text-black hover:border-gray-300'">
                            <span class="text-sm font-bold">{{ $size }}</span>
                            @if($sizePrice)
                              <span class="text-xs mt-0.5 opacity-80">{{ $sizePrice }}€</span>
                            @endif
                          </div>
                        </label>
                      @endforeach
                    </div>
                  </div>
                @endif

                {{-- Quantity --}}
                <div>
                  <label class="block text-sm font-semibold text-gray-900 mb-3">Daudzums</label>
                  <div class="inline-flex items-center overflow-hidden border border-gray-400 rounded-2xl">
                    <button type="button"
                            @click="decrementQuantity()"
                            class="px-4 py-2 hover:bg-gray-50 transition-colors text-gray-600 hover:text-gray-900">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </button>
                    <input type="number"
                      name="quantity"
                      x-model="quantity"
                      min="1"
                      class="text-center py-2 text-sm font-semibold border-0">
                    <button type="button"
                            @click="incrementQuantity()"
                            class="px-4 py-2 hover:bg-gray-50 transition-colors text-gray-600 hover:text-gray-900">
                      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                  </div>
                </div>

                {{-- Add to Cart Button --}}
                <button type="submit"
                        class="w-full text-white bg-black py-4 px-8 rounded-lg font-semibold hover:bg-white hover:text-black border hover:border-black transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="!selectedSize">
                  Pievienot Grozam
                </button>
              </form>

            </div>
          </div>

        </div>
      </div>
    </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  @endwhile
@endsection
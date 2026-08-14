{{--
  Template Name: Checkout
--}}

@php
if (!session_id()) {
    session_start();
}

// Get cart from session
$cart = $_SESSION['cart'] ?? [];
$grandTotal = 0;

// Prepare cart items with product details
$cartItems = [];
foreach ($cart as $cartKey => $item) {
    $productId = $item['product_id'];
    $product = get_post($productId);

    if ($product) {
        $cartItems[] = [
            'cart_key' => $cartKey,
            'product_id' => $productId,
            'name' => $product->post_title,
            'size' => $item['size'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'subtotal' => $item['price'] * $item['quantity'],
            'thumbnail' => get_the_post_thumbnail_url($productId, 'thumbnail')
        ];

        $grandTotal += $item['price'] * $item['quantity'];
    }
}
@endphp

@extends ('layouts.app')

@section ('content')
  <div
    class="bg-gray-50 min-h-screen py-12"
    x-data="{
    deliveryMethod: '',
    deliveryCost: 0,
    isProcessing: false,

    get subtotal() {
        return {{ $grandTotal }};
    },

    get total() {
        return (this.subtotal + this.deliveryCost).toFixed(2);
    },

    updateDeliveryCost() {
        const costs = {
            'salaspils': 0,
            'vienojoties': 0,
            'omniva': 3.20
        };
        this.deliveryCost = costs[this.deliveryMethod] || 0;
    },

    async handleFormSubmit(event) {
        event.preventDefault(); // Prevent default form submission

        this.isProcessing = true; // Show loading state

        const form = event.target;
        const formData = new FormData(form);

        try {
            // Submit form to PDF generation endpoint
            const response = await fetch('{{ home_url('/pdf-invoice.php') }}', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                throw new Error('Failed to process order');
            }

            // Clear cart via AJAX
            const clearFormData = new FormData();
            clearFormData.append('action', 'clear_cart');

            await fetch('{{ admin_url('admin-ajax.php') }}', {
                method: 'POST',
                body: clearFormData
            });

            // Dispatch cart-updated event to clear floating cart
            window.dispatchEvent(new CustomEvent('cart-updated', { detail: {} }));

            // Clear localStorage
            localStorage.removeItem('shopping_cart');

            // Redirect to show success modal
            window.location.href = '{{ url('/') }}?order_success=1';

        } catch (error) {
            console.error('Error processing order:', error);
            this.isProcessing = false; // Hide loading state
            alert('Kļūda apstrādājot pasūtījumu. Lūdzu mēģiniet vēlreiz.');
        }
    }
}"
  >
    <div class="max-w-5xl mx-auto px-6">
      <h1 class="text-4xl font-bold mb-8 text-gray-900">Pasūtījuma Noformēšana</h1>

      @if (empty($cart))
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
          <h2 class="text-2xl font-semibold text-gray-700 mb-2">Jūsu grozs ir tukšs</h2>
          <p class="text-gray-500 mb-6">Pievienojiet produktus, lai turpinātu</p>
          <a
            href="{{ url('/produkti') }}"
            class="inline-block bg-emerald-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-emerald-700 transition"
          >
            Apskatīt Produktus
          </a>
        </div>
      @else
        <div class="grid lg:grid-cols-2 gap-8">
          {{-- Left: Order Summary --}}
          <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
              <h2 class="text-2xl font-bold mb-6 text-gray-900">Jūsu Pasūtījums</h2>

              <div class="space-y-4 mb-6">
                @foreach ($cartItems as $item)
                  <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-b-0">
                    {{-- Thumbnail --}}
                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                      @if ($item['thumbnail'])
                        <img
                          src="{{ $item['thumbnail'] }}"
                          alt="{{ $item['name'] }}"
                          class="w-full h-full object-cover"
                        />
                      @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                          <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                          </svg>
                        </div>
                      @endif
                    </div>

                    {{-- Item Details --}}
                    <div class="flex-1">
                      <h3 class="font-semibold text-gray-900">{{ $item['name'] }}</h3>
                      <p class="text-sm text-gray-500">Izmērs: <span class="font-medium">{{ $item['size'] }}</span></p>
                      <p class="text-sm text-gray-500">Daudzums: <span class="font-medium">{{ $item['quantity'] }}</span></p>
                    </div>

                    {{-- Price --}}
                    <div class="text-right">
                      <p class="text-lg font-bold text-gray-900">{{ number_format($item['subtotal'], 2) }} €</p>
                      <p class="text-xs text-gray-500">{{ $item['price'] }} € × {{ $item['quantity'] }}</p>
                    </div>
                  </div>
                @endforeach
              </div>

              {{-- Total --}}
              <div class="border-t border-gray-200 pt-4 space-y-3">
                <div class="flex justify-between items-center text-gray-700">
                  <span class="font-medium">Preces:</span>
                  <span class="font-semibold">{{ number_format($grandTotal, 2) }} €</span>
                </div>
                <div class="flex justify-between items-center text-gray-700" x-show="deliveryCost > 0">
                  <span class="font-medium">Piegāde:</span>
                  <span class="font-semibold" x-text="deliveryCost.toFixed(2) + ' €'"></span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                  <span class="text-lg font-semibold text-gray-900">Kopā:</span>
                  <span class="text-3xl font-bold text-emerald-600" x-text="total + ' €'"
                    >{{ number_format($grandTotal, 2) }} €</span
                  >
                </div>
              </div>
            </div>
          </div>

          {{-- Right: Customer Form --}}
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-900">Jūsu Informācija</h2>

            <form
              method="post"
              action="{{ home_url('/pdf-invoice.php') }}"
              class="space-y-6"
              @submit="handleFormSubmit($event)"
            >
              <input type="hidden" name="delivery_cost" :value="deliveryCost" />
              <input type="hidden" name="total" :value="total" />
              <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Vārds, Uzvārds *</label>
                <input
                  type="text"
                  id="name"
                  name="name"
                  required
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition"
                />
              </div>

              <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">E-pasta Adrese *</label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  required
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition"
                />
              </div>

              <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Telefona Numurs *</label>
                <input
                  type="tel"
                  id="phone"
                  name="phone"
                  required
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition"
                />
              </div>

              <div>
                <label for="delivery_method" class="block text-sm font-semibold text-gray-700 mb-2"
                  >Piegādes Veids *</label
                >
                <select
                  id="delivery_method"
                  name="delivery_method"
                  x-model="deliveryMethod"
                  @change="updateDeliveryCost()"
                  required
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:ring-0 transition appearance-none bg-white bg-no-repeat bg-right pr-10"
                  style="
                    background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E&quot;);
                    background-size: 1.5em;
                    background-position: right 0.5rem center;
                  "
                >
                  <option value="" disabled selected>Izvēlieties piegādes veidu...</option>
                  <option value="salaspils">Izņemšana Salaspilī - 0.00 €</option>
                  <option value="vienojoties">
                    Vienojoties par izņemšanu konkrētās dienās Ikšķilē, Ogrē, Ķekavā - 0.00 €
                  </option>
                  <option value="omniva">Sūtīšana ar Omniva uz jūsu izvēlēto pakomātu no 3.20 EUR</option>
                </select>
              </div>

              <div class="pt-4">
                <button
                  type="submit"
                  :disabled="isProcessing"
                  class="w-full bg-emerald-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-emerald-700 transition shadow-lg shadow-emerald-100 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-3"
                  :class="{ 'opacity-50 cursor-not-allowed': isProcessing }"
                >
                  <svg x-show="
                      isProcessing
                    " class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span x-text="isProcessing ? 'Apstrādā pasūtījumu...' : 'Ģenerēt Rēķinu (PDF)'"></span>
                </button>
                <p class="text-xs text-gray-500 mt-3 text-center">Pēc pogas nospiešanas tiks ģenerēts PDF rēķins ar pasūtījuma detaļām</p>
              </div>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100">
              <a
                href="{{ url('grozs') }}"
                class="text-emerald-600 hover:text-emerald-700 font-semibold text-sm flex items-center gap-2"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Atpakaļ uz Grozu
              </a>
            </div>
          </div>
        </div>

      @endif
    </div>
  </div>
@endsection

{{--
  Template Name: Grozs
--}}

@php
if (!session_id()) {
    session_start();
}

// Initialize cart structure
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get cart from session
$cart = $_SESSION['cart'] ?? [];

// Get size/price variants from options
$productVariant = get_field('product_variant', 'option');
$allVariants = $productVariant['variant'] ?? [];
$variantMap = collect($allVariants)->keyBy('size')->toArray();

// Prepare product data for each cart item
$productData = [];
foreach ($cart as $cartKey => $item) {
    $productId = $item['product_id'];
    $productData[$cartKey] = [
        'title' => get_the_title($productId),
        'image' => get_the_post_thumbnail_url($productId, 'medium') ?: '',
    ];
}

// Handle AJAX add to cart
if (request()->get('ajax') && request()->method() === 'POST') {
    header('Content-Type: application/json');

    $productId = (int) request()->input('product_id');
    $size = sanitize_text_field(request()->input('size'));
    $quantity = max(1, (int) request()->input('quantity'));

    // Get price for this size from options
    $price = $variantMap[$size]['price'] ?? 0;

    if ($productId && $size && $price) {
        $cartKey = $productId . '_' . $size;

        // Add or update cart item
        if (isset($_SESSION['cart'][$cartKey])) {
            $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$cartKey] = [
                'product_id' => $productId,
                'size' => $size,
                'quantity' => $quantity,
                'price' => $price
            ];
        }

        echo json_encode([
            'success' => true,
            'message' => 'Pievienots grozā!',
            'cart' => $_SESSION['cart'],
            'count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Nederīgi dati!'
        ]);
    }
    exit;
}

// Handle AJAX update quantity
if (request()->get('action') === 'update_quantity' && request()->method() === 'POST') {
    header('Content-Type: application/json');

    $cartKey = sanitize_text_field(request()->input('cart_key'));
    $quantity = max(1, (int) request()->input('quantity'));

    if (isset($_SESSION['cart'][$cartKey])) {
        $_SESSION['cart'][$cartKey]['quantity'] = $quantity;

        echo json_encode([
            'success' => true,
            'cart' => $_SESSION['cart'],
            'count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

// Handle AJAX remove item
if (request()->get('action') === 'remove_item' && request()->method() === 'POST') {
    header('Content-Type: application/json');

    $cartKey = sanitize_text_field(request()->input('cart_key'));

    if (isset($_SESSION['cart'][$cartKey])) {
        unset($_SESSION['cart'][$cartKey]);

        echo json_encode([
            'success' => true,
            'cart' => $_SESSION['cart'],
            'count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

// Handle AJAX clear cart
if (request()->get('action') === 'clear_cart' && request()->method() === 'POST') {
    header('Content-Type: application/json');
    $_SESSION['cart'] = [];
    echo json_encode(['success' => true]);
    exit;
}
@endphp

@extends ('layouts.app')

@section ('content')
  <div
    class="bg-gray-50 min-h-screen py-12"
    x-data="{
    cart: {{ json_encode($cart) }},
    productData: {{ json_encode($productData) }},

    async updateQuantity(cartKey, quantity) {
        const formData = new FormData();
        formData.append('action', 'update_cart_quantity');
        formData.append('cart_key', cartKey);
        formData.append('quantity', quantity);

        const response = await fetch('{{ admin_url('admin-ajax.php') }}', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        if (data.success) {
            this.cart = data.data.cart;
            window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.data.cart }));
        }
    },

    async removeItem(cartKey) {
        if (!confirm('Vai tiešām vēlaties noņemt šo produktu?')) return;

        const formData = new FormData();
        formData.append('action', 'remove_cart_item');
        formData.append('cart_key', cartKey);

        const response = await fetch('{{ admin_url('admin-ajax.php') }}', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        if (data.success) {
            this.cart = data.data.cart;
            window.dispatchEvent(new CustomEvent('cart-updated', { detail: data.data.cart }));
        }
    },

    get cartTotal() {
        return Object.values(this.cart).reduce((sum, item) => {
            return sum + (parseFloat(item.price) * parseInt(item.quantity));
        }, 0).toFixed(2);
    },

    get cartCount() {
        return Object.values(this.cart).reduce((sum, item) => sum + parseInt(item.quantity), 0);
    }
}"
  >
    <div class="max-w-4xl mx-auto px-6">
      <h1 class="text-4xl font-bold mb-8 text-gray-900">Iepirkumu Grozs</h1>

      <template x-if="Object.keys(cart).length === 0">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
          <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
          </svg>
          <h2 class="text-2xl font-semibold text-gray-700 mb-2">Jūsu grozs ir tukšs</h2>
          <p class="text-gray-500 mb-6">Pievienojiet produktus, lai turpinātu iepirkties</p>
          <a
            href="{{ url('/') }}"
            class="inline-block bg-emerald-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-emerald-700 transition"
          >
            Turpināt Iepirkties
          </a>
        </div>
      </template>

      <template x-if="Object.keys(cart).length > 0">
        <div class="space-y-6">
          {{-- Cart Items --}}
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <template x-for="(item, cartKey) in cart" :key="cartKey">
              <div class="p-6 border-b border-gray-100 last:border-b-0">
                <div class="flex items-center gap-6">
                  {{-- Product Image --}}
                  <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                    <template x-if="productData[cartKey]?.image">
                      <img
                        :src="productData[cartKey].image"
                        class="w-full h-full object-cover"
                        :alt="productData[cartKey].title"
                        onerror="this.style.display = 'none'"
                      />
                    </template>
                    <template x-if="!productData[cartKey]?.image">
                      <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                      </div>
                    </template>
                  </div>

                  {{-- Product Info --}}
                  <div class="flex-1">
                    <h3
                      class="font-semibold text-lg text-gray-900 mb-1"
                      x-text="productData[cartKey]?.title || 'Product'"
                    ></h3>
                    <p class="text-sm mb-0 text-gray-500">
                      Izmērs: <span class="font-semibold" x-text="item.size"></span>
                    </p>
                    <p class="text-emerald-600 font-bold mt-2" x-text="item.price + ' €'"></p>
                  </div>

                  {{-- Quantity Controls --}}
                  <div class="flex items-center gap-3">
                    <div class="inline-flex items-center overflow-hidden border border-gray-400 rounded-2xl">
                      <button
                        @click="updateQuantity(cartKey, Math.max(1, item.quantity - 1))"
                        class="px-4 py-2 hover:bg-gray-50 transition-colors text-gray-600 hover:text-gray-900"
                      >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                      </button>
                      <input
                        type="number"
                        :value="item.quantity"
                        x-on:change="updateQuantity(cartKey, parseInt($event.target.value))"
                        min="1"
                        class="w-16 text-center py-2 text-sm font-semibold border-0"
                      />
                      <button
                        @click="updateQuantity(cartKey, item.quantity + 1)"
                        class="px-4 py-2 hover:bg-gray-50 transition-colors text-gray-600 hover:text-gray-900"
                      >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                      </button>
                    </div>

                    <p
                      class="text-lg mb-0 font-bold text-gray-900 w-24 text-right"
                      x-text="(item.price * item.quantity).toFixed(2) + ' €'"
                    ></p>

                    <button @click="removeItem(cartKey)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </template>
          </div>

          {{-- Cart Summary --}}
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-200">
              <span class="text-lg font-semibold text-gray-700">Kopā:</span>
              <span class="text-3xl font-bold text-emerald-600" x-text="cartTotal + ' €'"></span>
            </div>

            <div class="space-y-3">
              <a
                href="{{ url('checkout') }}"
                class="block w-full bg-emerald-600 text-white text-center py-4 rounded-xl font-bold text-lg hover:bg-emerald-700 transition shadow-lg shadow-emerald-100"
              >
                Noformēt Pasūtījumu
              </a>
              <a
                href="{{ url('/') }}"
                class="block w-full bg-gray-100 text-gray-700 text-center py-4 rounded-xl font-semibold hover:bg-gray-200 transition"
              >
                Turpināt Iepirkties
              </a>
            </div>
          </div>
        </div>
      </template>
    </div>
  </div>
@endsection

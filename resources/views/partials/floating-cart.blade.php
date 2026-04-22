{{-- Floating Cart Button --}}
@php
if (!session_id()) {
    session_start();
}

// If order was just placed, clear the session cart BEFORE reading it
if (isset($_GET['order_success']) && $_GET['order_success'] == '1') {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'] ?? [];
$cartCount = !empty($cart) ? array_sum(array_column($cart, 'quantity')) : 0;
$cartTotal = !empty($cart) ? array_reduce($cart, function($sum, $item) {
    return $sum + ($item['price'] * $item['quantity']);
}, 0) : 0;
@endphp

<div x-data="{
    cartCount: {{ $cartCount }},
    cartTotal: {{ $cartTotal }},
    show: {{ $cartCount > 0 ? 'true' : 'false' }},

    init() {
        // Check if localStorage cart was cleared (indicates order was placed)
        const stored = localStorage.getItem('shopping_cart');
        if (!stored && this.cartCount > 0) {
            // Cart was cleared, hide the floating cart
            this.cartCount = 0;
            this.cartTotal = 0;
            this.show = false;
            return;
        }

        // Listen for cart updates
        window.addEventListener('cart-updated', (event) => {
            const cart = event.detail || {};
            this.cartCount = Object.values(cart).reduce((sum, item) => sum + parseInt(item.quantity || 0), 0);
            this.cartTotal = Object.values(cart).reduce((sum, item) => {
                return sum + (parseFloat(item.price || 0) * parseInt(item.quantity || 0));
            }, 0);
            this.show = this.cartCount > 0;

            // Save to localStorage
            this.saveCartToStorage(cart);
        });

        // Load cart from localStorage on init
        this.loadCartFromStorage();
    },

    saveCartToStorage(cart) {
        const cartData = {
            cart: cart,
            timestamp: Date.now(),
            expiresIn: 24 * 60 * 60 * 1000 // 24 hours in milliseconds
        };
        localStorage.setItem('shopping_cart', JSON.stringify(cartData));
    },

    loadCartFromStorage() {
        const stored = localStorage.getItem('shopping_cart');
        if (!stored) return;

        try {
            const cartData = JSON.parse(stored);
            const now = Date.now();
            const age = now - cartData.timestamp;

            // Check if cart has expired (24 hours)
            if (age > cartData.expiresIn) {
                localStorage.removeItem('shopping_cart');
                return;
            }

            // Don't sync if session is empty - it might have been cleared intentionally
            // (e.g., after order placement)
            // Only show warning that cart was cleared
            if (this.cartCount === 0 && cartData.cart && Object.keys(cartData.cart).length > 0) {
                console.log('Session cart was cleared - removing localStorage cart');
                localStorage.removeItem('shopping_cart');
                return;
            }
        } catch (e) {
            console.error('Error loading cart from storage:', e);
            localStorage.removeItem('shopping_cart');
        }
    },

    async syncCartToServer(cart) {
        // This would sync localStorage cart back to the session
        // For now, we'll just update the display
        this.cartCount = Object.values(cart).reduce((sum, item) => sum + parseInt(item.quantity), 0);
        this.cartTotal = Object.values(cart).reduce((sum, item) => {
            return sum + (parseFloat(item.price) * parseInt(item.quantity));
        }, 0);
        this.show = this.cartCount > 0;
    }
}"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-8 scale-90"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
     x-transition:leave-end="opacity-0 translate-y-8 scale-90"
     class="fixed bottom-6 right-6 z-40"
     style="display: none;">

    <a href="{{ url('grozs') }}"
       class="group block bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl shadow-2xl hover:shadow-emerald-200 transition-all duration-300 p-4 hover:scale-105 active:scale-95">

        <div class="flex items-center gap-4">
            {{-- Cart Icon with Badge --}}
            <div class="relative">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>

                {{-- Item Count Badge --}}
                <span x-show="cartCount > 0"
                      class="absolute -top-2 -right-2 bg-white text-emerald-600 text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center shadow-lg ring-2 ring-emerald-600"
                      x-text="cartCount"></span>
            </div>

            {{-- Cart Total --}}
            <div class="text-right">
                <div class="text-xs opacity-90 font-medium">Grozā</div>
                <div class="text-lg font-bold" x-text="cartTotal.toFixed(2) + ' €'"></div>
            </div>
        </div>

    </a>
</div>

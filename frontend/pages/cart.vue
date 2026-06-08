<script setup lang="ts">
import { watch } from 'vue';
import { useCartStore } from "@/stores/cart"; 
import { formatCurrency } from "@/stores/currencyFormatter";

interface Product {
  id: string; 
  imageUrl: string;
  name: string;
  rating: {
    stars: number;
    count: number;
  };
  priceCents: number; 
  keywords: string[]; 
  quantity: number;
  type: string;
}

const cartStore = useCartStore();

watch(() => cartStore.cart, (cartAfterUpdate) => {
  console.log("Cart after updated: ", cartAfterUpdate);
});

watch(() => cartStore.selectedCurrency, (newCurrency) => {
  cartStore.setCurrency(newCurrency); 
});

watch(() => cartStore.selectedShipping, (newSelectedShipping) => {
  console.log("Shipping changed to:", newSelectedShipping);
  cartStore.setShipping(newSelectedShipping);
});

watch(() => cartStore.cart, (newCartStoreCart) => {
  console.log("cartStore cart", newCartStoreCart);
});

cartStore.loadCart();

definePageMeta({
  layout: 'default',
});
</script>

<template>
  <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <section class="bg-white py-6 dark:bg-gray-900 md:py-16">
      <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">

        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white uppercase border-b pb-4">
          Shopping Cart
        </h2>

        <div class="mt-6 sm:mt-8 lg:flex lg:items-start xl:gap-8">

          <!-- Left: Products List -->
          <div class="w-full lg:max-w-2xl xl:max-w-4xl">
            <div class="space-y-0">

              <div
                v-for="product in cartStore.cart"
                :key="product.cartItemId"
                class="border-b border-gray-200 dark:border-gray-700 py-5"
              >
                <!-- Top row: image + name/color/size/remove -->
                <div class="flex gap-3 sm:gap-4">

                  <!-- Product Image -->
                  <img
                    class="h-20 w-20 sm:h-24 sm:w-24 flex-shrink-0 object-cover rounded"
                    :src="product.imageUrl"
                    :alt="product.name"
                  />

                  <!-- Product Details -->
                  <div class="flex-1 min-w-0">
                    <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white leading-tight">
                      {{ product.name }}
                    </h3>

                    <!-- Color -->
                    <div v-if="product.selectedColor" class="mt-1 text-xs sm:text-sm text-gray-700 dark:text-gray-300 flex items-center gap-1">
                      <span class="font-semibold">Color:</span>
                      <span
                        :class="{
                          'text-blue-500': product.selectedColor.includes('Blue'),
                          'text-red-500': product.selectedColor.includes('Red'),
                          'text-yellow-500': product.selectedColor.includes('Yellow'),
                          'text-gray-500': product.selectedColor.includes('White'),
                          'text-green-500': product.selectedColor.includes('Green')
                        }"
                        class="font-medium"
                      >
                        {{ product.selectedColor }}
                      </span>
                    </div>

                    <!-- Size -->
                    <div v-if="product.selectedSize" class="mt-1 text-xs sm:text-sm text-gray-700 dark:text-gray-300">
                      <span class="font-semibold">Size:</span> {{ product.selectedSize }}
                    </div>

                    <!-- Remove button -->
                    <button
                      class="mt-2 text-xs sm:text-sm text-red-500 hover:underline"
                      @click="cartStore.removeFromCart(product.cartItemId)"
                    >
                      Remove
                    </button>
                  </div>
                </div>

                <!-- Bottom row: quantity controls + price -->
                <div class="mt-3 flex items-center justify-between gap-2 pl-0 sm:pl-28">

                  <!-- Quantity Controls -->
                  <div class="flex items-center gap-2">
                    <span class="text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400">Qty</span>

                    <!-- ✅ Fixed: passing cartItemId instead of id -->
                    <button
                      @click="cartStore.decrementQuantity(product.cartItemId)"
                      class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 rounded text-sm font-bold"
                    >
                      −
                    </button>

                    <!-- ✅ Fixed: passing cartItemId instead of id -->
                    <input
                      type="text"
                      :value="cartStore.getProductQuantity(product.cartItemId)"
                      readonly
                      class="w-9 h-7 sm:w-10 sm:h-8 text-center text-sm bg-white text-gray-800 dark:bg-slate-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded"
                    />

                    <!-- ✅ Fixed: passing cartItemId instead of id -->
                    <button
                      @click="cartStore.incrementQuantity(product.cartItemId)"
                      class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600 rounded text-sm font-bold"
                    >
                      +
                    </button>
                  </div>

                  <!-- Price -->
                  <p class="font-semibold text-sm sm:text-base text-gray-900 dark:text-white whitespace-nowrap">
                    {{ formatCurrency(cartStore.convertPrice(product.priceCents), cartStore.selectedCurrency) }}
                  </p>

                </div>
              </div>

              <!-- Empty cart state -->
              <div v-if="!cartStore.cart.length" class="py-16 text-center text-gray-500 dark:text-gray-400">
                <p class="text-lg font-medium">Your cart is empty.</p>
                <NuxtLink to="/" class="mt-3 inline-block text-sm text-black dark:text-white underline">
                  Continue shopping
                </NuxtLink>
              </div>

            </div>
          </div>

          <!-- Right: Order Summary -->
          <div class="w-full mt-6 lg:mt-0 lg:w-80 xl:w-96 flex-shrink-0">
            <div class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
              <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Order Summary</h3>

              <div class="mt-5 space-y-3">
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                  <span>Subtotal</span>
                  <span>
                    {{ formatCurrency(cartStore.convertPrice(cartStore.calculateTotalPrice), cartStore.selectedCurrency) }}
                  </span>
                </div>

                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                  <span>Shipping</span>
                  <span>{{ cartStore.getShippingCost() }}</span>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-3 flex justify-between text-gray-900 dark:text-white font-bold text-sm sm:text-base">
                  <span>Total</span>
                  <span>
                    {{ formatCurrency(cartStore.convertPrice(cartStore.calculateTotalPrice), cartStore.selectedCurrency) }}
                  </span>
                </div>
              </div>

              <NuxtLink to="/checkout/CheckOut">
                <button class="mt-5 w-full rounded-md bg-black text-white py-3 text-sm sm:text-base font-semibold hover:bg-gray-800 transition-colors">
                  Proceed to Checkout
                </button>
              </NuxtLink>

              <NuxtLink to="/" class="mt-3 block text-center text-xs sm:text-sm text-green-500 dark:text-gray-400 hover:underline">
                ← Continue Shopping
              </NuxtLink>
            </div>
          </div>

        </div>
      </div>
    </section>
  </div>
</template>
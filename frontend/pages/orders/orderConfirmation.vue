<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8 px-4">
    <div class="max-w-4xl mx-auto">

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600"></div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">
        <h2 class="text-xl font-semibold text-red-800 dark:text-red-300 mb-2">Error Loading Order</h2>
        <p class="text-red-600 dark:text-red-400">{{ error }}</p>
      </div>

      <!-- Order Details -->
      <div v-else-if="order" class="space-y-6">

        <!-- Success Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 text-center">
          <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Order Placed Successfully!</h1>
          <p class="text-gray-600 dark:text-gray-300">Thank you for your purchase</p>
          <div class="mt-4 inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg">
            <span class="text-sm text-gray-600 dark:text-gray-400">Order ID:</span>
            <span class="font-mono font-semibold text-gray-900 dark:text-white">#{{ order.id }}</span>
          </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Order Status</h2>
              <p class="text-sm text-gray-600 dark:text-gray-400">Placed on {{ order.created_at }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold capitalize bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
              {{ order.status }}
            </span>
          </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Items</h2>
          <div class="space-y-4">
            <div
              v-for="item in order.items"
              :key="item.id"
              class="flex gap-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0 last:pb-0"
            >
              <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded overflow-hidden flex-shrink-0">
                <img :src="item.image_url" :alt="item.product_name" class="w-full h-full object-cover" />
              </div>
              <div class="flex-1">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ item.product_name ?? 'Product' }}</h3>
                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                  <p>Quantity: {{ item.quantity }}</p>
                  <p v-if="item.selected_color">Color: {{ item.selected_color }}</p>
                  <p v-if="item.selected_size">Size: {{ item.selected_size }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="font-semibold text-gray-900 dark:text-white">
                  {{ formatCurrency(cartStore.convertPrice(item.productTotalAmount), cartStore.selectedCurrency) }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                  {{ formatCurrency(cartStore.convertPrice(item.price_cents), cartStore.selectedCurrency) }} each
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Summary</h2>
          <div class="space-y-2">
            <div class="flex justify-between text-gray-600 dark:text-gray-400">
              <span>Shipping:</span>
              <span>Free</span>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2">
              <div class="flex justify-between text-lg font-semibold text-gray-900 dark:text-white">
                <span>Total:</span>
                <span>{{ formatCurrency(cartStore.convertPrice(order.orderTotalAmount), cartStore.selectedCurrency) }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Contact & Shipping Info -->
        <div class="grid md:grid-cols-2 gap-6">
          <!-- Customer Info -->
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Customer Information</h2>
            <div class="space-y-2 text-sm">
              <p class="text-gray-600 dark:text-gray-400">
                <span class="font-medium text-gray-900 dark:text-white">Name:</span><br/>
                {{ order.full_name }}
              </p>
              <p class="text-gray-600 dark:text-gray-400">
                <span class="font-medium text-gray-900 dark:text-white">Email:</span><br/>
                {{ order.email }}
              </p>
              <p class="text-gray-600 dark:text-gray-400">
                <span class="font-medium text-gray-900 dark:text-white">Phone:</span><br/>
                {{ order.phone_number }}
              </p>
            </div>
          </div>

          <!-- Shipping Address -->
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Shipping Address</h2>
            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
              <p class="font-medium text-gray-900 dark:text-white">{{ order.full_name }}</p>
              <p v-if="order.nearby_landmark">{{ order.nearby_landmark }}</p>
              <p v-if="order.sector">{{ order.sector }}</p>
              <p>{{ order.district }}<span v-if="order.province">, {{ order.province }}</span></p>
              <p>{{ order.country }}</p>
            </div>
          </div>
        </div>

        <!-- Payment Info -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Information</h2>
          <div class="text-sm">
            <p class="text-gray-600 dark:text-gray-400 mb-2">
              <span class="font-medium text-gray-900 dark:text-white">Method:</span>
              <span class="capitalize ml-1">{{ order.payment_method?.replace('_', ' ') }}</span>
            </p>
            <div v-if="order.payment_method === 'mobile_money'" class="text-gray-600 dark:text-gray-400">
              <span class="font-medium text-gray-900 dark:text-white">Mobile Money Number:</span>
              {{ order.mobile_money_number }}
            </div>
            <div v-if="order.payment_method === 'bank_account'" class="text-gray-600 dark:text-gray-400">
              <p><span class="font-medium text-gray-900 dark:text-white">Name on Card:</span> {{ order.name_on_card }}</p>
              <p><span class="font-medium text-gray-900 dark:text-white">Card:</span> **** **** **** {{ order.card_number?.slice(-4) }}</p>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
          <button
            @click="$router.push('/')"
            class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white py-3 px-6 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-semibold"
          >
            Continue Shopping
          </button>
          <button
            @click="$router.push('/orders/history')"
            class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors font-semibold"
          >
            View All Orders
          </button>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useCartStore } from '~/stores/cart';
import { useUserStore } from '~/stores/user';
import { formatCurrency } from '~/stores/currencyFormatter';

const cartStore = useCartStore();
const userStore = useUserStore();
const router = useRouter();

const order = ref(null);
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  userStore.hydrate();

  if (!userStore.token) {
    router.push('/login');
    return;
  }

  try {
    const res = await $fetch(
      `https://api.thibella.com/public/orders/get-user-orders.php?userId=${userStore.userId}`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${userStore.token}`,
        },
      }
    );

    if (res.success && res.data.length > 0) {
      // Show the most recent order (first in DESC list)
      order.value = res.data[0];
    } else {
      error.value = 'No orders found.';
    }
  } catch (err) {
    error.value = err?.data?.message || 'Failed to load order.';
    console.error(err);
  } finally {
    loading.value = false;
  }
});
</script>
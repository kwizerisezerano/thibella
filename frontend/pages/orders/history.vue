<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8 px-4">
    <div class="max-w-4xl mx-auto">

      <!-- User Credentials Card -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 flex items-center gap-4">
        <div class="w-14 h-14 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center flex-shrink-0">
          <span class="text-2xl font-bold text-green-600 dark:text-green-400">
            {{ userStore.name?.charAt(0).toUpperCase() ?? 'U' }}
          </span>
        </div>
        <div>
          <p class="text-lg font-bold text-gray-900 dark:text-white">{{ userStore.name ?? 'Unknown User' }}</p>
          <p class="text-sm text-gray-500 dark:text-gray-400">User ID: <span class="font-mono text-gray-700 dark:text-gray-300">{{ userStore.userId }}</span></p>
        </div>
      </div>

      <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">My Orders</h1>

      <!-- Loading -->
      <div v-if="loading" class="flex justify-center items-center py-20">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600"></div>
      </div>

      <!-- Error -->
      <div v-else-if="error" class="bg-red-50 dark:bg-red-900/20 border border-red-200 rounded-lg p-6">
        <p class="text-red-600 dark:text-red-400">{{ error }}</p>
      </div>

      <!-- No Orders -->
      <div v-else-if="!orders.length" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-10 text-center">
        <p class="text-gray-500 dark:text-gray-400">You have no orders yet.</p>
        <button @click="$router.push('/')" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
          Start Shopping
        </button>
      </div>

      <!-- Orders List -->
      <div v-else class="space-y-6">
        <div
          v-for="order in orders"
          :key="order.id"
          class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6"
        >
          <!-- Order Header -->
          <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Order ID</p>
              <p class="font-mono font-semibold text-gray-900 dark:text-white">#{{ order.id }}</p>
            </div>
            <div class="text-center">
              <p class="text-sm text-gray-500 dark:text-gray-400">Placed On</p>
              <p class="text-sm text-gray-900 dark:text-white">{{ order.created_at }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold capitalize bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
              {{ order.status }}
            </span>
          </div>

          <!-- Order Items -->
          <div class="space-y-3 mb-4">
            <div
              v-for="item in order.items"
              :key="item.id"
              class="flex gap-4"
            >
              <div class="w-16 h-16 bg-gray-200 dark:bg-gray-700 rounded overflow-hidden flex-shrink-0">
                <img :src="item.image_url" :alt="item.product_name" class="w-full h-full object-cover" />
              </div>
              <div class="flex-1">
                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ item.product_name ?? 'Product' }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">Qty: {{ item.quantity }}</p>
                <p v-if="item.selected_color" class="text-xs text-gray-500 dark:text-gray-400">Color: {{ item.selected_color }}</p>
                <p v-if="item.selected_size" class="text-xs text-gray-500 dark:text-gray-400">Size: {{ item.selected_size }}</p>
              </div>
              <div class="text-right">
                <p class="font-semibold text-sm text-gray-900 dark:text-white">
                  {{ formatCurrency(cartStore.convertPrice(item.productTotalAmount), cartStore.selectedCurrency) }}
                </p>
              </div>
            </div>
          </div>

          <!-- Order Total -->
          <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-gray-700">
            <span class="text-gray-600 dark:text-gray-400 text-sm">Shipping:</span>
            <span class="text-gray-600 dark:text-gray-400 text-sm">Free</span>
          </div>
          <div class="flex justify-between items-center pt-2">
            <span class="font-semibold text-gray-900 dark:text-white">Total:</span>
            <span class="font-bold text-gray-900 dark:text-white">
              {{ formatCurrency(cartStore.convertPrice(order.orderTotalAmount), cartStore.selectedCurrency) }}
            </span>
          </div>

          <!-- Customer Info -->
          <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 grid md:grid-cols-2 gap-4">

            <!-- Personal Details -->
            <div>
              <p class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Customer Information</p>
              <div class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
                <p><span class="font-medium text-gray-900 dark:text-white">Name:</span> {{ order.full_name }}</p>
                <p><span class="font-medium text-gray-900 dark:text-white">Email:</span> {{ order.email }}</p>
                <p><span class="font-medium text-gray-900 dark:text-white">Phone:</span> {{ order.phone_number }}</p>
              </div>
            </div>

            <!-- Shipping Address -->
            <div>
              <p class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Shipping Address</p>
              <div class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
                <p class="font-medium text-gray-900 dark:text-white">{{ order.full_name }}</p>
                <p v-if="order.nearby_landmark">{{ order.nearby_landmark }}</p>
                <p v-if="order.sector">{{ order.sector }}</p>
                <p>{{ order.district }}<span v-if="order.province">, {{ order.province }}</span></p>
                <p>{{ order.country }}</p>
              </div>
            </div>

            <!-- Payment Info -->
            <div class="md:col-span-2">
              <p class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Payment Information</p>
              <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1">
                <p>
                  <span class="font-medium text-gray-900 dark:text-white">Method:</span>
                  <span class="capitalize ml-1">{{ order.payment_method?.replace('_', ' ') }}</span>
                </p>
                <p v-if="order.payment_method === 'mobile_money'">
                  <span class="font-medium text-gray-900 dark:text-white">Mobile Money Number:</span>
                  {{ order.mobile_money_number }}
                </p>
                <div v-if="order.payment_method === 'bank_account'">
                  <p><span class="font-medium text-gray-900 dark:text-white">Name on Card:</span> {{ order.name_on_card }}</p>
                  <p><span class="font-medium text-gray-900 dark:text-white">Card:</span> **** **** **** {{ order.card_number?.slice(-4) }}</p>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Back Button -->
        <button
          @click="$router.push('/')"
          class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors font-semibold"
        >
          Continue Shopping
        </button>
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

const orders = ref([]);
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
      `${useRuntimeConfig().public.baseUrl}/orders/user`,
      {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${userStore.token}`,
        },
        params: {
          user_id: userStore.userId
        }
      }
    );

    if (res.success && res.orders.length > 0) {
      orders.value = res.orders;
    } else {
      error.value = 'No orders found.';
    }
  } catch (err) {
    console.error('Load orders error:', err);
    error.value = err?.data?.message || 'Failed to load orders.';
  } finally {
    loading.value = false;
  }
});
</script>
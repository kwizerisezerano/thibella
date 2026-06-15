  <script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useOrderStore } from '@/stores/order';
import { useUserStore } from '~/stores/user';

const orderStore = useOrderStore();
const userStore = useUserStore();
const router = useRouter();
const orderId = ref('');
const orderDetails = ref(null);

onMounted(() => {
  userStore.hydrate();
  // Only admins can view order pages
  if (userStore.role !== 'admin') {
    router.push('/');
  }
});

const trackOrder = () => {
  orderDetails.value = orderStore.getOrderById(orderId.value);
};
</script>

<template>
  <div class="p-6">
    <h1 class="text-xl font-bold">Track Your Order</h1>
    
    <input 
      v-model="orderId"
      placeholder="Enter Order ID"
      class="border p-2 mt-4 w-full"
    />
    
    <button @click="trackOrder" class="bg-blue-500 text-white p-2 mt-2">
      Track
    </button>

    <div v-if="orderDetails" class="mt-4 border p-4">
      <p><strong>Status:</strong> {{ orderDetails.status }}</p>
      <p><strong>Tracking Number:</strong> {{ orderDetails.trackingNumber }}</p>
      <p><strong>Estimated Delivery:</strong> {{ orderDetails.estimatedDelivery }}</p>
    </div>

    <div v-else-if="orderId && !orderDetails" class="mt-4 text-red-500">
      Order not found. Please check the Order ID.
    </div>
  </div>
</template>

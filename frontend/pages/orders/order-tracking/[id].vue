<script setup>
import { onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useOrderStore } from '@/stores/order';
import { useUserStore } from '~/stores/user';

const route = useRoute();
const router = useRouter();
const orderStore = useOrderStore();
const userStore = useUserStore();
const orderId = route.params.id; // Get order ID from the URL
const orderDetails = orderStore.getOrderById(orderId);

onMounted(() => {
  userStore.hydrate();
  // Only admins can view order pages
  if (userStore.role !== 'admin') {
    router.push('/');
  }
});
</script>

<template>
  <div class="p-6">
    <h1 class="text-xl font-bold">Order Tracking</h1>

    <div v-if="orderDetails" class="mt-4 border p-4">
      <p><strong>Order ID:</strong> {{ orderDetails.id }}</p>
      <p><strong>Status:</strong> {{ orderDetails.status }}</p>
      <p><strong>Tracking Number:</strong> {{ orderDetails.trackingNumber }}</p>
      <p><strong>Estimated Delivery:</strong> {{ orderDetails.estimatedDelivery }}</p>
    </div>

    <div v-else class="mt-4 text-red-500">
      Order not found. Please check the Order ID.
    </div>
  </div>
</template>

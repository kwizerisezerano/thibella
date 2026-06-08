<script setup>
import { useRoute } from 'vue-router';
import { useOrderStore } from '@/stores/order';

const route = useRoute();
const orderStore = useOrderStore();
const orderId = route.params.id; // Get order ID from the URL
const orderDetails = orderStore.getOrderById(orderId);
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

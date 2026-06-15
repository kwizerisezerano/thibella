<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useOrderStore } from '@/stores/order';
import { useUserStore } from '~/stores/user';

const orderStore = useOrderStore();
const userStore = useUserStore();
const router = useRouter();

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
    <h1 class="text-xl font-bold">Your Orders</h1>

    <div v-if="orderStore.orders.length">
      <div 
        v-for="order in orderStore.orders" 
        :key="order.id"
        class="border p-4 mt-4"
      >
        <p><strong>Order ID:</strong> {{ order.id }}</p>
        <p><strong>Status:</strong> {{ order.status }}</p>
        <p><strong>Tracking Number:</strong> {{ order.trackingNumber }}</p>
        <p><strong>Estimated Delivery:</strong> {{ order.estimatedDelivery }}</p>
      </div>
    </div>
    <p v-else class="mt-4">No orders found.</p>
  </div>
</template>

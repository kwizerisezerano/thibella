<template>
   <div>
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>


<script setup>
import { onMounted } from 'vue';
import { useCartStore } from '~/stores/cart';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const cartStore = useCartStore();

onMounted(() => {
  // Reveal app and remove splash simultaneously
  const nuxtEl = document.getElementById('__nuxt');
  if (nuxtEl) nuxtEl.classList.add('ready');

  if (typeof window !== 'undefined' && window.__removeSplash) {
    window.__removeSplash()
  }

  cartStore.loadCart();

  const productId = route.query.product;
  if (productId) {
    router.push(`/products/${productId}`);
  }
});
</script>
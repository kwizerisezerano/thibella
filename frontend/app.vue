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
import { useUserStore } from '~/stores/user';
import { useRouter, useRoute } from 'vue-router';

const router = useRouter();
const route = useRoute();
const cartStore = useCartStore();
const userStore = useUserStore();

onMounted(() => {
  // Reveal app and remove splash simultaneously
  const nuxtEl = document.getElementById('__nuxt');
  if (nuxtEl) nuxtEl.classList.add('ready');

  if (typeof window !== 'undefined' && window.__removeSplash) {
    window.__removeSplash()
  }

  // Hydrate stores from localStorage
  userStore.hydrate();
  cartStore.loadCart();

  const productId = route.query.product;
  if (productId) {
    router.push(`/products/${productId}`);
  }
});
</script>
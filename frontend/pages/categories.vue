<script setup lang="ts">
import ProductsByCategories from '~/components/ProductsByCategories.vue';

definePageMeta({
  layout: "default"
})
</script>

<template>
  <div class="bg-white dark:bg-gray-950 min-h-screen">
    <div class="max-w-screen-xl mx-auto px-4 py-8">
      <ProductsByCategories />
    </div>
  </div>
</template>
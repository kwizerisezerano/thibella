<script setup lang="ts">
import ProductsByCategories from '~/components/ProductsByCategories.vue';
import ProductsList from '~/components/ProductsList.vue';

definePageMeta({
  layout: "default"
})

</script>

<template>
  <div>
    <ProductsByCategories />
  </div>
</template>
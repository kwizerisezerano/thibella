<template>
  <div class="relative bg-white dark:bg-gray-900"> 
    
    <!-- Products List overlapping hero -->
     <div> 
      <ProductsList />
    </div>

  </div>
</template>

<script setup>
import ProductsList from '~/components/ProductsList.vue';

definePageMeta({
  layout: 'default'
});
</script>
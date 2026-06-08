<!-- index.vue -->
<script setup>
import { watch } from 'vue'
import { useSearchStore } from '~/stores/search'

const searchStore = useSearchStore()

// When search query is set, scroll down to products
watch(() => searchStore.query, (newQuery) => {
  if (newQuery) {
    // Small delay to let ProductsList re-render first
    setTimeout(() => {
      document.querySelector('#products-section')?.scrollIntoView({ behavior: 'smooth' })
    }, 100)
  }
})
</script>

<template>
  <div class="relative bg-white dark:bg-gray-900">
    <div class="relative w-full h-96 z-10">
      <TopProduct />
      <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-white/100 ..."></div>
    </div>

    <div class="relative z-30 mt-[-250px] ...">
      <ProductsByCategories />
    </div>

    <!-- Add id here so we can scroll to it -->
    <div id="products-section" class="relative z-30 mt-[-80px] px-4 2xl:px-0 max-w-screen-xl mx-auto">
      <ProductsList />
    </div>
  </div>
</template>
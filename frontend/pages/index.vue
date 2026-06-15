<script setup>
import { watch } from 'vue'
import { useSearchStore } from '~/stores/search'

const searchStore = useSearchStore()

watch(() => searchStore.query, (newQuery) => {
  if (newQuery) {
    setTimeout(() => {
      document.querySelector('#products-section')?.scrollIntoView({ behavior: 'smooth' })
    }, 100)
  }
})
</script>

<template>
  <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">

    <!-- Hero Banner — full width intentional -->
    <section class="w-full">
      <TopProduct />
    </section>

    <!-- Categories -->
    <section class="w-full bg-white dark:bg-gray-800 shadow-sm">
      <div class="w-full px-3 sm:px-4">
        <ProductsByCategories />
      </div>
    </section>

    <!-- Divider -->
    <div class="w-full px-3 sm:px-4 mt-8 mb-2 flex items-center gap-4">
      <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
      <span class="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 whitespace-nowrap">
        {{ $t('products.title') }}
      </span>
      <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
    </div>

    <!-- Products -->
    <section id="products-section" class="w-full">
      <div class="w-full px-3 sm:px-4">
        <ProductsList />
      </div>
    </section>

  </div>
</template>

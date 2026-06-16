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
  <div class="bg-white dark:bg-gray-950 min-h-screen">

    <!-- Hero + Categories overlaid -->
    <section class="relative">
      <TopProduct />

      <div class="absolute bottom-0 left-0 right-0 translate-y-1/2 z-10">
        <div class="max-w-screen-xl mx-auto px-4 ">
          <ProductsByCategories />
        </div>
      </div>
    </section>

    <!-- Spacer: adjust this to match the height of your category cards -->
    <div class="mt-32 sm:mt-36"></div>

    <!-- Divider -->
    <div class="max-w-screen-xl mx-auto px-4 mt-6 mb-4 flex items-center gap-4">
      <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
      <span class="text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500 whitespace-nowrap">
        {{ $t('products.title') }}
      </span>
      <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
    </div>

    <!-- Products -->
    <section id="products-section" class="w-full">
      <div class="max-w-screen-xl mx-auto px-4 pb-12">
        <ProductsList />
      </div>
    </section>

  </div>
</template>



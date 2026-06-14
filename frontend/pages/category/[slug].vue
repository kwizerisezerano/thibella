<template>
  <div class="min-h-screen bg-[#f7f9f4] dark:bg-gray-950">

    <!-- Main Content -->
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 py-10">

      <!-- Loading State -->
      <div v-if="loading" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5">
        <div
          v-for="n in 8"
          :key="n"
          class="rounded-2xl bg-white dark:bg-gray-800 overflow-hidden animate-pulse shadow"
        >
          <div class="aspect-square bg-gray-200 dark:bg-gray-700" />
          <div class="p-3 space-y-2">
            <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mx-auto" />
            <div class="h-2 bg-gray-100 dark:bg-gray-600 rounded w-1/2 mx-auto" />
          </div>
        </div>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-20">
        <div class="text-5xl mb-4">😕</div>
        <p class="text-red-500 font-semibold text-lg">{{ error }}</p>
        <button
          @click="fetchData"
          class="mt-6 px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-full text-sm font-medium transition-colors"
        >
          {{ $t('categories.tryAgain') }}
        </button>
      </div>

      <!-- Direct products (no subcategories) -->
      <template v-else-if="subcategories.length === 0 && products.length > 0">
        <p class="text-sm text-gray-400 mb-6 font-medium uppercase tracking-widest">{{ $t('categories.allProducts') }}</p>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-5">
          <div
            v-for="(product, i) in products"
            :key="product.id || i"
            @click="goToProduct(product.id)"
            class="group cursor-pointer rounded-2xl bg-white dark:bg-gray-800 overflow-hidden shadow hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700"
          >
            <div class="relative aspect-square overflow-hidden">
              <img
                :src="product.imageUrl"
                :alt="product.productName"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
              <div class="absolute top-2 left-0 right-0 flex justify-center">
                <span class="bg-green-600 text-white text-[10px] font-semibold px-2.5 py-0.5 rounded-full shadow">
                  💬 {{ $t('products.negotiable') }}
                </span>
              </div>
            </div>
            <div class="p-3">
              <p class="text-sm font-bold text-green-900 dark:text-gray-200 text-center line-clamp-2">
                {{ product.productName }}
              </p>
            </div>
          </div>
        </div>
      </template>

      <!-- Subcategories Grid -->
      <template v-else-if="subcategories.length > 0">
        <p class="text-sm text-gray-400 mb-6 font-medium uppercase tracking-widest">
          {{ $t('categories.subcategories', { count: subcategories.length }) }}
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-5">
          <div
            v-for="(sub, index) in subcategories"
            :key="sub.id"
            @click="goToSubcategory(sub)"
            class="group cursor-pointer rounded-2xl bg-white dark:bg-gray-800 overflow-hidden shadow hover:shadow-xl
                   transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-gray-700"
            :style="{ animationDelay: `${index * 40}ms` }"
          >
            <!-- Image -->
            <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-gray-700">
              <img
                v-if="sub.image"
                :src="sub.image"
                :alt="sub.name"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
              />
              <!-- Fallback icon if no image -->
              <div
                v-else
                class="w-full h-full flex items-center justify-center text-4xl bg-gradient-to-br from-green-100 to-emerald-50 dark:from-gray-700 dark:to-gray-600"
              >
                🗂️
              </div>

              <!-- Hover overlay -->
              <div class="absolute inset-0 bg-gradient-to-t from-green-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" />

              <!-- Arrow CTA on hover -->
              <div class="absolute bottom-3 right-3 w-8 h-8 rounded-full bg-white/90 flex items-center justify-center
                          opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-2 group-hover:translate-x-0 shadow">
                <span class="text-green-700 text-sm font-bold">→</span>
              </div>
            </div>

            <!-- Name -->
            <div class="p-3">
              <p class="text-sm font-bold text-green-900 dark:text-gray-200 text-center line-clamp-2 leading-snug">
                {{ sub.name }}
              </p>
              <p v-if="sub.product_count" class="text-xs text-gray-400 text-center mt-0.5">
                {{ sub.product_count }} items
              </p>
            </div>
          </div>
        </div>
      </template>

      <!-- Empty State -->
      <div v-else class="text-center py-24">
        <div class="text-6xl mb-4">📦</div>
        <p class="text-gray-400 text-lg font-medium">{{ $t('categories.noItems') }}</p>
        <button
          @click="navigateTo('/')"
          class="mt-6 px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-full text-sm font-semibold transition-colors"
        >
          {{ $t('categories.goBack') }}
        </button>
      </div>

    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

const route = useRoute()
const { locale, t } = useI18n()

const loading = ref(true)
const error = ref(null)

const categoryTitle = ref('')
const categoryImage = ref('')
const subcategories = ref([])
const products = ref([])

// Fetch category data by slug
const fetchData = async () => {
  loading.value = true
  error.value = null

  try {
    const slug = route.params.slug
    const categoryRes = await $fetch(
      `https://api.thibella.com/public/subcategories/get-subcategory-by-slug.php?slug=${slug}`,
      { headers: { 'Content-Type': 'application/json', 'Accept-Language': locale.value } }
    )

    const categoryData = Array.isArray(categoryRes.data) ? categoryRes.data[0] : categoryRes.data
    subcategories.value = categoryRes.data ?? []

    if (categoryData) {
      categoryTitle.value = categoryData.name || categoryData.title
      categoryImage.value = categoryData.image
    } else {
      error.value = t('categories.notFound')
    }
  } catch (err) {
    error.value = t('categories.failedLoad')
  } finally {
    loading.value = false
  }
}

onMounted(fetchData)
watch(locale, fetchData)

const goToSubcategory = (sub) => {
  navigateTo({
    path: `/category/subcategory/${sub.id}`,
    query: { name: sub.name }
  })
}

const goToProduct = (id) => {
  if (id) navigateTo(`/products/${id}`)
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Staggered fade-in for subcategory cards */
.grid > div {
  animation: fadeSlideUp 0.35s ease both;
}

@keyframes fadeSlideUp {
  from {
    opacity: 0;
    transform: translateY(16px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

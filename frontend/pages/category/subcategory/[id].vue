<script setup>
import { useRoute, useRouter } from 'vue-router'
import { useCartStore } from '~/stores/cart'
import { useI18n } from 'vue-i18n'

const route = useRoute()
const router = useRouter()
const cartStore = useCartStore()
const { locale } = useI18n()
const baseUrl = useRuntimeConfig().public.baseUrl

const error = ref(null)
const parsedProducts = ref([])
const subcategoryTitle = ref('')
const subcategories = ref([])
const productCurrentImageIndex = ref({}) // for image navigation

function safeParseJson(str) {
  try {
    return JSON.parse(str)
  } catch {
    return []
  }
}

// Fetch products by subcategory ID
const { data, error: fetchError } = await useFetch(
  `${baseUrl}/products`,
  { 
    headers: { 'Accept-Language': locale.value },
    params: { subcategory_id: route.params.id }
  }
)

if (fetchError.value || !data.value || !data.value.success) {
  error.value = 'Failed to load products'
} else {
  subcategoryTitle.value =
    data.value.subcategory_name ||
    data.value.products?.[0]?.subcategory ||
    'Products'

  parsedProducts.value = (data.value.products ?? [])
    .filter((p) => p.imageUrl && p.imageUrl !== '')
    .map((p) => ({
      ...p,
      sizes: safeParseJson(p.size),
      colors: safeParseJson(p.color),
      images: safeParseJson(p.possibleImagesUrls),
    }))
}

// Fetch all subcategories (same category) to show as filter chips
// We get the category_id from the current subcategory's data
const categoryId = ref(null)

// After fetching products, try to determine the category_id so we can load sibling subcategories
if (data.value?.products?.[0]?.category_id) {
  categoryId.value = data.value.products[0].category_id
}

// If we have a category_id, fetch sibling subcategories for the chip row
if (categoryId.value) {
  const { data: subData } = await useFetch(
    `${baseUrl}/subcategories`,
    { 
      headers: { 'Accept-Language': locale.value },
      params: { category_id: categoryId.value }
    }
  )
  if (subData.value?.subcategories) {
    subcategories.value = subData.value.subcategories
  }
} else {
  const { data: subData } = await useFetch(
    `${baseUrl}/subcategories`,
    { headers: { 'Accept-Language': locale.value } }
  )
  if (subData.value?.subcategories) {
    subcategories.value = subData.value.subcategories
  }
}

// Product image navigation
const getProductImages = (productId) => {
  const product = parsedProducts.value.find(p => p.id === productId);
  if (!product) return [];
  const images = [product.imageUrl];
  if (product.possibleImagesUrls) {
    if (typeof product.possibleImagesUrls === 'string') {
      try {
        const parsed = JSON.parse(product.possibleImagesUrls);
        if (Array.isArray(parsed)) {
          images.push(...parsed);
        }
      } catch {
        // ignore
      }
    } else if (Array.isArray(product.possibleImagesUrls)) {
      images.push(...product.possibleImagesUrls);
    }
  }
  return images;
};

const getProductCurrentImage = (productId) => {
  const images = getProductImages(productId);
  const index = productCurrentImageIndex.value[productId] ?? 0;
  return images[index] ?? images[0];
};

const prevProductImage = (productId) => {
  const images = getProductImages(productId);
  if (!images.length) return;
  const currentIndex = productCurrentImageIndex.value[productId] ?? 0;
  const newIndex = currentIndex <= 0 ? images.length - 1 : currentIndex - 1;
  productCurrentImageIndex.value[productId] = newIndex;
};

const nextProductImage = (productId) => {
  const images = getProductImages(productId);
  if (!images.length) return;
  const currentIndex = productCurrentImageIndex.value[productId] ?? 0;
  const newIndex = currentIndex >= images.length - 1 ? 0 : currentIndex + 1;
  productCurrentImageIndex.value[productId] = newIndex;
};

const goToSubcategory = (sub) => {
  router.push(`/category/subcategory/${sub.id}`)
}

const goToProduct = (id) => {
  if (id) router.push(`/products/${id}`)
}
</script>

<template>
  <div class="min-h-screen bg-white dark:bg-gray-900 mt-0 px-4">

    <!-- Header -->
    <div class="flex items-center gap-3 mb-6">
      <button
        @click="router.back()"
        class="flex items-center gap-1 text-sm text-gray-500 hover:text-green-600 transition-colors"
      >
        ← {{ $t('categories.back') }}
      </button>

      <h1 class="text-xl font-bold text-green-900 dark:text-white capitalize">
        {{ subcategoryTitle }}
      </h1>
    </div>

    <!-- Subcategory chips (sibling filter) -->
    <!-- <div v-if="subcategories.length > 0" class="flex flex-wrap gap-2 mb-6">
      <button
        v-for="sub in subcategories"
        :key="sub.id"
        @click="goToSubcategory(sub)"
        :class="[
          'px-4 py-1.5 rounded-full text-sm font-medium border transition-all duration-200',
          sub.id == route.params.id
            ? 'bg-green-600 text-white border-green-600 shadow'
            : 'bg-white text-green-800 border-green-300 hover:bg-green-50 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-500'
        ]"
      >
        {{ sub.name }}
      </button>
    </div> -->

    <!-- Error state -->
    <div v-if="error" class="text-center py-16 text-red-500">
      {{ error }}
    </div>

    <!-- Empty state -->
    <div
      v-else-if="parsedProducts.length === 0"
      class="text-center py-16 text-gray-400"
    >
      {{ $t('categories.noProducts') }}
    </div>

    <!-- Products grid -->
    <div
      v-else
      class="mb-4 grid gap-4 grid-cols-2 sm:grid-cols-4 md:gap-6 md:mb-8 lg:grid-cols-4 xl:grid-cols-5"
    >
      <div
        v-for="(product, index) in parsedProducts"
        :key="product.id || index"
        class="group block rounded-lg border border-gray-200 bg-white overflow-hidden shadow-lg
               transition-transform duration-300 hover:scale-105
               dark:border-gray-700 dark:bg-gray-700"
      >
        <!-- Image -->
        <div
          @click.stop=""
          class="relative overflow-hidden h-40 sm:h-48 md:h-56 lg:h-48 xl:h-52"
        >
          <img
            @click="goToProduct(product.id)"
            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110 cursor-pointer"
            :src="getProductCurrentImage(product.id)"
            :alt="product.productName"
          />

          <!-- Price Negotiable Badge -->
          <div class="absolute top-2 left-0 right-0 flex justify-center">
            <span class="bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md tracking-wide">
              💬 {{ $t('products.negotiable') }}
            </span>
          </div>

          <!-- Left/Right Image Navigation -->
          <button 
            @click.stop="prevProductImage(product.id)"
            v-if="getProductImages(product.id).length > 1"
            class="absolute left-1 top-1/2 -translate-y-1/2 w-7 h-7 bg-white dark:bg-gray-700 rounded-full shadow-md flex items-center justify-center text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 z-10 opacity-0 group-hover:opacity-100 transition-opacity"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button 
            @click.stop="nextProductImage(product.id)"
            v-if="getProductImages(product.id).length > 1"
            class="absolute right-1 top-1/2 -translate-y-1/2 w-7 h-7 bg-white dark:bg-gray-700 rounded-full shadow-md flex items-center justify-center text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 z-10 opacity-0 group-hover:opacity-100 transition-opacity"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>

        <!-- Info -->
        <div class="p-2 md:p-3">
          <p class="text-lg text-center font-bold text-green-800 line-clamp-2 dark:text-gray-300">
            {{ product.productName }}
          </p>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
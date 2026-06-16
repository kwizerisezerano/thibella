<template>
  <div>
    <section class="py-8 antialiased md:py-12">

      <!-- Search results banner -->
      <div v-if="query && !loading" class="mb-4 flex items-center justify-between">
        <p class="text-sm text-green-600 dark:text-gray-400">
          <span class="font-bold text-green-800 dark:text-white">{{ displayedProducts.length }} {{ $t('search.results', displayedProducts.length) }}</span>
          {{ $t('search.for') }}
          <span class="text-green-700 dark:text-green-400 font-semibold">"{{ query }}"</span>
        </p>
        <button @click="clearSearch" class="text-xs font-bold text-green-500 hover:text-red-500 underline transition-colors">
          {{ $t('search.clear') }}
        </button>
      </div>

      <!-- Page Title -->
      <div class="mb-6 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight text-green-800 dark:text-white sm:text-4xl">
          {{ $t('products.title') }}
        </h1>
        <p class="mt-2 text-sm text-green-500 dark:text-gray-400">
          {{ $t('products.subtitle') }}
        </p>
      </div>

      <!-- Loading -->
      <div v-if="loading && fetchedProducts.length === 0" class="text-center py-8">
        <p class="text-green-600 dark:text-green-400">{{ $t('products.loading') }}</p>
      </div>

      <!-- Error -->
      <div v-if="error" class="text-center py-8">
        <p class="text-red-600 dark:text-red-400">{{ $t('products.loadError') }}</p>
      </div>

      <!-- Product Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6 mb-4 md:mb-8">
        <div
          v-for="(product, index) in displayedProducts"
          :key="product.id || index"
          class="group block bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 cursor-pointer"
        >
          <!-- Image -->
          <div class="relative overflow-hidden h-40 sm:h-48 md:h-56 lg:h-48 xl:h-52" @click="goToProductDetails(product.id)">
            <img
              class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
              :src="getProductCurrentImage(product.id)"
              :alt="product.productName"
            />
            <!-- Negotiable badge -->
            <div class="absolute top-2 left-0 right-0 flex justify-center">
              <span class="bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md tracking-wide">
                💬 {{ $t('products.negotiable') }}
              </span>
            </div>
            <!-- Image nav buttons -->
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
          <div class="p-2 md:p-3" @click="goToProductDetails(product.id)">
            <p class="text-lg text-center font-bold text-green-800 dark:text-gray-300 line-clamp-2">
              {{ product.productName }}
            </p>
          </div>
        </div>
      </div>

      <!-- No results -->
      <div v-if="!loading && displayedProducts.length === 0 && query" class="text-center py-12">
        <p class="text-gray-500 dark:text-gray-400">{{ $t('search.noResults') }} "{{ query }}"</p>
      </div>

      <!-- Load More -->
      <div v-if="hasMoreProducts" class="flex justify-center mt-4 mb-8">
        <button
          @click="loadMore"
          :disabled="loadingMore"
          class="px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 disabled:opacity-60 disabled:cursor-not-allowed transition-colors duration-200"
        >
          <span v-if="loadingMore">{{ $t('products.loading_more') }}</span>
          <span v-else>{{ $t('products.loadMore') }}</span>
        </button>
      </div>

    </section>
  </div>
</template>


<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useSearchStore } from '~/stores/search';
import { useCartStore } from '~/stores/cart';
import { useRouter } from "vue-router";
import { useI18n } from 'vue-i18n';

const { locale } = useI18n();
const baseUrl = useRuntimeConfig().public.baseUrl;
const router = useRouter();
const searchStore = useSearchStore();
const cartStore = useCartStore();

const fetchedProducts = ref([]);
const loading = ref(true);
const error = ref(null);
const currentPage = ref(1);
const pageLimit = ref(20);
const totalProducts = ref(0);
const loadingMore = ref(false);

const hasMoreProducts = computed(() =>
  !searchStore.query && fetchedProducts.value.length < totalProducts.value
);

const fetchProducts = async (page) => {
  const res = await $fetch(`${baseUrl}/products`, {
    headers: { 'Accept-Language': locale.value },
    params: { page, limit: pageLimit.value }
  });
  return res;
};

const loadInitial = async () => {
  try {
    loading.value = true;
    const res = await fetchProducts(1);
    fetchedProducts.value = res.products ?? [];
    totalProducts.value = res.pagination?.total ?? 0;
    currentPage.value = 1;
  } catch (err) {
    error.value = 'error';
  } finally {
    loading.value = false;
  }
};

watch(locale, loadInitial, { immediate: true });

const loadMore = async () => {
  if (loadingMore.value || !hasMoreProducts.value) return;
  try {
    loadingMore.value = true;
    const nextPage = currentPage.value + 1;
    const res = await fetchProducts(nextPage);
    fetchedProducts.value = [...fetchedProducts.value, ...(res.products ?? [])];
    currentPage.value = nextPage;
  } catch (err) {
    console.error('Error loading more:', err);
  } finally {
    loadingMore.value = false;
  }
};

const query = computed(() => searchStore.query);

const filteredItems = computed(() => {
  const products = fetchedProducts.value;
  if (!query.value) return products;
  const q = query.value.toLowerCase();
  return products.filter(p =>
    p.productName?.toLowerCase().includes(q) ||
    p.categoryName?.toLowerCase().includes(q)
  );
});

const clearSearch = () => searchStore.setQuery('');

const sortOption = useState('sortOption', () => 'default');

const displayedProducts = computed(() => {
  if (query.value) return filteredItems.value;
  return [...filteredItems.value].sort((a, b) => {
    if (sortOption.value === 'price-asc') return (a.priceCents || 0) - (b.priceCents || 0);
    if (sortOption.value === 'price-desc') return (b.priceCents || 0) - (a.priceCents || 0);
    if (sortOption.value === 'name-asc') return (a.productName || '').localeCompare(b.productName || '');
    if (sortOption.value === 'name-desc') return (b.productName || '').localeCompare(a.productName || '');
    return 0;
  });
});

const goToProductDetails = (id) => {
  if (id) router.push(`products/${id}`);
};

// Product image navigation for product cards
const productCurrentImageIndex = ref({}); // key: product.id, value: current index

const getProductImages = (productId) => {
  const product = displayedProducts.value.find(p => p.id === productId);
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
</script>
<style scoped>
.add-to-cart-btn {
  position: relative;
  overflow: hidden;
}
</style>
<template>
  <div>    
    <section class="bg-transparent py-8 antialiased md:py-12">

      <!-- Results Banner — shows only when searching -->
      <div 
        v-if="query && !loading"
        class="mx-auto max-w-screen-xl px-4 2xl:px-0 mb-4 flex items-center justify-between"
      >
        <p class="text-sm text-green-600 dark:text-gray-400">
          <span class="font-bold text-green-800 dark:text-white">
            {{ displayedProducts.length }} {{ $t('search.results', displayedProducts.length) }}
          </span>
          {{ $t('search.for') }}
          <span class="text-green-700 dark:text-green-400 font-semibold">"{{ query }}"</span>
        </p>
        <button
          @click="clearSearch"
          class="text-xs font-bold text-green-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400 underline transition-colors"
        >
          {{ $t('search.clear') }}
        </button>
      </div>

      <!-- Page Title -->
      <div class="mx-auto max-w-screen-xl px-4 2xl:px-0 mb-6">
        <h1 class="text-3xl font-extrabold tracking-tight text-green-800 dark:text-white sm:text-4xl text-center">
          {{ $t('products.title') }}
        </h1>
        <p class="mt-2 text-sm text-green-500 dark:text-gray-400 text-center">
          {{ $t('products.subtitle') }}
        </p>
      </div>

      <!-- Loading State -->
      <div v-if="loading && fetchedProducts.length === 0" class="mx-auto max-w-screen-xl px-4 2xl:px-0 text-center">
        <p class="text-green-600 dark:text-green-400">{{ $t('products.loading') }}</p>
      </div>

      <!-- Error State -->
      <div v-if="error" class="mx-auto max-w-screen-xl px-4 2xl:px-0 text-center">
        <p class="text-red-600 dark:text-red-400">{{ $t('products.loadError') }}: {{ error }}</p>
      </div>

      <!-- Product Grid -->
      <div class="mb-4 grid gap-4 grid-cols-2 sm:grid-cols-4 md:gap-6 md:mb-8 lg:grid-cols-4 xl:grid-cols-5">
        <div
          v-for="(product, index) in displayedProducts"
          :key="product.id || index"
          class="group block rounded-lg border border-gray-200 bg-white overflow-hidden shadow-lg transition-transform duration-300 hover:scale-105 dark:border-gray-700 dark:bg-gray-700"
        >
          <!-- Image Section -->
          <div
            @click="goToProductDetails(product.id)"
            class="relative overflow-hidden cursor-pointer h-40 sm:h-48 md:h-56 lg:h-48 xl:h-52"
          >
            <img
              class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
              :src="product.imageUrl"
              :alt="product.productName"
            />

            <!-- Price Negotiable Badge -->
            <div class="absolute top-2 left-0 right-0 flex justify-center">
              <span class="bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md tracking-wide">
                💬 {{ $t('products.negotiable') }}
              </span>
            </div>
          </div>

          <!-- Details Section -->
          <div class="p-2 md:p-3">
            <p class="mt-1 text-sm font-bold text-gray-900 sm:text-base dark:text-white">
              <!-- {{ formatCurrency(cartStore.convertPrice(product.priceCents), cartStore.selectedCurrency) }} -->
            </p>
            <strong>
              <p class="text-lg text-center text-bold text-green-800 line-clamp-2 dark:text-gray-300">
                {{ product.productName }}
              </p>
            </strong>
          </div>
        </div>
      </div>

      <!-- Show More Button -->
      <div v-if="hasMoreProducts" class="mx-auto max-w-screen-xl px-4 2xl:px-0 flex justify-center mt-4 mb-8">
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

<!-- <script setup>
import { ref, computed, onMounted } from 'vue';
import { useSearchStore } from '~/stores/search';
import { useCartStore } from '~/stores/cart';
import { useRouter } from "vue-router";

const router = useRouter();

// Reactive state
const fetchedProducts = ref([]);
const data = ref([]);
const f = ref([]);
const loading = ref(true);
const error = ref(null);

// Pagination state
const currentPage = ref(1);
const pageLimit = ref(20);
const totalProducts = ref(0);
const loadingMore = ref(false);

const hasMoreProducts = computed(() => fetchedProducts.value.length < totalProducts.value);

const fetchProducts = async (page) => {
  const res = await $fetch('https://api.thibella.com/public/products/get-products.php', {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      'Accept-Language': 'en'
    },
    params: {
      page,
      limit: pageLimit.value
    }
  });

  return res;
};

onMounted(async () => {
  try {
    loading.value = true;
    error.value = null;

    const res = await fetchProducts(1);

    fetchedProducts.value = res.data;
    totalProducts.value = res.pagination.total_products;
    currentPage.value = 1;

  } catch (err) {
    console.error('Error fetching products:', err);
    error.value = 'Failed to load products';
  } finally {
    loading.value = false;
  }
});

const loadMore = async () => {
  if (loadingMore.value || !hasMoreProducts.value) return;

  try {
    loadingMore.value = true;
    const nextPage = currentPage.value + 1;

    const res = await fetchProducts(nextPage);

    fetchedProducts.value = [...fetchedProducts.value, ...res.data];
    currentPage.value = nextPage;

  } catch (err) {
    console.error('Error loading more products:', err);
  } finally {
    loadingMore.value = false;
  }
};

const productsData = computed(() => {
  return fetchedProducts.value.length > 0 ? fetchedProducts.value : (data.value?.data ?? []);
});

// Search functionality using store
const searchStore = useSearchStore();
const query = computed({
  get: () => searchStore.query,
  set: (value) => searchStore.setQuery(value)
});

// filteredItems computed
const filteredItems = computed(() => {
  const products = productsData.value
  if (!query.value) return products

  return products.filter((product) => {
    const nameMatch = product.productName?.toLowerCase().includes(query.value.toLowerCase())
    const categoryMatch = product.categoryName?.toLowerCase().includes(query.value.toLowerCase())
    return nameMatch || categoryMatch
  })
})

// const filteredItems = computed(() => {
//   const products = productsData.value;
//   if (!query.value) {
//     return products;
//   }
//   return products.filter((product) => {
//     return product.productName && product.productName.toLowerCase().includes(query.value.toLowerCase());
//   });
// });

// Sorting options
const sortOption = useState('sortOption', () => 'price-desc');

const displayedProducts = computed(() => {
  return [...filteredItems.value].sort((a, b) => {
    if (sortOption.value === 'price-asc') return (a.priceCents || 0) - (b.priceCents || 0);
    if (sortOption.value === 'price-desc') return (b.priceCents || 0) - (a.priceCents || 0);
    if (sortOption.value === 'name-asc') return (a.productName || '').localeCompare(b.productName || '');
    if (sortOption.value === 'name-desc') return (b.productName || '').localeCompare(a.productName || '');
    return 0;
  });
});

// Navigation
const goToProductDetails = (id) => {
  if (id) {
    router.push(`products/${id}`);
  }
};

// Cart store
const cartStore = useCartStore();

console.log("Displayed Products:", displayedProducts.value);
</script> -->
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

onMounted(loadInitial);
watch(locale, loadInitial);

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
</script>
<style scoped>
.add-to-cart-btn {
  position: relative;
  overflow: hidden;
}
</style>
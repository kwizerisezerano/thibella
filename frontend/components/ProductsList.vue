<template>
  <div>
    <section class="py-6 antialiased">

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

      <!-- Loading -->
      <div v-if="loading && fetchedProducts.length === 0" class="text-center py-8">
        <p class="text-green-600 dark:text-green-400">{{ $t('products.loading') }}</p>
      </div>

      <!-- Error -->
      <div v-if="error" class="text-center py-8">
        <p class="text-red-600 dark:text-red-400">{{ $t('products.loadError') }}</p>
      </div>

      <!-- Product Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
        <div
          v-for="(product, index) in displayedProducts"
          :key="product.id || index"
          @click="goToProductDetails(product.id)"
          class="group bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 cursor-pointer"
        >
          <!-- Image -->
          <div class="relative overflow-hidden aspect-square">
            <img
              class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
              :src="product.imageUrl"
              :alt="product.productName"
            />
            <div v-if="product.isOnSale" class="absolute top-2 left-2">
              <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">SALE</span>
            </div>
          </div>

          <!-- Info -->
          <div class="p-2.5">
            <p class="text-xs sm:text-sm font-semibold text-gray-800 dark:text-white line-clamp-2 leading-snug">
              {{ product.productName }}
            </p>
            <p class="mt-1 text-xs text-green-600 dark:text-green-400 font-medium">
              {{ $t('products.negotiable') }}
            </p>
          </div>
        </div>
      </div>

      <!-- No results -->
      <div v-if="!loading && displayedProducts.length === 0 && query" class="text-center py-12">
        <p class="text-gray-500 dark:text-gray-400">{{ $t('search.noResults') }} "{{ query }}"</p>
      </div>

      <!-- Load More -->
      <div v-if="hasMoreProducts" class="flex justify-center mt-8 mb-4">
        <button
          @click="loadMore"
          :disabled="loadingMore"
          class="px-8 py-2.5 text-sm font-medium text-white bg-green-600 rounded-full hover:bg-green-700 disabled:opacity-60 disabled:cursor-not-allowed transition-colors"
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
</script>
<style scoped>
.add-to-cart-btn {
  position: relative;
  overflow: hidden;
}
</style>
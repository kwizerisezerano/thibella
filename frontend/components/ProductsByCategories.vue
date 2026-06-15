<template>
  <div>
    <section class="py-6 antialiased">

      <div v-if="loading" class="text-center py-4">
        <p class="text-green-600 dark:text-gray-400 text-sm">{{ $t('categories.loading') }}</p>
      </div>

      <div v-else-if="error" class="text-center py-4">
        <p class="text-red-600 dark:text-red-400 text-sm">{{ $t('categories.error') }}</p>
      </div>

      <div v-else class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-6 gap-3 sm:gap-4">
        <div
          v-for="category in categories"
          :key="category.id"
          @click="handleCategoryClick(category)"
          class="group flex flex-col items-center cursor-pointer"
        >
          <div v-if="loadingCategoryId === category.id" class="w-full aspect-square rounded-xl flex items-center justify-center bg-gray-100 dark:bg-gray-700">
            <svg class="animate-spin h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
          </div>
          <div v-else class="w-full aspect-square rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:scale-105">
            <img :src="category.image" :alt="category.title" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" />
          </div>
          <p class="mt-2 text-xs sm:text-sm font-medium text-center text-gray-800 dark:text-gray-200 line-clamp-1">
            {{ category.title }}
          </p>
        </div>
      </div>

    </section>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useSearchStore } from '~/stores/search';
import { useI18n } from 'vue-i18n';

const { locale } = useI18n()
const baseUrl = useRuntimeConfig().public.baseUrl
const searchStore = useSearchStore();
const router = useRouter();

const categories = ref([]);
const loading = ref(true);
const error = ref(null);
const loadingCategoryId = ref(null);

const fetchCategories = async () => {
  try {
    loading.value = true;
    error.value = null;
    const res = await $fetch(`${baseUrl}/categories`, {
      headers: { 'Accept-Language': locale.value }
    });
    categories.value = res.categories ?? res.data ?? [];
  } catch (err) {
    error.value = 'error';
  } finally {
    loading.value = false;
  }
};

watch(locale, fetchCategories, { immediate: true });

const handleCategoryClick = (category) => {
  if (!category.slug) return
  router.push(`/category/${category.slug}`)
}
</script>
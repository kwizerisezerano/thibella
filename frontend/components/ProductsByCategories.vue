<template>
  <div>    
    <section class="bg-transparent py-8 antialiased md:py-12">
      <!-- Loading State -->
      <div v-if="loading" class="mx-auto max-w-screen-xl px-4 2xl:px-0 text-center">
        <p class="text-green-600 dark:text-gray-400">{{ $t('categories.loading') }}</p>
      </div>

      <!-- Error State -->
      <div v-if="error" class="mx-auto max-w-screen-xl px-4 2xl:px-0 text-center">
        <p class="text-red-600 dark:text-red-400">{{ $t('categories.error') }}</p>
      </div>

      <!-- Categories Section -->
      <div v-if="!loading && !error" class="mx-auto max-w-screen-xl px-4 2xl:px-0">

        <!-- Categories Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-10">
          <div
            v-for="category in categories"
            :key="category.id"
            @click="handleCategoryClick(category)"
            class="group flex flex-col items-center cursor-pointer bg-white dark:bg-gray-700 rounded-2xl p-3"
          >
            <!-- Loading overlay per card -->
            <div v-if="loadingCategoryId === category.id" class="w-full aspect-square rounded-xl flex items-center justify-center bg-gray-100 dark:bg-gray-600">
              <svg class="animate-spin h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
              </svg>
            </div>

            <!-- Category Image -->
            <div v-else class="w-full aspect-square rounded-xl overflow-hidden border border-gray-200 dark:border-gray-900 shadow-sm transition-transform duration-300 group-hover:scale-105">
              <img
                :src="category.image"
                :alt="category.title"
                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
              />
            </div>

            <!-- Category Name -->
            <p class="mt-2 text-sm font-medium text-center text-green-900 dark:text-gray-200">
              {{ category.title }}
            </p>
          </div>
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

onMounted(fetchCategories);
watch(locale, fetchCategories);

const handleCategoryClick = (category) => {
  if (!category.slug) return
  router.push(`/category/${category.slug}`)
}
</script>
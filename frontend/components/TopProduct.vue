<template>
  <div v-if="slides.length > 0" class="relative w-full h-96">
    <!-- Background Image -->
    <img
      v-if="slides[currentSlide]"
      :src="slides[currentSlide]?.image"
      :key="currentSlide"
      alt=""
      class="absolute inset-0 w-full h-full object-cover transition-all duration-700"
    />

    <!-- Dark overlay -->
    <div class="absolute inset-0 bg-black/50"></div>

    <!-- Main Content Row -->
    <div class="absolute inset-0 z-10 flex items-center justify-start -mt-64 gap-4 px-4">

      <!-- Previous Button -->
      <button
        @click.prevent="previousSlide"
        class="shrink-0 backdrop-blur-sm text-white p-3 sm:p-4 rounded-full transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-300"
        aria-label="Previous slide"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </button>

      <!-- Slide Content - Clickable Category Banner -->
      <NuxtLink
        :to="slides[currentSlide]?.route"
        :key="currentSlide"
        class="flex-1 flex flex-col items-center justify-center text-center group cursor-pointer"
      >

        <!-- Title -->
        <h1
          class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-2 sm:mb-3 md:mb-4 drop-shadow-lg animate-fade-in leading-tight"
        >
          {{ slides[currentSlide]?.title }}
        </h1>

        <!-- Description -->
        <p
          class="text-xs sm:text-sm md:text-base text-white/80 max-w-xs sm:max-w-sm md:max-w-xl mx-auto animate-fade-in-delay"
        >
          {{ slides[currentSlide]?.description }}
        </p>

      </NuxtLink>

      <!-- Next Button -->
      <button
        @click.prevent="nextSlide"
        class="shrink-0 backdrop-blur-sm text-white p-3 sm:p-4 rounded-full transition-all duration-300 hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-300"
        aria-label="Next slide"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </button>
    </div>
  </div>
  <!-- fall back -->
  <div v-else class="w-full h-96 bg-gray-200 animate-pulse" />

</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import { useI18n } from 'vue-i18n';

const { locale } = useI18n();
const baseUrl = useRuntimeConfig().public.baseUrl;

const currentSlide = ref(0);
const categories = ref([]);
const loading = ref(true);
const error = ref(null);

const fetchCategories = async () => {
  try {
    const res = await $fetch(`${baseUrl}/categories`, {
      headers: { 'Accept-Language': locale.value }
    })
    categories.value = res.categories ?? res.data ?? []
  } catch (err) {
    error.value = 'Failed to load categories'
  } finally {
    loading.value = false
  }
}

const slides = computed(() =>
  categories.value.map((item) => ({
    categoryId: item.id,
    title: item.title,
    description: item.description,
    image: item.image,
    route: `category/${item.slug}`
  }))
)

let autoplayInterval = null;

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % slides.value.length;
};

const previousSlide = () => {
  currentSlide.value = currentSlide.value === 0 ? slides.value.length - 1 : currentSlide.value - 1;
};

const goToSlide = (index) => {
  currentSlide.value = index;
};

const startAutoplay = () => {
  autoplayInterval = setInterval(nextSlide, 5000);
};

const stopAutoplay = () => {
  if (autoplayInterval) clearInterval(autoplayInterval);
};

onMounted(() => {
    fetchCategories()
    startAutoplay()
  }
);
watch(locale, fetchCategories);
onUnmounted(() => stopAutoplay());
</script>

<style scoped>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-out both;
}

.animate-fade-in-delay {
  animation: fadeIn 0.5s ease-out 0.2s both;
}
</style>
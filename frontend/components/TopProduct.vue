<template>
  <div v-if="slides.length > 0" class="relative w-full h-[270px] sm:h-[350px] overflow-hidden">

    <!-- Background Image -->
    <img
      v-if="slides[currentSlide]"
      :src="slides[currentSlide]?.image"
      :key="currentSlide"
      alt=""
      class="absolute inset-0 w-full h-full object-cover transition-all duration-700"
    />

    <!-- Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

    <!-- Centered Content -->
    <div class="absolute inset-0 z-10 flex flex-col items-center justify-center text-center px-3 sm:px-4">
      <NuxtLink :to="slides[currentSlide]?.route" class="group w-full">
        <div class="w-full px-3 sm:px-4">
          <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white drop-shadow-lg animate-fade-in leading-tight mb-3" style="font-family: Georgia, serif;">
            {{ slides[currentSlide]?.title }}
          </h1>
          <p class="text-sm sm:text-base md:text-lg text-white/80 max-w-xl mx-auto animate-fade-in-delay mb-6" style="font-family: 'Segoe UI', sans-serif;">
            {{ slides[currentSlide]?.description }}
          </p>
        </div>
      </NuxtLink>
    </div>

    <!-- Prev Button -->
    <button
      @click.prevent="previousSlide"
      class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-black/50 text-white p-2.5 rounded-full transition-all backdrop-blur-sm"
      aria-label="Previous slide"
    >
      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
    </button>

    <!-- Next Button -->
    <button
      @click.prevent="nextSlide"
      class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 z-20 bg-black/30 hover:bg-black/50 text-white p-2.5 rounded-full transition-all backdrop-blur-sm"
      aria-label="Next slide"
    >
      <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
    </button>

  </div>
  <div v-else class="w-full h-[420px] sm:h-[500px] bg-gray-200 dark:bg-gray-700 animate-pulse" />
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import { useI18n } from 'vue-i18n';

const { locale, t } = useI18n();
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

watch(locale, fetchCategories, { immediate: true });
onMounted(startAutoplay);
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
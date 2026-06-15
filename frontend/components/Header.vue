<template>
  <header class="bg-white dark:bg-gray-900 shadow-md sticky top-0 z-50">
    <div class="w-full px-3 sm:px-4 py-3 sm:py-4">
      <div class="flex items-center justify-between">

        <!-- LEFT: Logo + Nav -->
        <div class="flex items-center gap-4 xl:gap-6 flex-shrink-0">
          <NuxtLink to="/" class="flex-shrink-0">
            <svg viewBox="0 0 300 60" xmlns="http://www.w3.org/2000/svg" class="h-9 sm:h-11 w-auto">
              <text x="0" y="46" font-family="Georgia, serif" font-size="48" font-weight="700" letter-spacing="2" fill="#059669" font-style="italic">Thibella</text>
              <path d="M 0 54 Q 60 57, 130 54 T 270 54" stroke="#10B981" stroke-width="2" fill="none" opacity="0.8" stroke-linecap="round"/>
              <circle cx="273" cy="54" r="2.5" fill="#10B981"/>
              <circle cx="280" cy="54" r="1.5" fill="#34D399" opacity="0.7"/>
            </svg>
          </NuxtLink>

          <nav class="hidden lg:flex items-center gap-4 xl:gap-6">
            <NuxtLink
              v-for="item in menuItems"
              :key="item.path"
              :to="item.path"
              class="text-sm text-green-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-colors px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
            >
              {{ $t(item.label) }}
            </NuxtLink>
          </nav>
        </div>

        <!-- MIDDLE: Search -->
        <div class="flex-1 mx-6 hidden md:flex">
          <SearchBar />
        </div>

        <!-- RIGHT: Icons -->
        <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">

          <!-- Mobile Search -->
          <div class="md:hidden">
            <SearchBar />
          </div>

          <!-- Language Selector -->
          <div class="hidden sm:block relative" ref="dropdownRef">
            <button
              @click="isOpen = !isOpen"
              class="flex items-center gap-1 border border-green-300 dark:border-green-600 rounded px-2 py-1 text-sm text-green-700 dark:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors"
            >
              <img :src="`https://flagcdn.com/20x15/${languages.find(l => l.value === currentLanguage)?.flag}.png`" width="20" height="15" class="rounded-sm" />
              {{ currentLanguage.toUpperCase() }}
              <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div
              v-if="isOpen"
              class="absolute right-0 mt-1 bg-white dark:bg-gray-900 border border-green-200 dark:border-green-700 rounded shadow-lg z-50 min-w-[90px]"
            >
              <button
                v-for="lang in languages"
                :key="lang.value"
                @click="switchLanguage(lang.value)"
                class="w-full text-left px-3 py-1.5 text-sm text-green-700 dark:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/30 transition-colors flex items-center gap-2"
                :class="{ 'bg-green-100 dark:bg-green-900/50': currentLanguage === lang.value }"
              >
                <img :src="`https://flagcdn.com/20x15/${lang.flag}.png`" width="20" height="15" class="rounded-sm" />
                {{ lang.label }}
              </button>
            </div>
          </div>

          <!-- User Account -->
          <Profile />

          <!-- Dark Mode Toggle -->
          <button
            @click="toggleDarkMode"
            class="p-1.5 sm:p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300"
            aria-label="Toggle dark mode"
          >
            <svg v-if="!isDark" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
            <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="5"/>
              <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
              <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
            </svg>
          </button>

          <!-- Mobile Hamburger -->
          <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="lg:hidden p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition-colors"
            :aria-expanded="mobileMenuOpen"
            :aria-label="mobileMenuOpen ? 'Close menu' : 'Open menu'"
          >
            <span class="text-2xl text-green-600">{{ mobileMenuOpen ? '✕' : '☰' }}</span>
          </button>

        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <transition
      enter-active-class="transition-all duration-300 ease-out"
      leave-active-class="transition-all duration-200 ease-in"
      enter-from-class="opacity-0 max-h-0"
      enter-to-class="opacity-100 max-h-screen"
      leave-from-class="opacity-100 max-h-screen"
      leave-to-class="opacity-0 max-h-0"
    >
      <div
        v-show="mobileMenuOpen"
        class="lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 overflow-hidden"
      >
        <nav class="w-full px-3 sm:px-4 py-3 flex flex-col">
          <template v-for="(item, index) in menuItems" :key="'mobile-' + item.path">
            <NuxtLink
              :to="item.path"
              @click="mobileMenuOpen = false"
              class="py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
            >
              {{ $t(item.label) }}
            </NuxtLink>
            <div v-if="index < menuItems.length - 1" class="border-b border-gray-100 dark:border-gray-800 my-1"></div>
          </template>

          <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-800 flex gap-2">
            <button
              v-for="lang in languages"
              :key="lang.value"
              @click="switchLanguage(lang.value)"
              class="flex items-center gap-1.5 px-3 py-1.5 rounded border text-sm text-green-700 dark:text-green-300 transition-colors"
              :class="currentLanguage === lang.value ? 'border-green-500 bg-green-50 dark:bg-green-900/40' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800'"
            >
              <img :src="`https://flagcdn.com/20x15/${lang.flag}.png`" width="20" height="15" class="rounded-sm" />
              {{ lang.label }}
            </button>
          </div>
        </nav>
      </div>
    </transition>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useCartStore } from '~/stores/cart'
import { useI18n } from 'vue-i18n'

const { isDark, toggleDarkMode } = useDarkMode()
const { locale, setLocale } = useI18n()
const cartStore = useCartStore()
const mobileMenuOpen = ref(false)
const isOpen = ref(false)
const dropdownRef = ref(null)

const menuItems = [
  { label: 'nav.home',       path: '/' },
  { label: 'nav.products',   path: '/products' },
  { label: 'nav.categories', path: '/categories' },
]

const languages = [
  { value: 'en', label: 'EN', flag: 'us' },
  { value: 'rw', label: 'RW', flag: 'rw' },
  { value: 'fr', label: 'FR', flag: 'fr' },
  { value: 'sw', label: 'SW', flag: 'tz' },
]

const currentLanguage = computed(() => locale.value)

function switchLanguage(lang) {
  setLocale(lang)
  switch (lang) {
    case 'en': cartStore.setCurrency('USD'); break
    case 'rw': cartStore.setCurrency('RWF'); break
    case 'fr': cartStore.setCurrency('EUR'); break
    case 'sw': cartStore.setCurrency('TZS'); break
  }
  isOpen.value = false
  mobileMenuOpen.value = false
}

onMounted(() => document.addEventListener('click', handleClickOutside))
onUnmounted(() => document.removeEventListener('click', handleClickOutside))

function handleClickOutside(e) {
  if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
    isOpen.value = false
  }
}
</script>

<template>
  <header class="bg-white dark:bg-gray-900 shadow-md sticky top-0 z-50">
    <div class="w-full px-3 sm:px-4 py-3">
      <div class="flex items-center justify-between gap-2">

        <!-- LEFT: Hamburger (mobile) + Logo + Desktop Nav -->
        <div class="flex items-center gap-3 xl:gap-6 flex-shrink-0">

          <!-- Mobile Hamburger (LEFT on mobile) -->
          <button
            @click="mobileMenuOpen = !mobileMenuOpen"
            class="lg:hidden p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition-colors flex-shrink-0"
            :aria-expanded="mobileMenuOpen"
            :aria-label="mobileMenuOpen ? 'Close menu' : 'Open menu'"
          >
            <svg v-if="mobileMenuOpen" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="text-green-600">
              <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
            <svg v-else width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="text-green-600">
              <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
          </button>

          <NuxtLink to="/" class="flex-shrink-0">
            <svg viewBox="0 0 300 60" xmlns="http://www.w3.org/2000/svg" class="h-8 sm:h-10 w-auto">
              <text x="0" y="46" font-family="Georgia, serif" font-size="48" font-weight="700" letter-spacing="2" fill="#059669" font-style="italic">Thibella</text>
              <path d="M 0 54 Q 60 57, 130 54 T 270 54" stroke="#10B981" stroke-width="2" fill="none" opacity="0.8" stroke-linecap="round"/>
              <circle cx="273" cy="54" r="2.5" fill="#10B981"/>
              <circle cx="280" cy="54" r="1.5" fill="#34D399" opacity="0.7"/>
            </svg>
          </NuxtLink>

          <nav class="hidden lg:flex items-center gap-1 xl:gap-2">
            <NuxtLink
              v-for="item in menuItems"
              :key="item.path"
              :to="item.path"
              class="text-sm text-green-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-colors px-2 py-1.5 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 whitespace-nowrap"
            >
              {{ $t(item.label) }}
            </NuxtLink>
          </nav>
        </div>

        <!-- MIDDLE: Search (desktop only) -->
        <div class="flex-1 min-w-0 mx-3 hidden lg:flex max-w-sm xl:max-w-lg">
          <SearchBar />
        </div>

        <!-- RIGHT: Icons -->
        <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">

          <!-- Search icon (mobile + tablet) -->
          <div class="lg:hidden">
            <SearchBar />
          </div>

          <!-- Language Selector -->
          <div class="relative" ref="dropdownRef">
            <button
              @click="isOpen = !isOpen"
              class="flex items-center gap-1 border border-green-300 dark:border-green-600 rounded px-1.5 sm:px-2 py-1 text-xs sm:text-sm text-green-700 dark:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors"
            >
              <img
                :src="`https://flagcdn.com/20x15/${languages.find(l => l.value === currentLanguage)?.flag}.png`"
                width="20" height="15"
                class="rounded-sm flex-shrink-0"
              />
              <span class="hidden xs:inline">{{ currentLanguage.toUpperCase() }}</span>
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            class="p-1.5 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300 flex-shrink-0"
            aria-label="Toggle dark mode"
          >
            <svg v-if="!isDark" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </svg>
            <svg v-else width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="5"/>
              <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
              <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <transition
      enter-active-class="transition-all duration-300 ease-out"
      leave-active-class="transition-all duration-200 ease-in"
      enter-from-class="opacity-0 -translate-y-1"
      enter-to-class="opacity-100 translate-y-0"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-1"
    >
      <div
        v-show="mobileMenuOpen"
        class="lg:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700"
      >
        <nav class="w-full px-3 sm:px-4 py-2 flex flex-col">
          <template v-for="(item, index) in menuItems" :key="'mobile-' + item.path">
            <NuxtLink
              :to="item.path"
              @click="mobileMenuOpen = false"
              class="py-2.5 px-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors font-medium"
            >
              {{ $t(item.label) }}
            </NuxtLink>
            <div v-if="index < menuItems.length - 1" class="border-b border-gray-100 dark:border-gray-800 mx-2"></div>
          </template>
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

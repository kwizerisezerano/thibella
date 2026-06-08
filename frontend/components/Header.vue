<template>
  <header class="bg-white dark:bg-gray-900 shadow-md sticky top-0 z-50 transition-colors duration-300">
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
      <div class="flex items-center justify-between gap-1 sm:gap-6">

      <!-- Mobile Menu Toggle -->
      <button 
        @click="mobileMenuOpen = !mobileMenuOpen"
        class="lg:hidden p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 rounded transition-colors relative z-50"
        :aria-expanded="mobileMenuOpen"
        :aria-label="mobileMenuOpen ? 'Close menu' : 'Open menu'"
      >
        <span class="text-2xl text-green-600">{{ mobileMenuOpen ? '✕' : '☰' }}</span>
      </button>

        <!-- Logo -->
        <NuxtLink to="/" class="flex-shrink-0">
          <svg viewBox="0 0 500 110" xmlns="http://www.w3.org/2000/svg" class="h-10 sm:h-12 ml-[-30px] sm:ml-[-70px] mb-2 sm:mb-[13px] w-auto">
            
            <!-- Brand name with elegant styling -->
            <text x="110" y="95" font-family="Georgia, serif" font-size="64" font-weight="700" letter-spacing="2" fill="#059669" font-style="italic">
              Thibella
            </text>

            <!-- Smaller "com" text positioned right after "." -->
            <text x="420" y="95" font-family="Georgia, serif" font-size="32" font-weight="400" fill="#059669" font-style="normal" opacity="0.85">
              
            </text>
            
            <!-- Decorative flourish under the name -->
            <path d="M 110 105 Q 180 108, 250 105 T 390 105" stroke="#10B981" stroke-width="2.5" fill="none" opacity="0.8" stroke-linecap="round"/>
            
            <!-- Elegant accent dots -->
            <circle cx="395" cy="105" r="3" fill="#10B981"/>
            <circle cx="405" cy="105" r="2" fill="#34D399" opacity="0.7"/>
          </svg>
        </NuxtLink>

        <!-- Navigation Menu (Desktop) -->
        <nav class="hidden lg:flex items-center gap-4 xl:gap-6">
          <NuxtLink 
            v-for="item in menuItems" 
            :key="item.path"
            :to="item.path"
            class="text-sm sm:text-base text-green-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 font-medium transition-colors px-2 py-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
          >
            {{ item.label }}
          </NuxtLink>
        </nav>

        <!-- Desktop Search -->
        <div class="hidden md:flex flex-1 max-w-xl">
          <SearchBar />  
        </div>

        <!-- Mobile Search -->
        <div class="md:hidden mt-3">
          <SearchBar />  
        </div>

        <!-- Right Actions -->
        <div class="flex items-center gap-2 sm:gap-4 border-green-300 dark:border-green-600">
          <div class="hidden sm:block">
           <div class="hidden sm:block relative" ref="dropdownRef">
            <button
              @click="isOpen = !isOpen"
              class="flex items-center gap-1 border border-green-300 dark:border-green-600 rounded px-2 py-1 text-sm text-green-700 dark:text-green-300 bg-transparent hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors"
            >
              {{ languages.find(l => l.value === currentLanguage)?.flag }} {{ currentLanguage.toUpperCase() }}
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
      @click="currentLanguage = lang.value; isOpen = false"
      class="w-full text-left px-3 py-1.5 text-sm text-green-700 dark:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/30 transition-colors"
      :class="{ 'bg-green-100 dark:bg-green-900/50': currentLanguage === lang.value }"
    >
      {{ lang.flag }} {{ lang.label }}
    </button>
  </div>
</div>
          </div>

          <!-- Cart -->
          <!-- <NuxtLink 
            to="/cart"
            class="relative p-1.5 sm:p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors"
            aria-label="Shopping cart"
          >
            <span class="text-xl sm:text-2xl">🛒</span>
            <span 
              v-if="cartCount > 0"
              class="absolute -top-1 -right-1 bg-green-600 text-white text-[10px] sm:text-xs rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center"
            >
              {{ cartCount }}
            </span>
          </NuxtLink> -->

          <!-- User Account -->
          <Profile />

          <!-- Dark Mode Toggle -->
          <button 
            @click="toggleDarkMode"
            class="p-1.5 sm:p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300"
            aria-label="Toggle dark mode"
          >
            <svg v-if="!isDark" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="5"></circle>
              <line x1="12" y1="1" x2="12" y2="3"></line>
              <line x1="12" y1="21" x2="12" y2="23"></line>
              <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
              <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
              <line x1="1" y1="12" x2="3" y2="12"></line>
              <line x1="21" y1="12" x2="23" y2="12"></line>
              <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
              <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
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
        <nav class="container mx-auto px-4 py-3 flex flex-col">
          <!-- Mobile Navigation Links -->
          <template v-for="(item, index) in menuItems" :key="'mobile-' + item.path">
            <NuxtLink 
              :to="item.path"
              @click="mobileMenuOpen = false"
              class="py-3 px-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
            >
              {{ item.label }}
            </NuxtLink>
            <div v-if="index < menuItems.length - 1" class="border-b border-gray-100 dark:border-gray-800 my-1"></div>
          </template>
          
          <!-- Mobile Language Selector -->
          <div class="mt-3 pt-3 border-t border-gray-100 dark:border-gray-800">
            <select
              v-model="currentLanguage"
              class="w-full p-2 bg-gray-50 dark:bg-gray-800 text-green-700 border border-gray-200 dark:border-gray-700 rounded-md text-gray-700 dark:text-gray-300"
              @change="mobileMenuOpen = false"
            >
              <option value="en">🇺🇸 </option>
              <option value="rw">🇷🇼 </option>
              <option value="fr">🇫🇷 </option>
            </select>
          </div>
          
          <!-- Mobile Account Link -->
          <!-- <NuxtLink 
            to="/login"
            @click="mobileMenuOpen = false"
            class="mt-3 py-3 px-2 flex items-center gap-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-md transition-colors"
          >
           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-700 dark:text-gray-300">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Sign in</span>
          </NuxtLink> -->
        </nav>
      </div>
    </transition>
  </header>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { useCartStore } from '~/stores/cart'
import { useSearchStore } from '~/stores/search'
import { useRouter } from 'vue-router'


// USE THE COMPOSABLE!
const { isDark, toggleDarkMode } = useDarkMode()

// State
const mobileMenuOpen = ref(false)
const currentLanguage = ref('rw')
const router = useRouter()
const searchStore = useSearchStore()
const searchQuery = ref(searchStore.query)
const wishlistCount = ref(5)

const menuItems = [
  {
    label: "Home",
    path: "/"
  },
  {
    label: "Products",
    path: "/products"
  },
  {
    label: "Categories",
    path: "/categories"
  },
  // {
  //   label: "orders",
  //   path: "/orders/history"
  // },
]


// Cart Store
const cartStore = useCartStore()
const cartCount = computed(() => cartStore.cartTotalQuantity)

// Set initial currency based on default language
onMounted(() => { 
  // Trigger the language change to set initial currency
  currentLanguage.value = currentLanguage.value
})



const performSearch = (query) => {
  searchQuery.value = query
  searchStore.setQuery(query)
  // Navigate to home page if not already there
  if (router.currentRoute.value.path !== '/') {
    router.push('/')
  }
}


// Watch language changes and update currency accordingly
watch(currentLanguage, (newLang) => {
  console.log('Language changed to:', newLang)
  // Update currency based on language
  switch(newLang) {
    case 'en':
      cartStore.setCurrency('USD')
      break
    case 'rw':
      cartStore.setCurrency('RWF')
      break
    case 'fr':
      cartStore.setCurrency('EUR')
      break
  }
  // Here you would implement actual language switching logic
})

const isOpen = ref(false)
const dropdownRef = ref(null)

const languages = [
  { value: 'en', label: 'EN', flag: '🇺🇸' },
  { value: 'rw', label: 'RW', flag: '🇷🇼' },
  { value: 'fr', label: 'FR', flag: '🇫🇷' },
]

onMounted(() => document.addEventListener('click', handleClickOutside))
onUnmounted(() => document.removeEventListener('click', handleClickOutside))

function handleClickOutside(e) {
  if (dropdownRef.value && !dropdownRef.value.contains(e.target)) {
    isOpen.value = false
  }
}
</script>

<style scoped>
/* Smooth transitions */
* {
  transition-property: background-color, border-color, color;
  transition-timing-function: ease-in-out;
  transition-duration: 200ms;
}
</style>
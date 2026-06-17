<template>
  <div class="relative w-full" ref="searchRef">

    <!-- DESKTOP / LARGE: always-visible inline input -->
    <div class="hidden lg:block relative w-full">
      <input
        type="text"
        :value="searchQuery"
        @input="onInput"
        @focus="onFocus"
        @keydown.enter="onEnter"
        @keydown.escape="closeSuggestions"
        @keydown.arrow-down.prevent="highlightNext"
        @keydown.arrow-up.prevent="highlightPrev"
        :placeholder="t('searchBar.placeholder')"
        class="w-full px-4 py-2 pl-10 pr-10 border border-gray-300 dark:border-gray-600 
               rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
               placeholder-gray-400 dark:placeholder-gray-500
               outline-none ring-0 focus:outline-none focus:ring-0 focus:border-green-500 dark:focus:border-green-500"
      />

      <!-- Search Icon -->
      <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="11" cy="11" r="8"></circle>
          <path d="m21 21-4.35-4.35"></path>
        </svg>
      </span>

      <!-- Clear Button -->
      <button
        v-if="searchQuery"
        @click="clearSearch"
        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
        :aria-label="t('searchBar.clear')"
      >
        ✕
      </button>

      <!-- Suggestions Dropdown (desktop) -->
      <div
        v-if="showDropdown && suggestions.length > 0"
        class="absolute top-full left-0 right-0 mt-1 bg-white dark:bg-gray-900 
               border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl z-50 overflow-hidden"
      >
        <ul>
          <li
            v-for="(suggestion, index) in suggestions"
            :key="suggestion"
            @mousedown.prevent="selectSuggestion(suggestion)"
            @mouseover="highlightedIndex = index"
            :class="[
              'flex items-center gap-3 px-4 py-2.5 cursor-pointer text-sm transition-colors',
              highlightedIndex === index
                ? 'bg-green-50 dark:bg-green-900/30 text-green-800 dark:text-green-200'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800'
            ]"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" class="text-gray-400 shrink-0">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.35-4.35"></path>
            </svg>
            <span v-html="highlightMatch(suggestion, searchQuery)" />
          </li>
        </ul>
      </div>
    </div>

    <!-- MOBILE / TABLET: icon-only trigger -->
    <button
      class="lg:hidden p-1.5 xs:p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors text-gray-600 dark:text-gray-300"
      @click="openMobileSearch"
      :aria-label="t('searchBar.open')"
    >
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <path d="m21 21-4.35-4.35"></path>
      </svg>
    </button>

    <!-- MOBILE / TABLET: full-width overlay -->
    <transition
      enter-active-class="transition-all duration-200 ease-out"
      leave-active-class="transition-all duration-150 ease-in"
      enter-from-class="opacity-0 -translate-y-2"
      enter-to-class="opacity-100 translate-y-0"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-2"
    >
      <div
        v-if="mobileSearchOpen"
        class="lg:hidden fixed inset-x-0 top-[var(--header-height,56px)] z-50 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-lg px-3 py-3"
      >
        <div class="relative w-full">
          <input
            ref="mobileInputRef"
            type="text"
            :value="searchQuery"
            @input="onInput"
            @focus="onFocus"
            @keydown.enter="onEnter"
            @keydown.escape="closeMobileSearch"
            @keydown.arrow-down.prevent="highlightNext"
            @keydown.arrow-up.prevent="highlightPrev"
            :placeholder="t('searchBar.placeholder')"
            class="w-full px-4 py-2.5 pl-10 pr-10 border border-gray-300 dark:border-gray-600 
                   rounded-xl bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 
                   placeholder-gray-400 dark:placeholder-gray-500
                   outline-none ring-0 focus:outline-none focus:ring-0 focus:border-green-500 dark:focus:border-green-500"
          />

          <!-- Search Icon -->
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"></circle>
              <path d="m21 21-4.35-4.35"></path>
            </svg>
          </span>

          <!-- Clear / Close Button -->
          <button
            @click="searchQuery ? clearSearch() : closeMobileSearch()"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
            :aria-label="searchQuery ? t('searchBar.clear') : t('searchBar.close')"
          >
            ✕
          </button>

          <!-- Suggestions Dropdown (mobile) -->
          <div
            v-if="showDropdown && suggestions.length > 0"
            class="absolute top-full left-0 right-0 mt-1 bg-white dark:bg-gray-900 
                   border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl z-50 overflow-hidden max-h-[60vh] overflow-y-auto"
          >
            <ul>
              <li
                v-for="(suggestion, index) in suggestions"
                :key="suggestion"
                @mousedown.prevent="selectSuggestion(suggestion)"
                @mouseover="highlightedIndex = index"
                :class="[
                  'flex items-center gap-3 px-4 py-2.5 cursor-pointer text-sm transition-colors',
                  highlightedIndex === index
                    ? 'bg-green-50 dark:bg-green-900/30 text-green-800 dark:text-green-200'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800'
                ]"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" class="text-gray-400 shrink-0">
                  <circle cx="11" cy="11" r="8"></circle>
                  <path d="m21 21-4.35-4.35"></path>
                </svg>
                <span v-html="highlightMatch(suggestion, searchQuery)" />
              </li>
            </ul>
          </div>
        </div>
      </div>
    </transition>

    <!-- Backdrop behind the mobile overlay -->
    <transition
      enter-active-class="transition-opacity duration-200 ease-out"
      leave-active-class="transition-opacity duration-150 ease-in"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="mobileSearchOpen"
        class="lg:hidden fixed inset-0 top-[var(--header-height,56px)] z-40 bg-black/20"
        @click="closeMobileSearch"
      ></div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, watch, onMounted, nextTick } from 'vue'
import { useRouter } from 'vue-router'
import { useSearchStore } from '~/stores/search'
import { useI18n } from 'vue-i18n'

const { t, locale } = useI18n()
const baseUrl = useRuntimeConfig().public.baseUrl

const router = useRouter()
const searchStore = useSearchStore()

const searchQuery = ref(searchStore.query)
const suggestions = ref<string[]>([])
const showDropdown = ref(false)
const highlightedIndex = ref(-1)
const searchRef = ref<HTMLElement | null>(null)

const mobileSearchOpen = ref(false)
const mobileInputRef = ref(null)

function openMobileSearch() {
  mobileSearchOpen.value = true
  nextTick(() => {
    mobileInputRef.value?.focus()
  })
}

function closeMobileSearch() {
  mobileSearchOpen.value = false
  closeSuggestions?.()
}

// Debounce timer
let debounceTimer: ReturnType<typeof setTimeout>

const onInput = async (e: Event) => {
  const value = (e.target as HTMLInputElement).value
  searchQuery.value = value
  searchStore.setQuery(value)
  highlightedIndex.value = -1

  if (router.currentRoute.value.path !== '/') {
    router.push('/')
  }

  clearTimeout(debounceTimer)

  if (value.trim().length < 2) {
    suggestions.value = []
    showDropdown.value = false
    return
  }

  debounceTimer = setTimeout(async () => {
    await fetchSuggestions(value.trim())
  }, 300) // 300ms debounce
}

const fetchSuggestions = async (query: string) => {
  try {
    // Fetch both products AND categories in parallel
    const [productsRes, categoriesRes] = await Promise.all([
      $fetch<{ products: { productName: string }[] }>(
        `${baseUrl}/products`,
        {
          method: 'GET',
          headers: { 'Content-Type': 'application/json', 'Accept-Language': locale.value },
          params: { page: 1, limit: 100 }
        }
      ),
      $fetch<{ categories: any[] }>(
        `${baseUrl}/categories`,
        {
          method: 'GET',
          headers: { 'Content-Type': 'application/json', 'Accept-Language': locale.value },
          params: { page: 1, limit: 100 }
        }
      )
    ])

    const productNames = (productsRes.products ?? []).map((p) => p.productName)
    const categoryNames = (categoriesRes.categories ?? []).map((c: any) => c.title)

    // Combine and deduplicate
    const allNames = [...new Set([...productNames, ...categoryNames])].filter(Boolean)

    suggestions.value = allNames
      .filter((name) => name?.toLowerCase().includes(query.toLowerCase()))
      .slice(0, 8)

    showDropdown.value = suggestions.value.length > 0
  } catch (err) {
    console.error('Fetch suggestions error:', err)
    suggestions.value = []
    showDropdown.value = false
  }
}

const onFocus = () => {
  if (suggestions.value.length > 0) {
    showDropdown.value = true
  }
}

// const selectSuggestion = (suggestion: string) => {
//   searchQuery.value = suggestion
//   searchStore.setQuery(suggestion)
//   showDropdown.value = false
//   if (router.currentRoute.value.path !== '/') {
//     router.push('/')
//   }
// }

const selectSuggestion = async (suggestion: string) => {
  searchQuery.value = suggestion
  searchStore.setQuery(suggestion)
  showDropdown.value = false
  highlightedIndex.value = -1

  // Always navigate to home where ProductsList lives
  if (router.currentRoute.value.path !== '/') {
    await router.push('/')
  }
}

const onEnter = () => {
  if (highlightedIndex.value >= 0 && suggestions.value[highlightedIndex.value]) {
    selectSuggestion(suggestions.value[highlightedIndex.value])
  } else {
    showDropdown.value = false
  }
}

const highlightNext = () => {
  if (highlightedIndex.value < suggestions.value.length - 1) {
    highlightedIndex.value++
  }
}

const highlightPrev = () => {
  if (highlightedIndex.value > 0) {
    highlightedIndex.value--
  }
}

const closeSuggestions = () => {
  showDropdown.value = false
  highlightedIndex.value = -1
}

const clearSearch = () => {
  searchQuery.value = ''
  searchStore.setQuery('')
  suggestions.value = []
  showDropdown.value = false
}

// Bold the matching part of the suggestion
const highlightMatch = (text: string, query: string) => {
  if (!query) return text
  const regex = new RegExp(`(${query})`, 'gi')
  return text.replace(regex, '<strong class="text-green-700 dark:text-green-400">$1</strong>')
}

// Close dropdown on outside click
onMounted(() => {
  document.addEventListener('click', (e) => {
    if (searchRef.value && !searchRef.value.contains(e.target as Node)) {
      closeSuggestions()
    }
  })
})
</script>
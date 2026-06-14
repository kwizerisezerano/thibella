<template>
  <div class="relative" ref="dropdownRef">
    <button
      @click="toggleDropdown"
      class="flex items-center gap-2 sm:gap-3 focus:outline-none rounded-lg p-1 transition-all hover:bg-gray-100 dark:hover:bg-gray-800"
    >

      <!-- Avatar -->
      <div
        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center
              text-green-700 font-semibold text-base sm:text-lg
              border-2 border-green-700 shadow-sm dark:text-white dark:border-green-600"
      >
        <!-- Show letter if name exists -->
        <span
         v-if="computedAvatarInitial"
         class="text-green-700"
        >
          {{ computedAvatarInitial }}
        </span>

        <!-- Show SVG if no name -->
        <svg 
          v-else
          xmlns="http://www.w3.org/2000/svg" 
          width="18" 
          height="18" 
          viewBox="0 0 24 24" 
          fill="none" 
          stroke="currentColor" 
          stroke-width="2" 
          stroke-linecap="round" 
          stroke-linejoin="round" 
          class="text-gray-700 dark:text-gray-300"
        >
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
          <circle cx="12" cy="7" r="4"></circle>
        </svg>
      </div>

      <!-- Dropdown Arrow -->
      <svg
        class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500 transition-transform dark:text-gray-400"
        :class="{ 'rotate-180': isDropdownOpen }"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </button>

    <!-- Dropdown Menu -->
    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 translate-y-1"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 translate-y-1"
    >
      <div
        v-if="isDropdownOpen"
        class="absolute right-0 mt-2 w-56 sm:w-64 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 z-50 overflow-hidden"
      >
        <!-- User Info Header -->
        <div class="px-4 py-3 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
          <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ name }}</p>
        </div>

        <!-- Login (only show if not logged in) -->
        <div v-if="!role" class="border-t border-gray-200 dark:border-gray-700 py-2">
          <NuxtLink to="/login" @click="closeDropdown">
            <button 
              class="flex items-center gap-3 px-4 py-2.5 text-sm text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-gray-700 transition-colors w-full text-left"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
              </svg>
              {{ $t('profile.login') }}
            </button>
          </NuxtLink>
        </div>

        <!-- Logout (only show if logged in) -->
        <div v-if="role" class="border-t border-gray-200 dark:border-gray-700">
          <!-- Logout Confirmation -->
          <div v-if="showLogoutConfirm" class="px-4 py-3 bg-red-50 dark:bg-gray-700">
            <p class="text-sm text-gray-800 dark:text-white mb-3">{{ $t('profile.logoutConfirm') }}</p>
            <div class="flex justify-end gap-2">
              <button 
                @click.stop="cancelLogout"
                class="px-3 py-1.5 text-sm text-gray-900 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 rounded transition-colors"
              >
                {{ $t('profile.cancel') }}
              </button>
              <button 
                @click.stop="handleLogout"
                :disabled="isLoading"
                class="px-3 py-1.5 text-sm bg-red-500 hover:bg-red-600 text-white rounded transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {{ isLoading ? $t('profile.loggingOut') : $t('profile.confirm') }}
              </button>
            </div>
          </div>
          
          <!-- Logout Button -->
          <button
            v-else
            @click.stop="openLogoutConfirm"
            class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 transition-colors w-full text-left"
          >
            <svg 
              class="w-5 h-5" 
              fill="none" 
              stroke="currentColor" 
              viewBox="0 0 24 24"
            >
              <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" 
              />
            </svg>
            {{ $t('profile.logout') }}
          </button>
        </div>

      </div>
    </transition>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue'
import { storeToRefs } from 'pinia'
import { useUserStore } from '~/stores/user'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const userStore = useUserStore()
const { name, role } = storeToRefs(userStore);

const showLogoutConfirm = ref(false)
const isLoading = ref(false)


onMounted(() => {
 userStore.hydrate()
})

// Open confirmation box
const openLogoutConfirm = () => {
  showLogoutConfirm.value = true
}

// Cancel logout
const cancelLogout = () => {
  showLogoutConfirm.value = false
}

// Confirm logout
const handleLogout = async () => {
  isLoading.value = true
  try {
    userStore.logout()

      // Redirect to login
    navigateTo('/login');
    
  } finally {
    isLoading.value = false
    showLogoutConfirm.value = false
  }
}

const isDropdownOpen = ref(false)


// Computed properties for avatar 
const computedAvatarInitial = computed(() => {
  if (!name.value) return null
  return name.value.charAt(0).toUpperCase()
});

console.log("User name in Profile.vue: ", name.value);

console.log("User role in Profile.vue: ", role.value);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value
}

const closeDropdown = () => {
  isDropdownOpen.value = false
}

// Close dropdown when clicking outside
const dropdownRef = ref<HTMLElement | null>(null)

onMounted(() => {
  const handleClickOutside = (e: MouseEvent) => {
    const target = e.target as HTMLElement
    if (dropdownRef.value && !dropdownRef.value.contains(target)) {
      closeDropdown()
    }
  }
  
  document.addEventListener('click', handleClickOutside)
  
  onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
  })
})
</script>
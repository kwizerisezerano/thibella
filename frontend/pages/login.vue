<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 px-4 py-8">
    <div class="w-full max-w-md">
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-green-700 dark:text-green mb-2">{{ $t('login.welcome') }}</h1>
          <p class="text-gray-600 dark:text-gray-300">{{ $t('login.subtitle') }}</p>
        </div>

        <!-- Login Form -->
        <form @submit.prevent="handleLogin" novalidate>
          <!-- Email/Username Input -->
          <div class="mb-5">
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              {{ $t('login.emailLabel') }}
            </label>
            <input
              id="email"
              ref="emailInput"
              v-model="formData.email"
              type="text"
              autocomplete="email"
              placeholder="example@gmail.com"
              class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 outline-none dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
              :class="errorMessage ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
              @input="clearError('email')"
            />
            <p v-if="successMessage" class="mt-2 text-sm text-green-600">{{ successMessage }}</p>
          </div>

          <!-- Password Input -->
          <div class="mb-5">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              {{ $t('login.passwordLabel') }}
            </label>
            <div class="relative">
              <input
                id="password"
                v-model="formData.password"
                :type="showPassword ? 'text' : 'password'"
                autocomplete="current-password"
                placeholder="Enter your password"
                class="w-full px-4 py-3 pr-12 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 outline-none dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                :class="errorMessage ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                @input="clearError('password')"
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
                aria-label="Toggle password visibility"
              >
                <svg v-if="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                </svg>
              </button>
            </div>
            <p v-if="errorMessage" class="mt-2 text-sm text-red-600">{{ errorMessage }}</p>
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between mb-6">
            <label class="flex items-center cursor-pointer">
              <input
                v-model="formData.rememberMe"
                type="checkbox"
                class="w-4 h-4 text-green-600 border-green-300 dark:border-gray-600 rounded focus:ring-green-500 cursor-pointer dark:bg-gray-700 dark:ring-offset-gray-800"
              />
              <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $t('login.rememberMe') }}</span>
            </label>
            <NuxtLink to="/" class="text-sm text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium">
              {{ $t('login.forgotPassword') }}
            </NuxtLink>
          </div>

          <!-- General Error Message -->
          <!-- <div
            v-if="generalError"
            class="mb-5 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg flex items-start gap-3"
          >
            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-red-800 dark:text-red-200">{{ generalError }}</p>
          </div> -->

          <!-- Login Button -->
          <button
            type="submit"
            :disabled="isLoading"
            class="w-full bg-green-600 dark:bg-green-700 text-white py-3 px-4 rounded-lg font-medium hover:bg-green-700 dark:hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 disabled:bg-gray-300 dark:disabled:bg-green-600 disabled:cursor-not-allowed disabled:hover:bg-green-300 dark:disabled:hover:bg-green-600 flex items-center justify-center gap-2"
          >
            <svg
              v-if="isLoading"
              class="animate-spin h-5 w-5"
              fill="none"
              viewBox="0 0 24 24"
            >
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
            </svg>
            <span>{{ isLoading ? $t('login.signingIn') : $t('login.signIn') }}</span>
          </button>
        </form>

        <!-- Contact Admin via WhatsApp -->
        <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
          {{ $t('login.noAccount') }}
          <a :href="whatsappLink" target="_blank" rel="noopener noreferrer" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium inline-flex items-center gap-1">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
            </svg>
            {{ $t('login.contactAdmin') }}
          </a>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useUserStore } from '~/stores/user'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()
const userStore = useUserStore();

const formData = ref({
  email: '',
  password: '',
  rememberMe: false
})

const showPassword = ref(false)
const rememberMe = ref(false)
const loading = ref(false)
const errorMessage = ref('')
const successMessage = ref('')

const whatsappMessage = 'Hello, I would like to request an account for Thibella.'

const whatsappLink = computed(() => {
  return `https://wa.me/250795149806?text=${encodeURIComponent(whatsappMessage)}`
})

const handleLogin = async () => {
  // Clear previous messages
  errorMessage.value = ''
  successMessage.value = ''

  // Validate inputs
  if (!formData.value.email || !formData.value.password) {
    errorMessage.value = t('login.validationRequired')
    return
  }

  loading.value = true

  try {
    const res = await $fetch(`${useRuntimeConfig().public.baseUrl}/auth/login`, {
      method: 'POST',
      body: {
        email: formData.value.email,
        password: formData.value.password,
      },
    })

    if (!res.success) {
      // Try to translate backend message, fallback to translated default
      const backendMsg = res.message || 'login.failed'
      errorMessage.value = t(backendMsg) === backendMsg ? t('login.failed') : t(backendMsg)
      return
    }

    // ✅ Store everything in one place — including userId and token
    userStore.setUser({
      userId: String(res.data.id),
      name: res.data.name,
      role: res.data.role,
      token: res.data.token,
    })

    // ✅ Remember email if checkbox is checked (moved before navigation)
    if (rememberMe.value) {
      localStorage.setItem('rememberedEmail', formData.value.email)
    } else {
      localStorage.removeItem('rememberedEmail')
    }

    successMessage.value = res.message

    // ✅ Redirect based on role so admins go to dashboard, customers go home
    const userRole = res.data?.role || res.role
    if (userRole === 'admin') {
      await navigateTo('/admin/dashboard')
    } else {
      await navigateTo('/')
    }

  } catch (err) {
    const backendMsg = err?.data?.message || 'login.failed'
    errorMessage.value = t(backendMsg) === backendMsg ? t('login.failed') : t(backendMsg)
  } finally {
    loading.value = false
  }
}


definePageMeta({
  layout:'default'
});
</script>

<style scoped>
/* Additional custom styles if needed */
</style>
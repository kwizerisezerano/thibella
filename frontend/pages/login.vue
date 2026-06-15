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

        <!-- Sign Up Link -->
        <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
          Don't have an account?
          <NuxtLink to="/signUp" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium">
            {{ $t('login.signUp') }}
          </NuxtLink>
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
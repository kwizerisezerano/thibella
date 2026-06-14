<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center p-4">

    <!-- Toast Notifications (top-right, stacked) -->
    <Teleport to="body">
      <div class="fixed top-4 right-4 z-50 flex flex-col gap-2 w-80">
        <TransitionGroup name="toast">
          <div
            v-for="toast in toasts"
            :key="toast.id"
            class="flex items-start gap-3 px-4 py-3 rounded-xl shadow-lg border text-sm font-medium"
            :class="{
              'bg-green-50 border-green-200 text-green-800 dark:bg-green-900/80 dark:border-green-700 dark:text-green-100': toast.type === 'success',
              'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/80 dark:border-red-700 dark:text-red-100': toast.type === 'error',
            }"
          >
            <!-- Icon -->
            <span class="text-base leading-none mt-0.5 shrink-0">
              {{ toast.type === 'success' ? '✅' : '❌' }}
            </span>
            <!-- Message -->
            <span class="flex-1">{{ toast.message }}</span>
            <!-- Dismiss -->
            <button
              @click="removeToast(toast.id)"
              class="shrink-0 opacity-50 hover:opacity-100 transition"
              aria-label="Dismiss"
            >✕</button>
          </div>
        </TransitionGroup>
      </div>
    </Teleport>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-8">
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-green-700 dark:text-green mb-2">{{ $t('signup.title') }}</h1>
        <p class="text-gray-600 dark:text-gray-300">{{ $t('signup.subtitle') }}</p>
      </div>

      <!-- Form -->
      <form @submit.prevent="handleSubmit" class="space-y-5">
        <!-- Full Name -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $t('signup.fullName') }}</label>
          <input
            v-model="formData.fullName"
            type="text"
            required
            class="w-full px-4 py-3 border border-green-300 dark:border-green-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
            placeholder="John Doe"
          />
          <p v-if="errors.fullName" class="text-red-500 dark:text-red-400 text-xs mt-1">{{ errors.fullName }}</p>
        </div>

        <!-- Email -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $t('signup.email') }}</label>
          <input
            v-model="formData.email"
            type="email"
            required
            class="w-full px-4 py-3 border border-green-300 dark:border-green-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
            placeholder="john@example.com"
          />
          <p v-if="errors.email" class="text-red-500 dark:text-red-400 text-xs mt-1">{{ errors.email }}</p>
        </div>

        <!-- Phone Number -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $t('signup.phone') }}</label>
          <input
            v-model="formData.phone"
            type="tel"
            class="w-full px-4 py-3 border border-green-300 dark:border-green-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
            placeholder="+250 XXX XXX XXX"
          />
          <p v-if="errors.phone" class="text-red-500 dark:text-red-400 text-xs mt-1">{{ errors.phone }}</p>
        </div>

        <!-- Password -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $t('signup.password') }}</label>
          <div class="relative">
            <input
              v-model="formData.password"
              :type="showPassword ? 'text' : 'password'"
              required
              class="w-full px-4 py-3 border border-green-300 dark:border-green-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
              placeholder="••••••••"
            />
            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
            >
              {{ showPassword ? '👁️' : '👁️‍🗨️' }}
            </button>
          </div>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $t('signup.passwordHint') }}</p>
          <p v-if="errors.password" class="text-red-500 dark:text-red-400 text-xs mt-1">{{ errors.password }}</p>
        </div>

        <!-- Confirm Password -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ $t('signup.confirmPassword') }}</label>
          <div class="relative">
            <input
              v-model="formData.confirmPassword"
              :type="showConfirmPassword ? 'text' : 'password'"
              required
              class="w-full px-4 py-3 border border-green-300 dark:border-green-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
              placeholder="••••••••"
            />
            <button
              type="button"
              @click="showConfirmPassword = !showConfirmPassword"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
            >
              {{ showConfirmPassword ? '👁️' : '👁️‍🗨️' }}
            </button>
          </div>
          <p v-if="errors.confirmPassword" class="text-red-500 text-xs mt-1">{{ errors.confirmPassword }}</p>
        </div>

        <!-- Terms & Conditions -->
        <div class="flex items-start">
          <input
            v-model="formData.agreeToTerms"
            type="checkbox"
            required
            class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 dark:border-gray-600 rounded focus:ring-indigo-500 dark:bg-gray-700 dark:ring-offset-gray-800"
          />
          <label class="ml-2 text-sm text-gray-600 dark:text-gray-300">
            {{ $t('signup.terms') }} <a href="#" class="text-green-600 dark:text-green-400 hover:underline">{{ $t('signup.termsLink') }}</a> {{ $t('signup.and') }} <a href="#" class="text-green-600 dark:text-green-400 hover:underline">{{ $t('signup.privacyLink') }}</a>
          </label>
        </div>
        <p v-if="errors.agreeToTerms" class="text-red-500 dark:text-red-400 text-xs">{{ errors.agreeToTerms }}</p>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="isLoading"
          class="w-full bg-green-600 dark:bg-green-700 text-white py-3 rounded-lg font-semibold hover:bg-green-700 dark:hover:bg-green-800 transition duration-200 transform hover:scale-[1.02] disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center gap-2"
        >
          <svg v-if="isLoading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
          </svg>
          {{ isLoading ? $t('signup.creating') : $t('signup.create') }}
        </button>

        <!-- Social Login -->
        <div class="relative my-6">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">{{ $t('signup.orWith') }}</span>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
          <button
            type="button"
            @click="handleSocialLogin('google')"
            class="flex items-center justify-center px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition"
          >
            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
              <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
              <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
              <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
              <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            Google
          </button>
          <button
            type="button"
            @click="handleSocialLogin('facebook')"
            class="flex items-center justify-center px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition"
          >
            <svg class="w-5 h-5 mr-2" fill="#1877F2" viewBox="0 0 24 24">
              <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
            </svg>
            Facebook
          </button>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
          Already have an account?
          <NuxtLink to="/login" class="text-green-600 dark:text-green-400 font-semibold hover:underline">{{ $t('signup.loginLink') }}</NuxtLink>
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

// ─── Toast system ────────────────────────────────────────────────────────────
const toasts = ref([])
let toastCounter = 0

function addToast(message, type = 'success', duration = 4000) {
  const id = ++toastCounter
  toasts.value.push({ id, message, type })
  setTimeout(() => removeToast(id), duration)
}

function removeToast(id) {
  toasts.value = toasts.value.filter(t => t.id !== id)
}

// ─── Form state ──────────────────────────────────────────────────────────────
const formData = reactive({
  fullName: '',
  email: '',
  phone: '',
  password: '',
  confirmPassword: '',
  agreeToTerms: false
})

const errors = reactive({
  fullName: '',
  email: '',
  phone: '',
  password: '',
  confirmPassword: '',
  agreeToTerms: ''
})

const showPassword = ref(false)
const showConfirmPassword = ref(false)
const isLoading = ref(false)

// ─── Validation helpers ───────────────────────────────────────────────────────
const validateEmail = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)

const validatePassword = (password) =>
  password.length >= 8 && /[a-zA-Z]/.test(password) && /\d/.test(password)

const validatePhone = (phone) => {
  if (!phone) return true
  return /^\+?[\d\s-]{10,}$/.test(phone)
}

const clearErrors = () => {
  Object.keys(errors).forEach(key => (errors[key] = ''))
}

// ─── Submit ───────────────────────────────────────────────────────────────────
const handleSubmit = async () => {
  clearErrors()
  let isValid = true

  if (formData.fullName.trim().length < 2) {
    errors.fullName = 'Please enter your full name'
    isValid = false
  }
  if (!validateEmail(formData.email)) {
    errors.email = 'Please enter a valid email address'
    isValid = false
  }
  if (formData.phone && !validatePhone(formData.phone)) {
    errors.phone = 'Please enter a valid phone number'
    isValid = false
  }
  if (!validatePassword(formData.password)) {
    errors.password = 'Password must be at least 8 characters with letters and numbers'
    isValid = false
  }
  if (formData.password !== formData.confirmPassword) {
    errors.confirmPassword = 'Passwords do not match'
    isValid = false
  }
  if (!formData.agreeToTerms) {
    errors.agreeToTerms = 'You must agree to the Terms & Conditions'
    isValid = false
  }

  if (!isValid) return

  isLoading.value = true

  try {
    const response = await $fetch('https://api.thibella.com/public/auth/register.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: {
        name: formData.fullName,
        email: formData.email,
        ...(formData.phone && { phone: formData.phone }),
        password: formData.password
      }
    })

    // API returns { success: 200, message: "User registered successfully" }
    if (response.success === 200) {
      addToast('Account created successfully! Redirecting to login…', 'success', 3000)

      // Reset form
      Object.assign(formData, {
        fullName: '', email: '', phone: '',
        password: '', confirmPassword: '', agreeToTerms: false
      })

      // Redirect after the toast is visible
      setTimeout(() => navigateTo('/login'), 2500)
    } else {
      addToast(response.message || 'Registration failed. Please try again.', 'error')
    }
  } catch (error) {
    const statusCode = error?.response?.status
    const serverMessage = error?.data?.message

    if (statusCode === 409 || serverMessage?.toLowerCase().includes('exist')) {
      addToast('An account with this email already exists.', 'error')
    } else if (statusCode === 422) {
      addToast(serverMessage || 'Invalid data submitted. Please check your inputs.', 'error')
    } else if (statusCode >= 500) {
      addToast('Server error. Please try again later.', 'error')
    } else {
      addToast(serverMessage || 'Something went wrong. Please try again.', 'error')
    }
  } finally {
    isLoading.value = false
  }
}

const handleSocialLogin = (provider) => {
  console.log(`Login with ${provider}`)
  // Implement OAuth flow here
}

definePageMeta({
  layout: 'default'
})
</script>

<style scoped>
/* Toast slide-in / slide-out animation */
.toast-enter-active {
  transition: all 0.3s ease;
}
.toast-leave-active {
  transition: all 0.25s ease;
}
.toast-enter-from {
  opacity: 0;
  transform: translateX(100%);
}
.toast-leave-to {
  opacity: 0;
  transform: translateX(100%);
}
</style>
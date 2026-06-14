<template>
  <footer class="bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700">
    <!-- Main Footer Content -->
    <div class="container mx-auto px-4 py-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8 items-start justify-items-start">
        
        <!-- About Us Section -->
        <div>
          <h3 class="text-green-900 dark:text-white text-lg font-semibold mb-4">{{ $t('footer.aboutUs') }}</h3>
          <p class="text-sm leading-relaxed mb-4 text-green-600 dark:text-gray-400">
            {{ $t('footer.aboutDesc') }}
          </p>
            <div class="space-y-2 text-sm">
            <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <a href="mailto:e@thibella.com" class="hover:text-green-600 dark:hover:text-green-400 text-green-600 transition">e@thibella.com</a>
            </div>
            <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                <a href="tel:+250 785 219 00" class="hover:text-green-600 dark:hover:text-green-400 text-green-600 transition">+250 795 149 806 / </a>
                <br>
                <a href="tel:+49 1521 2649935" class="hover:text-green-600 dark:hover:text-green-400 text-green-600 transition"> +49 1521 2649935</a>
            </div>
            <div class="flex items-start text-gray-600 dark:text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
                </svg>
                <span class="text-green-700">Kigali, Rwanda</span>
            </div>
            <div class="flex items-start text-gray-600 dark:text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
          <span class="text-green-700">{{ $t('footer.hours') }}</span>
            </div>
            </div>
        </div>

        <!-- Newsletter & Social Section -->
        <div>
          <h3 class="text-green-900 dark:text-white text-lg font-semibold mb-4">{{ $t('footer.newsletter') }}</h3>
          <p class="text-sm mb-4 text-green-600 dark:text-gray-400">{{ $t('footer.newsletterSub') }}</p>
          <form @submit.prevent="handleSubscribe" class="mb-6">
            <div class="flex">
              <input 
                v-model="email"
                type="email" 
                :placeholder="$t('footer.emailPlaceholder')" 
                required
                class="flex-1 px-4 py-2 bg-white dark:bg-gray-800 border border-green-300 dark:border-gray-600 text-green-900 dark:text-white rounded-l-md focus:outline-none focus:ring-2 focus:ring-green-500"
              />
              <button 
                type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded-r-md hover:bg-green-700 transition"
              >
                {{ $t('footer.subscribe') }}
              </button>
            </div>
          </form>

          <h3 class="text-green-900 dark:text-white text-lg font-semibold mb-4">{{ $t('footer.followUs') }}</h3>
            <div class="flex space-x-4 mb-6">
                <a href="#" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition" aria-label="Facebook">
                    <img src="https://res.cloudinary.com/dck2vzccq/image/upload/v1752079081/facebookIcon_lhb9c5.jpg" alt="Facebook" class="w-6 h-6" />
                </a>

                <a href="#" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition" aria-label="Instagram">
                    <img src="https://res.cloudinary.com/dck2vzccq/image/upload/v1752079084/instagramIcon_kgvpse.jpg" alt="Instagram" class="w-6 h-6" />
                </a>

                <a href="#" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition" aria-label="Twitter">
                    <img src="https://res.cloudinary.com/dck2vzccq/image/upload/v1752774382/xIcon_gzkqse.png" alt="X" class="w-6 h-6" />
                </a>

                <a href="https://wa.me//4915212649935" target="_blank" rel="noopener noreferrer" class="hover:opacity-80 transition" aria-label="WhatsApp">
                    <img src="https://res.cloudinary.com/dck2vzccq/image/upload/v1752774382/whatsApp_m6nmnz.png" alt="WhatsApp" class="w-6 h-6" />
                </a>
            </div>


        </div>

      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-200 dark:border-gray-700">
      <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
          
          <!-- Payment Methods -->
          <div class="flex items-center space-x-4">
            <span class="text-sm text-green-600 dark:text-gray-400">{{ $t('footer.paymentMethods') }}</span>
            <div class="flex space-x-2">
              <span class="px-3 py-1 bg-green-100 dark:bg-gray-800 rounded text-xs">MTN Mobile</span>
              <span class="px-3 py-1 bg-green-100 dark:bg-gray-800 rounded text-xs">Airtel Money</span>
              <span class="px-3 py-1 bg-green-100 dark:bg-gray-800 rounded text-xs">💳 Cards</span>
            </div>
          </div>

        </div>

        <!-- Copyright -->
        <div class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
          {{ currentYear }} Thibella. {{ $t('footer.rights') }}
        </div>
      </div>
    </div>
  </footer>
</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { useCartStore } from '~/stores/cart'

const email = ref('')
const selectedLanguage = ref('rw') // Default to Kinyarwanda
const currentYear = computed(() => new Date().getFullYear())
const cartStore = useCartStore()

// Set initial language and currency
onMounted(() => {
  // Set initial currency based on default language
  changeLanguage()
})

const handleSubscribe = () => {
  // Handle subscription logic
  alert('Thank you for subscribing to our newsletter!')
  email.value = ''
}

const changeLanguage = () => {
  // Update currency based on selected language
  switch(selectedLanguage.value) {
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
  console.log('Language changed to:', selectedLanguage.value)
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
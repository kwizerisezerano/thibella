<template>
  <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">

    <!-- Main Footer -->
    <div class="w-full px-3 sm:px-4 py-12">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

        <!-- Col 1: Brand + Contact -->
        <div class="lg:col-span-1">
          <!-- Logo -->
          <NuxtLink to="/" class="inline-block mb-4">
            <svg viewBox="0 0 300 60" xmlns="http://www.w3.org/2000/svg" class="h-10 w-auto">
              <text x="0" y="46" font-family="Georgia, serif" font-size="48" font-weight="700" letter-spacing="2" fill="#059669" font-style="italic">Thibella</text>
              <path d="M 0 54 Q 60 57, 130 54 T 270 54" stroke="#10B981" stroke-width="2" fill="none" opacity="0.8" stroke-linecap="round"/>
              <circle cx="273" cy="54" r="2.5" fill="#10B981"/>
              <circle cx="280" cy="54" r="1.5" fill="#34D399" opacity="0.7"/>
            </svg>
          </NuxtLink>
          <p class="text-sm leading-relaxed text-gray-500 dark:text-gray-400 mb-5">
            {{ $t('footer.aboutDesc') }}
          </p>
          <ul class="space-y-2 text-sm">
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 text-green-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <a href="mailto:e@thibella.com" class="text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">e@thibella.com</a>
            </li>
            <li class="flex items-start gap-2">
              <svg class="w-4 h-4 text-green-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <div class="text-gray-600 dark:text-gray-400">
                <a href="tel:+250795149806" class="block hover:text-green-600 dark:hover:text-green-400 transition-colors">+250 795 149 806</a>
                <a href="tel:+4915212649935" class="block hover:text-green-600 dark:hover:text-green-400 transition-colors">+49 1521 2649935</a>
              </div>
            </li>
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 text-green-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <span class="text-gray-500 dark:text-gray-400">Kigali, Rwanda</span>
            </li>
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 text-green-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span class="text-gray-500 dark:text-gray-400">{{ $t('footer.hours') }}</span>
            </li>
          </ul>

        </div>

        <!-- Col 2: Quick Links -->
        <div>
          <h4 class="text-gray-900 dark:text-white font-semibold text-sm uppercase tracking-wider mb-5">{{ $t('footer.quickLinks') }}</h4>
          <ul class="space-y-2 text-sm">
            <li><NuxtLink to="/" class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">{{ $t('nav.home') }}</NuxtLink></li>
            <li><NuxtLink to="/products" class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">{{ $t('nav.products') }}</NuxtLink></li>
            <li><NuxtLink to="/categories" class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">{{ $t('nav.categories') }}</NuxtLink></li>
            <li><NuxtLink to="/cart" class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">{{ $t('nav.cart') }}</NuxtLink></li>
          </ul>
        </div>

        <!-- Col 3: Help -->
        <div>
          <h4 class="text-gray-900 dark:text-white font-semibold text-sm uppercase tracking-wider mb-5">{{ $t('footer.help') }}</h4>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">{{ $t('footer.faq') }}</a></li>
            <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">{{ $t('footer.shipping') }}</a></li>
            <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">{{ $t('footer.returns') }}</a></li>
            <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">{{ $t('footer.privacy') }}</a></li>
            <li><a href="#" class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">{{ $t('footer.terms') }}</a></li>
          </ul>
        </div>

        <!-- Col 4: Newsletter + Social -->
        <div>
          <h4 class="text-gray-900 dark:text-white font-semibold text-sm uppercase tracking-wider mb-5">{{ $t('footer.newsletter') }}</h4>
          <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $t('footer.newsletterSub') }}</p>
          <form @submit.prevent="handleSubscribe" class="mb-6">
            <div class="flex">
              <input
                v-model="email"
                type="email"
                :placeholder="$t('footer.emailPlaceholder')"
                required
                class="flex-1 min-w-0 px-3 py-2 text-sm bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-l-md outline-none ring-0 focus:outline-none focus:ring-0 placeholder-gray-400 dark:placeholder-gray-500"
              />
              <button
                type="submit"
                class="px-4 py-2 text-sm bg-green-600 text-white rounded-r-md hover:bg-green-700 transition-colors whitespace-nowrap"
              >
                {{ $t('footer.subscribe') }}
              </button>
            </div>
          </form>

          <h4 class="text-gray-900 dark:text-white font-semibold text-sm uppercase tracking-wider mb-4">{{ $t('footer.followUs') }}</h4>
          <div class="flex items-center gap-3">
            <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
               class="w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
              <svg class="w-5 h-5" fill="#059669" viewBox="0 0 24 24"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953h-1.514c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
            </a>
            <a href="#" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
               class="w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
              <svg class="w-5 h-5" fill="none" stroke="#059669" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="18" cy="6" r="1" fill="#059669"/></svg>
            </a>
            <a href="#" target="_blank" rel="noopener noreferrer" aria-label="X"
               class="w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
              <svg class="w-4 h-4" fill="#059669" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.737-8.835L1.254 2.25H8.08l4.253 5.622 5.911-5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>
            <a href="https://wa.me/4915212649935" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
               class="w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
              <svg class="w-5 h-5" fill="#059669" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
          </div>
        </div>

      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-gray-200 dark:border-gray-700">
      <div class="w-full px-3 sm:px-4 py-5">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">

          <!-- Left: Copyright -->
          <p class="text-sm text-gray-500 dark:text-gray-400 order-2 sm:order-1">
            © {{ currentYear }} Thibella. {{ $t('footer.rights') }}
          </p>

          <!-- Right: Payment Methods -->
          <div class="flex items-center gap-2 order-1 sm:order-2">
            <span class="text-xs text-gray-400 dark:text-gray-500 mr-1">{{ $t('footer.paymentMethods') }}:</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 rounded text-xs font-medium text-gray-600 dark:text-gray-300">MTN Mobile</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 rounded text-xs font-medium text-gray-600 dark:text-gray-300">Airtel Money</span>
            <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 rounded text-xs font-medium text-gray-600 dark:text-gray-300">💳 Cards</span>
          </div>

        </div>
      </div>
    </div>

  </footer>
</template>

<script setup>
import { ref, computed } from 'vue'

const email = ref('')
const currentYear = computed(() => new Date().getFullYear())

const handleSubscribe = () => {
  alert('Thank you for subscribing!')
  email.value = ''
}
</script>
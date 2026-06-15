<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-gray-800 shadow-md min-h-screen flex flex-col flex-shrink-0">
      <div class="px-6 py-5 border-b dark:border-gray-700">
        <span class="text-xl font-bold text-green-600 dark:text-green-400">{{ $t('admin.brand') }}</span>
      </div>
      <nav class="flex-1 px-4 py-6 space-y-1">
        <NuxtLink to="/admin/dashboard" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          {{ $t('admin.nav.dashboard') }}
        </NuxtLink>
        <NuxtLink to="/admin/products" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
          {{ $t('admin.nav.products') }}
        </NuxtLink>
        <NuxtLink to="/admin/categories" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
          {{ $t('admin.nav.categories') }}
        </NuxtLink>
        <NuxtLink to="/admin/subcategories" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
          {{ $t('admin.nav.subcategories') }}
        </NuxtLink>
        <NuxtLink to="/admin/orders" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
          {{ $t('admin.nav.orders') }}
        </NuxtLink>
        <NuxtLink to="/admin/register" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
          {{ $t('admin.nav.register') }}
        </NuxtLink>
      </nav>
      <div class="px-4 py-4 border-t dark:border-gray-700">
        <button @click="handleLogout" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 transition-colors font-medium">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          {{ $t('auth.logout') }}
        </button>
      </div>
    </aside>

    <!-- Main area -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="bg-white dark:bg-gray-800 shadow">
        <div class="px-6 py-4 flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $t('admin.pages.orders.title') }}</h1>
          <div class="flex items-center gap-4">
            <button @click="toggleDarkMode" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300">
              <svg v-if="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
            </button>
            <span class="text-gray-700 dark:text-gray-300 font-medium">{{ userStore.name }}</span>
          </div>
        </div>
      </header>

      <main class="p-6">
        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-6">
          <div class="flex flex-wrap gap-4 items-center">
            <select v-model="statusFilter" @change="fetchOrders" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option value="">{{ $t('admin.pages.orders.allStatuses') }}</option>
              <option value="pending">{{ $t('admin.status.pending') }}</option>
              <option value="processing">{{ $t('admin.status.processing') }}</option>
              <option value="shipped">{{ $t('admin.status.shipped') }}</option>
              <option value="delivered">{{ $t('admin.status.delivered') }}</option>
              <option value="cancelled">{{ $t('admin.status.cancelled') }}</option>
            </select>
            <button @click="fetchOrders" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">{{ $t('admin.common.applyFilters') }}</button>
          </div>
        </div>

        <div v-if="loading" class="bg-white dark:bg-gray-800 rounded-xl shadow p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.common.loadingOrders') }}</div>
        <div v-else-if="orders.length === 0" class="bg-white dark:bg-gray-800 rounded-xl shadow p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.common.noOrders') }}</div>
        <div v-else class="space-y-4">
          <div v-for="order in orders" :key="order.id" class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
            <div class="p-4 bg-gray-50 dark:bg-gray-700 flex flex-wrap justify-between items-center gap-4">
              <div>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.orderLabel', { id: order.id }) }}</span>
                <h3 class="font-bold text-gray-900 dark:text-white">{{ order.full_name }}</h3>
              </div>
              <div class="flex items-center gap-4">
                <span :class="statusClass(order.status)" class="px-3 py-1 rounded-full text-sm font-medium">{{ statusLabel(order.status) }}</span>
                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ formatPrice(order.orderTotalAmount) }}</span>
              </div>
            </div>
            <div class="p-4">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                  <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.phone') }}</p>
                  <p class="text-gray-900 dark:text-white">{{ order.phone_number }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.email') }}</p>
                  <p class="text-gray-900 dark:text-white">{{ order.email }}</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.date') }}</p>
                  <p class="text-gray-900 dark:text-white">{{ formatDate(order.created_at) }}</p>
                </div>
                <div class="md:col-span-3">
                  <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.address') }}</p>
                  <p class="text-gray-900 dark:text-white">{{ order.sector }}, {{ order.district }}, {{ order.province }}, {{ order.country }}<span v-if="order.nearby_landmark"> ({{ $t('admin.pages.orders.near') }}: {{ order.nearby_landmark }})</span></p>
                </div>
                <div>
                  <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.payment') }}</p>
                  <p class="text-gray-900 dark:text-white capitalize">{{ order.payment_method }}</p>
                </div>
              </div>
              <div v-if="order.items && order.items.length > 0" class="border-t dark:border-gray-700 pt-4">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ $t('admin.pages.orders.items', { count: order.items.length }) }}</p>
                <div class="space-y-2">
                  <div v-for="item in order.items" :key="item.id" class="flex items-center gap-3 p-2 bg-gray-50 dark:bg-gray-700 rounded">
                    <img v-if="item.image_url" :src="item.image_url" :alt="item.product_name" class="w-12 h-12 object-cover rounded" />
                    <div class="flex-1">
                      <p class="font-medium text-gray-900 dark:text-white">{{ item.product_name }}</p>
                      <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.qtyEach', { qty: item.quantity, price: formatPrice(item.price_cents) }) }}</p>
                    </div>
                    <p class="font-medium text-gray-900 dark:text-white">{{ formatPrice(item.productTotalAmount) }}</p>
                  </div>
                </div>
              </div>
              <div class="mt-4">
                <select v-model="order.status" @change="updateOrderStatus(order)" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                  <option value="pending">{{ $t('admin.status.pending') }}</option>
                  <option value="processing">{{ $t('admin.status.processing') }}</option>
                  <option value="shipped">{{ $t('admin.status.shipped') }}</option>
                  <option value="delivered">{{ $t('admin.status.delivered') }}</option>
                  <option value="cancelled">{{ $t('admin.status.cancelled') }}</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div v-if="totalPages > 1" class="mt-6 flex justify-center gap-2">
          <button v-for="page in totalPages" :key="page" @click="currentPage = page; fetchOrders()" :class="currentPage === page ? 'bg-green-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-3 py-1 rounded hover:opacity-80">{{ page }}</button>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { useUserStore } from '~/stores/user'
import { useI18n } from 'vue-i18n'

const userStore = useUserStore()
const router = useRouter()
const config = useRuntimeConfig()
const { t, locale } = useI18n()

const { isDark, toggleDarkMode } = useDarkMode()

const orders = ref([])
const loading = ref(false)
const statusFilter = ref('')
const currentPage = ref(1)
const totalPages = ref(1)

const fetchOrders = async () => {
  loading.value = true
  try {
    const params = new URLSearchParams()
    if (statusFilter.value) params.append('status', statusFilter.value)
    params.append('page', currentPage.value)
    params.append('limit', 10)
    const res = await $fetch(`${config.public.baseUrl}/orders?${params}`, {
      headers: { Authorization: `Bearer ${userStore.token}` }
    })
    if (res.success) {
      orders.value = res.orders || []
      totalPages.value = res.pagination ? Math.ceil(res.pagination.total / res.pagination.limit) : 1
    }
  } catch (err) { console.error(err) }
  loading.value = false
}

const updateOrderStatus = async (order) => {
  try {
    await $fetch(`${config.public.baseUrl}/orders?id=${order.id}`, {
      method: 'PUT',
      headers: { Authorization: `Bearer ${userStore.token}` },
      body: { status: order.status }
    })
  } catch (err) {
    alert(err.data?.message || t('admin.errors.updateOrderStatus'))
    fetchOrders()
  }
}

const formatPrice = (cents) => {
  const localeMap = { en: 'en-RW', fr: 'fr-FR', rw: 'rw-RW' }
  return new Intl.NumberFormat(localeMap[locale.value] || 'en-RW', { style: 'currency', currency: 'RWF' }).format((cents || 0) / 100)
}
const formatDate = (d) => {
  if (!d) return t('admin.common.na')
  const localeMap = { en: 'en-US', fr: 'fr-FR', rw: 'rw-RW' }
  return new Date(d).toLocaleDateString(localeMap[locale.value] || 'en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })
}
const statusClass = (s) => ({ pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', processing: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200', shipped: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200', delivered: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200', cancelled: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }[s] || 'bg-gray-100 text-gray-800')
const statusLabel = (s) => t(`admin.status.${s}`, s)

const handleLogout = () => { userStore.logout(); router.push('/login') }

onMounted(() => fetchOrders())

definePageMeta({ layout: false })
</script>

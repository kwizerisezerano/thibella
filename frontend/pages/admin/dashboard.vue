<template>
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-gray-800 shadow-md min-h-screen flex flex-col flex-shrink-0">
      <div class="px-6 py-5 border-b dark:border-gray-700">
        <span class="text-xl font-bold text-green-600 dark:text-green-400">Thibella Admin</span>
      </div>
      <nav class="flex-1 px-4 py-6 space-y-1">
        <NuxtLink to="/admin/dashboard" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          Dashboard
        </NuxtLink>
        <NuxtLink to="/admin/products" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
          Products
        </NuxtLink>
        <NuxtLink to="/admin/categories" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
          Categories
        </NuxtLink>
        <NuxtLink to="/admin/subcategories" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
          Subcategories
        </NuxtLink>
        <NuxtLink to="/admin/orders" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
          Orders
        </NuxtLink>
      </nav>
      <div class="px-4 py-4 border-t dark:border-gray-700">
        <button @click="handleLogout" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700 transition-colors font-medium">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          Logout
        </button>
      </div>
    </aside>

    <!-- Main area -->
    <div class="flex-1 flex flex-col min-w-0">
      <header class="bg-white dark:bg-gray-800 shadow">
        <div class="px-6 py-4 flex justify-between items-center">
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
          <div class="flex items-center gap-4">
            <button @click="toggleDarkMode" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300">
              <svg v-if="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
            </button>
            <span class="text-gray-700 dark:text-gray-300 font-medium">{{ userStore.user?.name }}</span>
          </div>
        </div>
      </header>

      <main class="p-6 space-y-6">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Total Products</p>
              <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.totals.products }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
          </div>
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Categories</p>
              <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.totals.categories }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
          </div>
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Total Orders</p>
              <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.totals.orders }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
          </div>
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-500 dark:text-gray-400">Users</p>
              <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ stats.totals.users }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

          <!-- Orders last 7 days bar chart -->
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Orders — Last 7 Days</h2>
            <div class="flex items-end gap-2 h-40">
              <template v-if="stats.ordersLast7Days.length">
                <div v-for="d in last7DaysFilled" :key="d.day" class="flex-1 flex flex-col items-center gap-1">
                  <span class="text-xs text-gray-500 dark:text-gray-400">{{ d.count }}</span>
                  <div class="w-full bg-green-500 dark:bg-green-600 rounded-t transition-all" :style="{ height: barHeight(d.count, maxDay) + 'px' }"></div>
                  <span class="text-xs text-gray-500 dark:text-gray-400">{{ d.label }}</span>
                </div>
              </template>
              <p v-else class="text-gray-400 text-sm m-auto">No data</p>
            </div>
          </div>

          <!-- Orders by status bar chart -->
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Orders by Status</h2>
            <div class="flex items-end gap-2 h-40">
              <template v-if="Object.keys(stats.ordersByStatus).length">
                <div v-for="(count, status) in stats.ordersByStatus" :key="status" class="flex-1 flex flex-col items-center gap-1">
                  <span class="text-xs text-gray-500 dark:text-gray-400">{{ count }}</span>
                  <div class="w-full rounded-t transition-all" :class="statusBarColor(status)" :style="{ height: barHeight(count, maxStatus) + 'px' }"></div>
                  <span class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ status }}</span>
                </div>
              </template>
              <p v-else class="text-gray-400 text-sm m-auto">No data</p>
            </div>
          </div>

          <!-- Products per category bar chart -->
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 lg:col-span-2">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Products by Category</h2>
            <div class="flex items-end gap-2 h-40">
              <template v-if="stats.productsByCategory.length">
                <div v-for="c in stats.productsByCategory" :key="c.title" class="flex-1 flex flex-col items-center gap-1">
                  <span class="text-xs text-gray-500 dark:text-gray-400">{{ c.count }}</span>
                  <div class="w-full bg-green-400 dark:bg-green-700 rounded-t transition-all" :style="{ height: barHeight(c.count, maxCat) + 'px' }"></div>
                  <span class="text-xs text-gray-500 dark:text-gray-400 truncate w-full text-center">{{ c.title }}</span>
                </div>
              </template>
              <p v-else class="text-gray-400 text-sm m-auto">No data</p>
            </div>
          </div>

        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { useUserStore } from '~/stores/user'

const userStore = useUserStore()
const router = useRouter()
const config = useRuntimeConfig()
const { isDark, toggleDarkMode } = useDarkMode()

const stats = ref({
  totals: { products: 0, categories: 0, orders: 0, users: 0 },
  ordersByStatus: {},
  productsByCategory: [],
  ordersLast7Days: []
})

const fetchStats = async () => {
  try {
    const res = await $fetch(`${config.public.baseUrl}/stats`, {
      headers: { Authorization: `Bearer ${userStore.user?.token}` }
    })
    if (res.success) stats.value = res.data
  } catch (err) { console.error(err) }
}

const barHeight = (val, max) => max > 0 ? Math.max(4, Math.round((val / max) * 120)) : 4
const maxDay = computed(() => Math.max(1, ...stats.value.ordersLast7Days.map(d => d.count)))
const maxStatus = computed(() => Math.max(1, ...Object.values(stats.value.ordersByStatus)))
const maxCat = computed(() => Math.max(1, ...stats.value.productsByCategory.map(c => c.count)))

const statusBarColor = (s) => ({
  pending: 'bg-yellow-400', processing: 'bg-green-400',
  shipped: 'bg-purple-400', delivered: 'bg-green-500', cancelled: 'bg-red-400'
}[s] || 'bg-gray-400')

// Fill missing days in last 7 days
const last7DaysFilled = computed(() => {
  const days = []
  for (let i = 6; i >= 0; i--) {
    const d = new Date()
    d.setDate(d.getDate() - i)
    const key = d.toISOString().slice(0, 10)
    const label = d.toLocaleDateString('en-US', { weekday: 'short' })
    const found = stats.value.ordersLast7Days.find(r => r.day === key)
    days.push({ day: key, label, count: found ? parseInt(found.count) : 0 })
  }
  return days
})

const handleLogout = () => { userStore.logout(); router.push('/login') }

onMounted(fetchStats)

definePageMeta({ layout: false })
</script>

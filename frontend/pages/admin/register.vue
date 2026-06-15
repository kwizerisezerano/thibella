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
        <NuxtLink to="/admin/register" class="flex items-center gap-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-gray-700 hover:text-green-600 dark:hover:text-green-400 transition-colors font-medium" active-class="bg-green-50 dark:bg-gray-700 text-green-600 dark:text-green-400">
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
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $t('admin.nav.register') }}</h1>
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
        <!-- Action Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-6 flex justify-between items-center">
          <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $t('admin.pages.register.totalUsers', { count: totalUsers }) }}</p>
          <button @click="openModal('create')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ $t('admin.pages.register.addUser') }}
          </button>
        </div>

        <!-- Users Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
          <div v-if="loading" class="p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.pages.register.loadingUsers') }}</div>
          <div v-else-if="users.length === 0" class="p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.pages.register.noUsers') }}</div>
          <div v-else class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 uppercase text-xs">
                <tr>
                  <th class="px-4 py-3 text-left">{{ $t('admin.common.id') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.register.name') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.orders.email') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.register.phone') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.register.role') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.orders.date') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.products.tableActions') }}</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                  <td class="px-4 py-3 text-gray-500 dark:text-gray-400">{{ user.id }}</td>
                  <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ user.name }}</td>
                  <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ user.email }}</td>
                  <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ user.phone || '—' }}</td>
                  <td class="px-4 py-3">
                    <span :class="user.role === 'admin' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300'" class="px-2 py-1 rounded-full text-xs font-medium capitalize">{{ user.role }}</span>
                  </td>
                  <td class="px-4 py-3 text-gray-700 dark:text-gray-300 whitespace-nowrap">{{ formatDate(user.created_at) }}</td>
                  <td class="px-4 py-3">
                    <div class="flex gap-2">
                      <button @click="openModal('edit', user)" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-xs">{{ $t('admin.common.edit') }}</button>
                      <button @click="requestDelete(user)" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">{{ $t('admin.common.delete') }}</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="totalPages > 1" class="mt-6 flex justify-center gap-2">
          <button v-for="page in totalPages" :key="page" @click="currentPage = page; fetchUsers()" :class="currentPage === page ? 'bg-green-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-3 py-1 rounded hover:opacity-80">{{ page }}</button>
        </div>
      </main>
    </div>

    <!-- User Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md">
        <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ editMode ? $t('admin.pages.register.modalEditTitle') : $t('admin.pages.register.modalAddTitle') }}</h2>
          <button @click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
        <form @submit.prevent="submitUser" novalidate class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('signup.fullName') }} *</label>
            <input v-model="form.name" @blur="touch('name')" :class="err.name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
            <p v-if="err.name" class="text-red-500 text-xs mt-1">{{ err.name }}</p>
          </div>
          <div v-if="!editMode">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('signup.email') }} *</label>
            <input v-model="form.email" @blur="touch('email')" type="email" :class="err.email ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
            <p v-if="err.email" class="text-red-500 text-xs mt-1">{{ err.email }}</p>
          </div>
          <div v-if="!editMode">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.register.phone') }} *</label>
            <input v-model="form.phone" @blur="touch('phone')" :class="err.phone ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
            <p v-if="err.phone" class="text-red-500 text-xs mt-1">{{ err.phone }}</p>
          </div>
          <div v-if="!editMode">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('signup.password') }} *</label>
            <input v-model="form.password" @blur="touch('password')" type="password" :class="err.password ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
            <p v-if="err.password" class="text-red-500 text-xs mt-1">{{ err.password }}</p>
            <p v-else class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $t('signup.passwordHint') }}</p>
          </div>
          <div v-if="!editMode">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.register.role') }}</label>
            <select v-model="form.role" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <div v-if="errorMessage" class="p-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg text-red-800 dark:text-red-200 text-sm">{{ errorMessage }}</div>

          <div class="flex justify-end gap-4 pt-2">
            <button type="button" @click="closeModal" class="px-4 py-2 border rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ $t('admin.common.cancel') }}</button>
            <button type="submit" :disabled="submitting" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50">{{ submitting ? $t('admin.common.saving') : $t('admin.common.save') }}</button>
          </div>
        </form>
      </div>
    </div>

    <ConfirmModal
      v-model="confirmDeleteOpen"
      tone="danger"
      :title="$t('admin.confirm.deleteUserTitle')"
      :message="confirmDeleteMessage"
      :confirm-text="$t('admin.confirm.yesDelete')"
      :cancel-text="$t('admin.common.cancel')"
      :loading="deleting"
      @confirm="confirmDelete"
      @cancel="userToDelete = null"
    />
  </div>
</template>

<script setup>
import { useUserStore } from '~/stores/user'
import { useI18n } from 'vue-i18n'

const userStore = useUserStore()
const config = useRuntimeConfig()
const { t, locale } = useI18n()
const { isDark, toggleDarkMode } = useDarkMode()

const users = ref([])
const loading = ref(false)
const submitting = ref(false)
const showModal = ref(false)
const editMode = ref(false)
const currentPage = ref(1)
const totalPages = ref(1)
const totalUsers = ref(0)
const errorMessage = ref('')
const err = ref({})

const required = (val) => !String(val ?? '').trim()

const isValidPhone = (phone) => {
  // Matches formats like: +2507XXXXXXXX, 07XXXXXXXX, +250XXXXXXXXX, etc.
  // Allows optional + prefix, then 9-15 digits
  return /^[\+]?[0-9\s\-]{9,15}$/.test(phone.replace(/\s/g, ''))
}

const touch = (field) => {
  const f = form.value
  const e = { ...err.value }
  const req = t('admin.validation.required')
  switch (field) {
    case 'name':     e.name = required(f.name) ? req : ''; break
    case 'email':    e.email = required(f.email) ? req : (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.email) ? t('admin.validation.invalidEmail') : ''); break
    case 'phone':    e.phone = required(f.phone) ? req : (!isValidPhone(f.phone) ? t('admin.validation.invalidPhone') : ''); break
    case 'password': e.password = required(f.password) ? req : (f.password.length < 8 ? t('admin.validation.passwordMin') : ''); break
  }
  err.value = e
}

const validateAll = () => {
  ['name', 'email', 'phone', 'password'].forEach(touch)
  return Object.values(err.value).every(v => !v)
}

const form = ref({ name: '', email: '', phone: '', password: '', role: 'user' })

const confirmDeleteOpen = ref(false)
const deleting = ref(false)
const userToDelete = ref(null)

const confirmDeleteMessage = computed(() => {
  const name = userToDelete.value?.name
  return name ? t('admin.confirm.deleteMessageNamed', { name }) : t('admin.confirm.deleteMessageGeneric')
})

const fetchUsers = async () => {
  loading.value = true
  try {
    const params = new URLSearchParams({ page: currentPage.value, limit: 10 })
    const res = await $fetch(`${config.public.baseUrl}/users?${params}`, {
      headers: { Authorization: `Bearer ${userStore.token}` }
    })
    if (res.success) {
      users.value = res.users || []
      totalUsers.value = res.pagination?.total || users.value.length
      totalPages.value = res.pagination ? Math.ceil(res.pagination.total / res.pagination.limit) : 1
    }
  } catch (err) { console.error(err) }
  loading.value = false
}

const openModal = (mode, user = null) => {
  editMode.value = mode === 'edit'
  errorMessage.value = ''
  err.value = {}
  form.value = editMode.value && user
    ? { id: user.id, name: user.name, email: user.email, phone: user.phone || '', role: user.role }
    : { name: '', email: '', phone: '', password: '', role: 'user' }
  showModal.value = true
}

const closeModal = () => { showModal.value = false }

const submitUser = async () => {
  errorMessage.value = ''
  if (!editMode.value && !validateAll()) return
  submitting.value = true
  try {
    const headers = { Authorization: `Bearer ${userStore.token}` }
    if (editMode.value) {
      await $fetch(`${config.public.baseUrl}/users/profile?id=${form.value.id}`, {
        method: 'PUT', headers, body: { name: form.value.name, phone: form.value.phone }
      })
    } else {
      const res = await $fetch(`${config.public.baseUrl}/auth/register`, {
        method: 'POST', headers, body: { name: form.value.name, email: form.value.email, phone: form.value.phone, password: form.value.password, role: form.value.role }
      })
      if (!res.success) { errorMessage.value = res.message || t('admin.errors.saveUser'); submitting.value = false; return }
    }
    closeModal()
    fetchUsers()
  } catch (err) {
    errorMessage.value = err.data?.message || t('admin.errors.saveUser')
  }
  submitting.value = false
}

const requestDelete = (user) => {
  userToDelete.value = user
  confirmDeleteOpen.value = true
}

const confirmDelete = async () => {
  if (!userToDelete.value?.id) return
  deleting.value = true
  try {
    await $fetch(`${config.public.baseUrl}/users?id=${userToDelete.value.id}`, {
      method: 'DELETE',
      headers: { Authorization: `Bearer ${userStore.token}` }
    })
    confirmDeleteOpen.value = false
    userToDelete.value = null
    fetchUsers()
  } catch (err) { alert(err.data?.message || t('admin.errors.deleteUser')) }
  deleting.value = false
}

const formatDate = (d) => {
  if (!d) return '—'
  const localeMap = { en: 'en-US', fr: 'fr-FR', rw: 'rw-RW' }
  return new Date(d).toLocaleDateString(localeMap[locale.value] || 'en-US', { year: 'numeric', month: 'short', day: 'numeric' })
}

const handleLogout = () => { userStore.logout(); navigateTo('/login') }

onMounted(() => fetchUsers())
definePageMeta({ layout: false })
</script>

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
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manage Categories</h1>
          <div class="flex items-center gap-4">
            <button @click="toggleDarkMode" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-gray-700 dark:text-gray-300">
              <svg v-if="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
              <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5" stroke-width="2"/><path stroke-linecap="round" stroke-width="2" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
            </button>
            <span class="text-gray-700 dark:text-gray-300 font-medium">{{ userStore.user?.name }}</span>
          </div>
        </div>
      </header>

      <main class="p-6">
        <!-- Action Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-6 flex justify-between items-center">
          <input v-model="searchQuery" @input="fetchCategories" type="text" placeholder="Search categories..." class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
          <button @click="openModal('create')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Category
          </button>
        </div>

        <!-- Categories Grid -->
        <div v-if="loading" class="bg-white dark:bg-gray-800 rounded-xl shadow p-8 text-center text-gray-500 dark:text-gray-400">Loading categories...</div>
        <div v-else-if="categories.length === 0" class="bg-white dark:bg-gray-800 rounded-xl shadow p-8 text-center text-gray-500 dark:text-gray-400">No categories found.</div>
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="category in categories" :key="category.id" class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
            <div v-if="category.image" class="h-32 bg-gray-200 dark:bg-gray-700">
              <img :src="category.image" :alt="category.title" class="w-full h-full object-cover" />
            </div>
            <div v-else class="h-32 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
              <span class="text-white text-4xl font-bold">{{ category.title?.charAt(0).toUpperCase() }}</span>
            </div>
            <div class="p-4">
              <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ category.title }}</h3>
              <p v-if="category.description" class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ category.description }}</p>
              <div class="mt-3 flex gap-2">
                <button @click="openModal('edit', category)" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm flex-1">Edit</button>
                <button @click="deleteCategory(category.id)" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm flex-1">Delete</button>
              </div>
            </div>
            <div v-if="category.subcategories && category.subcategories.length > 0" class="px-4 pb-4">
              <div class="border-t dark:border-gray-700 pt-3 mt-1">
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Subcategories ({{ category.subcategories.length }})</p>
                <div class="flex flex-wrap gap-1">
                  <span v-for="sub in category.subcategories.slice(0, 3)" :key="sub.id" class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-xs rounded text-gray-700 dark:text-gray-300">{{ sub.name }}</span>
                  <span v-if="category.subcategories.length > 3" class="px-2 py-1 text-xs text-gray-500 dark:text-gray-400">+{{ category.subcategories.length - 3 }} more</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-if="totalPages > 1" class="mt-6 flex justify-center gap-2">
          <button v-for="page in totalPages" :key="page" @click="currentPage = page; fetchCategories()" :class="currentPage === page ? 'bg-green-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-3 py-1 rounded hover:opacity-80">{{ page }}</button>
        </div>
      </main>
    </div>

    <!-- Category Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg mx-4">
        <div class="p-6 border-b dark:border-gray-700">
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ editMode ? 'Edit Category' : 'Add New Category' }}</h2>
        </div>
        <form @submit.prevent="submitCategory" class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title *</label>
            <input v-model="form.title" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug *</label>
            <input v-model="form.slug" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g., electronics" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <textarea v-model="form.description" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image URL</label>
            <input v-model="form.image" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://..." />
          </div>
          <div class="flex justify-end gap-4 pt-4">
            <button type="button" @click="closeModal" class="px-4 py-2 border rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Cancel</button>
            <button type="submit" :disabled="submitting" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50">{{ submitting ? 'Saving...' : 'Save' }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useUserStore } from '~/stores/user'

const userStore = useUserStore()
const router = useRouter()
const config = useRuntimeConfig()

const { isDark, toggleDarkMode } = useDarkMode()

const categories = ref([])
const loading = ref(false)
const submitting = ref(false)
const showModal = ref(false)
const editMode = ref(false)
const searchQuery = ref('')
const currentPage = ref(1)
const totalPages = ref(1)

const form = ref({ title: '', slug: '', description: '', image: '' })

const fetchCategories = async () => {
  loading.value = true
  try {
    const params = new URLSearchParams()
    params.append('with_subcategories', 1)
    params.append('page', currentPage.value)
    params.append('limit', 9)
    const res = await $fetch(`${config.public.baseUrl}/categories?${params}`)
    if (res.success) {
      categories.value = res.categories || res.data || []
      totalPages.value = res.pagination ? Math.ceil(res.pagination.total / res.pagination.limit) : 1
    }
  } catch (err) { console.error(err) }
  loading.value = false
}

const openModal = (mode, category = null) => {
  editMode.value = mode === 'edit'
  form.value = editMode.value && category
    ? { id: category.id, title: category.title || '', slug: category.slug || '', description: category.description || '', image: category.image || '' }
    : { title: '', slug: '', description: '', image: '' }
  showModal.value = true
}

const closeModal = () => { showModal.value = false }

const submitCategory = async () => {
  submitting.value = true
  try {
    const headers = { Authorization: `Bearer ${userStore.user?.token}` }
    if (editMode.value) {
      await $fetch(`${config.public.baseUrl}/categories?id=${form.value.id}`, { method: 'PUT', headers, body: form.value })
    } else {
      await $fetch(`${config.public.baseUrl}/categories`, { method: 'POST', headers, body: form.value })
    }
    closeModal()
    fetchCategories()
  } catch (err) { alert(err.data?.message || 'Error saving category') }
  submitting.value = false
}

const deleteCategory = async (id) => {
  if (!confirm('Delete this category?')) return
  try {
    await $fetch(`${config.public.baseUrl}/categories?id=${id}`, { method: 'DELETE', headers: { Authorization: `Bearer ${userStore.user?.token}` } })
    fetchCategories()
  } catch (err) { alert(err.data?.message || 'Error deleting category') }
}

const handleLogout = () => { userStore.logout(); router.push('/login') }

onMounted(() => fetchCategories())

definePageMeta({ layout: false })
</script>

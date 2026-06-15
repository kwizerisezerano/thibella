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
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Manage Products</h1>
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-6 flex flex-wrap gap-4 items-center justify-between">
          <div class="flex flex-wrap gap-4 items-center">
            <input v-model="searchQuery" @input="fetchProducts" type="text" placeholder="Search products..." class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            <select v-model="categoryFilter" @change="fetchProducts" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option value="">All Categories</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.title }}</option>
            </select>
            <select v-model="sortBy" @change="fetchProducts" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option value="newest">Newest First</option>
              <option value="oldest">Oldest First</option>
              <option value="price_asc">Price: Low to High</option>
              <option value="price_desc">Price: High to Low</option>
            </select>
          </div>
          <button @click="openModal('create')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Product
          </button>
        </div>

        <!-- Products Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
          <div v-if="loading" class="p-8 text-center text-gray-500 dark:text-gray-400">Loading products...</div>
          <div v-else-if="products.length === 0" class="p-8 text-center text-gray-500 dark:text-gray-400">No products found.</div>
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <img v-if="product.imageUrl" :src="product.imageUrl" :alt="product.productName" class="w-12 h-12 object-cover rounded" />
                      <div>
                        <div class="font-medium text-gray-900 dark:text-white">{{ product.productName }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ product.brand }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ getCategoryName(product.category_id) }}</td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ formatPrice(product.priceCents) }}</td>
                  <td class="px-6 py-4">
                    <span v-if="product.isOnSale" class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs rounded-full">On Sale</span>
                    <span v-else class="px-2 py-1 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs rounded-full">Regular</span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex gap-2">
                      <button @click="openModal('edit', product)" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Edit</button>
                      <button @click="deleteProduct(product.id)" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Delete</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-if="totalPages > 1" class="px-6 py-4 flex justify-center gap-2">
            <button v-for="page in totalPages" :key="page" @click="currentPage = page; fetchProducts()" :class="currentPage === page ? 'bg-green-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-3 py-1 rounded hover:opacity-80">{{ page }}</button>
          </div>
        </div>
      </main>
    </div>

    <!-- Product Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b dark:border-gray-700">
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ editMode ? 'Edit Product' : 'Add New Product' }}</h2>
        </div>
        <form @submit.prevent="submitProduct" class="p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name *</label>
              <input v-model="form.productName" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Brand</label>
              <input v-model="form.brand" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <textarea v-model="form.description" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category *</label>
              <select v-model="form.category_id" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Select Category</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.title }}</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subcategory</label>
              <select v-model="form.subCategory_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Select Subcategory</option>
                <option v-for="sub in subcategories" :key="sub.id" :value="sub.id">{{ sub.name }}</option>
              </select>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price (RWF) *</label>
              <input v-model.number="form.priceCents" type="number" required min="0" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
              <input v-model="form.type" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image URL</label>
            <input v-model="form.imageUrl" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
          </div>
          <div class="flex items-center gap-4">
            <label class="flex items-center">
              <input v-model="form.isOnSale" type="checkbox" class="w-4 h-4 text-green-600 rounded" />
              <span class="ml-2 text-gray-700 dark:text-gray-300">On Sale</span>
            </label>
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

const products = ref([])
const categories = ref([])
const subcategories = ref([])
const loading = ref(false)
const submitting = ref(false)
const showModal = ref(false)
const editMode = ref(false)
const searchQuery = ref('')
const categoryFilter = ref('')
const sortBy = ref('newest')
const currentPage = ref(1)
const totalPages = ref(1)

const form = ref({
  productName: '', brand: '', description: '', category_id: '',
  subCategory_id: '', priceCents: 0, type: '', imageUrl: '', isOnSale: false
})

const fetchProducts = async () => {
  loading.value = true
  try {
    const params = new URLSearchParams()
    if (searchQuery.value) params.append('search', searchQuery.value)
    if (categoryFilter.value) params.append('category_id', categoryFilter.value)
    if (sortBy.value) params.append('sort', sortBy.value)
    params.append('page', currentPage.value)
    params.append('limit', 10)
    const res = await $fetch(`${config.public.baseUrl}/products?${params}`)
    if (res.success) {
      products.value = res.products || []
      totalPages.value = res.pagination ? Math.ceil(res.pagination.total / res.pagination.limit) : 1
    }
  } catch (err) { console.error(err) }
  loading.value = false
}

const fetchCategories = async () => {
  try {
    const res = await $fetch(`${config.public.baseUrl}/categories`)
    if (res.success) categories.value = res.categories || res.data || []
  } catch (err) { console.error(err) }
}

const fetchSubcategoriesByCategory = async (categoryId) => {
  if (!categoryId) { subcategories.value = []; return }
  try {
    const res = await $fetch(`${config.public.baseUrl}/subcategories?category_id=${categoryId}`)
    if (res.success) subcategories.value = res.subcategories || []
  } catch (err) { console.error(err) }
}

watch(() => form.value.category_id, (newCatId) => {
  form.value.subCategory_id = ''
  fetchSubcategoriesByCategory(newCatId)
})

const getCategoryName = (id) => categories.value.find(c => c.id === id)?.title || 'N/A'
const formatPrice = (cents) => new Intl.NumberFormat('en-RW', { style: 'currency', currency: 'RWF' }).format((cents || 0) / 100)

const openModal = (mode, product = null) => {
  editMode.value = mode === 'edit'
  form.value = editMode.value && product ? {
    id: product.id, productName: product.productName || '', brand: product.brand || '',
    description: product.description || '', category_id: product.category_id || '',
    subCategory_id: product.subCategory_id || '', priceCents: product.priceCents || 0,
    type: product.type || '', imageUrl: product.imageUrl || '', isOnSale: product.isOnSale || false
  } : { productName: '', brand: '', description: '', category_id: '', subCategory_id: '', priceCents: 0, type: '', imageUrl: '', isOnSale: false }
  showModal.value = true
}

const closeModal = () => { showModal.value = false }

const submitProduct = async () => {
  submitting.value = true
  try {
    const headers = { Authorization: `Bearer ${userStore.user?.token}` }
    if (editMode.value) {
      await $fetch(`${config.public.baseUrl}/products?id=${form.value.id}`, { method: 'PUT', headers, body: form.value })
    } else {
      await $fetch(`${config.public.baseUrl}/products`, { method: 'POST', headers, body: form.value })
    }
    closeModal()
    fetchProducts()
  } catch (err) {
    alert(err.data?.message || 'Error saving product')
  }
  submitting.value = false
}

const deleteProduct = async (id) => {
  if (!confirm('Delete this product?')) return
  try {
    await $fetch(`${config.public.baseUrl}/products?id=${id}`, { method: 'DELETE', headers: { Authorization: `Bearer ${userStore.user?.token}` } })
    fetchProducts()
  } catch (err) { alert(err.data?.message || 'Error deleting product') }
}

const handleLogout = () => { userStore.logout(); router.push('/login') }

onMounted(() => { fetchProducts(); fetchCategories() })

definePageMeta({ layout: false })
</script>

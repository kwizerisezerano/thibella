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
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $t('admin.pages.subcategories.title') }}</h1>
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-6 flex flex-wrap gap-4 items-center justify-between">
          <select v-model="categoryFilter" @change="fetchSubcategories" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">{{ $t('admin.pages.subcategories.allCategories') }}</option>
            <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.title }}</option>
          </select>
          <button @click="openModal('create')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ $t('admin.pages.subcategories.addSubcategory') }}
          </button>
        </div>

        <div v-if="loading" class="bg-white dark:bg-gray-800 rounded-xl shadow p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.common.loadingSubcategories') }}</div>
        <div v-else-if="subcategories.length === 0" class="bg-white dark:bg-gray-800 rounded-xl shadow p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.common.noSubcategories') }}</div>
        <div v-else class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
          <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.subcategories.tableSubcategory') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.subcategories.tableParent') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.subcategories.tableSlug') }}</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.subcategories.tableActions') }}</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
              <tr v-for="sub in subcategories" :key="sub.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div v-if="sub.image" class="w-10 h-10 rounded overflow-hidden flex-shrink-0">
                      <img :src="sub.image" :alt="sub.name" class="w-full h-full object-cover" />
                    </div>
                    <div class="font-medium text-gray-900 dark:text-white">{{ sub.name }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ getCategoryName(sub.category_id) }}</td>
                <td class="px-6 py-4 text-gray-500 dark:text-gray-400 font-mono text-sm">{{ sub.slug }}</td>
                <td class="px-6 py-4">
                  <div class="flex gap-2">
                    <button @click="openModal('edit', sub)" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">{{ $t('admin.common.edit') }}</button>
                    <button @click="requestDelete(sub)" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">{{ $t('admin.common.delete') }}</button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <div v-if="totalPages > 1" class="px-6 py-4 flex justify-center gap-2">
            <button v-for="page in totalPages" :key="page" @click="currentPage = page; fetchSubcategories()" :class="currentPage === page ? 'bg-green-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-3 py-1 rounded hover:opacity-80">{{ page }}</button>
          </div>
        </div>
      </main>
    </div>

    <!-- Subcategory Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-lg mx-4">
        <div class="p-6 border-b dark:border-gray-700">
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ editMode ? $t('admin.pages.subcategories.modalEditTitle') : $t('admin.pages.subcategories.modalAddTitle') }}</h2>
        </div>
        <form @submit.prevent="submitSubcategory" class="p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.subcategories.nameLabel') }}</label>
            <input v-model="form.name" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.subcategories.slugLabel') }}</label>
            <input v-model="form.slug" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" :placeholder="$t('admin.pages.subcategories.slugPlaceholder')" />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.subcategories.parentCategory') }}</label>
            <select v-model="form.category_id" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option value="">{{ $t('admin.pages.subcategories.selectCategory') }}</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.title }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              {{ $t('admin.pages.subcategories.imageLabel') }} <span class="text-gray-400 text-xs">{{ $t('admin.upload.optional') }}</span>
            </label>

            <div
              class="border-2 border-dashed border-green-400 dark:border-green-600 rounded-lg p-6 text-center cursor-pointer hover:bg-green-50 dark:hover:bg-gray-700 transition-colors relative"
              @click="$refs.fileInput.click()"
              @dragover.prevent
              @drop.prevent="onDrop"
            >
              <svg class="w-10 h-10 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t('admin.upload.dropOne') }}</p>
              <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onFileChange" />
            </div>

            <div v-if="uploading" class="mt-2 space-y-2">
              <div class="flex items-center gap-2 text-green-600 dark:text-green-400 text-sm">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                {{ $t('admin.upload.uploadingImage') }}
              </div>
              <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                <div class="bg-green-600 h-2.5 rounded-full transition-all duration-300" :style="{ width: (uploadProgress.done / uploadProgress.total * 100) + '%' }"></div>
              </div>
            </div>

            <div v-if="uploadedImage" class="mt-3">
              <div class="relative inline-block group">
                <img :src="uploadedImage.url" class="w-full max-w-xs h-28 object-cover rounded-lg border-2 border-green-500" />
                <button type="button" @click="removeImage" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs items-center justify-center hidden group-hover:flex">×</button>
              </div>
            </div>
          </div>
          <div class="flex justify-end gap-4 pt-4">
            <button type="button" @click="closeModal" class="px-4 py-2 border rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ $t('admin.common.cancel') }}</button>
            <button type="submit" :disabled="submitting" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50">{{ submitting ? $t('admin.common.saving') : $t('admin.common.save') }}</button>
          </div>
        </form>
      </div>
    </div>

    <ConfirmModal
      v-model="confirmDeleteOpen"
      tone="danger"
      :title="$t('admin.confirm.deleteSubcategoryTitle')"
      :message="confirmDeleteMessage"
      :confirm-text="$t('admin.confirm.yesDelete')"
      :cancel-text="$t('admin.common.cancel')"
      :loading="deleting"
      @confirm="confirmDelete"
      @cancel="clearDeleteTarget"
    />
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

const subcategories = ref([])
const categories = ref([])
const loading = ref(false)
const submitting = ref(false)
const showModal = ref(false)
const editMode = ref(false)
const categoryFilter = ref('')
const currentPage = ref(1)
const totalPages = ref(1)

const form = ref({ name: '', slug: '', category_id: '', image: '' })

const uploading = ref(false)
const uploadProgress = ref({ done: 0, total: 0 })
const uploadedImage = ref(null)
const fileInput = ref(null)

const uploadToCloudinary = async (file) => {
  const fd = new FormData()
  fd.append('file', file)
  fd.append('upload_preset', config.public.cloudinaryUploadPreset)
  fd.append('cloud_name', config.public.cloudinaryCloudName)

  const res = await fetch(
    `https://api.cloudinary.com/v1_1/${config.public.cloudinaryCloudName}/image/upload`,
    { method: 'POST', body: fd }
  )
  const data = await res.json()
  if (!res.ok) throw new Error(data.error?.message || `Upload failed with status ${res.status}`)
  return { url: data.secure_url, public_id: data.public_id }
}

const uploadFile = async (file) => {
  uploading.value = true
  uploadProgress.value = { done: 0, total: 1 }
  try {
    uploadedImage.value = await uploadToCloudinary(file)
    uploadProgress.value = { done: 1, total: 1 }
  } catch (err) {
    alert(`Failed to upload image: ${err.message}`)
    uploadedImage.value = null
    uploadProgress.value = { done: 0, total: 0 }
  } finally {
    uploading.value = false
  }
}

const onFileChange = (e) => {
  const file = e.target.files?.[0]
  if (file) uploadFile(file)
}

const onDrop = (e) => {
  const file = e.dataTransfer.files?.[0]
  if (file) uploadFile(file)
}

const removeImage = () => {
  uploadedImage.value = null
}

const confirmDeleteOpen = ref(false)
const deleting = ref(false)
const subcategoryToDelete = ref(null)

const confirmDeleteMessage = computed(() => {
  const name = subcategoryToDelete.value?.name
  return name
    ? t('admin.confirm.deleteMessageNamed', { name })
    : t('admin.confirm.deleteMessageGeneric')
})

const fetchSubcategories = async () => {
  loading.value = true
  try {
    const params = new URLSearchParams()
    if (categoryFilter.value) params.append('category_id', categoryFilter.value)
    params.append('with_category', 1)
    params.append('page', currentPage.value)
    params.append('limit', 10)
    const res = await $fetch(`${config.public.baseUrl}/subcategories?${params}`, {
      headers: { 'Accept-Language': locale.value }
    })
    if (res.success) {
      subcategories.value = res.subcategories || []
      totalPages.value = res.pagination ? Math.ceil(res.pagination.total / res.pagination.limit) : 1
    }
  } catch (err) { console.error(err) }
  loading.value = false
}

const fetchCategories = async () => {
  try {
    const res = await $fetch(`${config.public.baseUrl}/categories`, {
      headers: { 'Accept-Language': locale.value }
    })
    if (res.success) categories.value = res.categories || res.data || []
  } catch (err) { console.error(err) }
}

const getCategoryName = (id) => categories.value.find(c => c.id === id)?.title || 'N/A'

const openModal = (mode, subcategory = null) => {
  editMode.value = mode === 'edit'
  form.value = editMode.value && subcategory
    ? { id: subcategory.id, name: subcategory.name || '', slug: subcategory.slug || '', category_id: subcategory.category_id || '', image: subcategory.image || '' }
    : { name: '', slug: '', category_id: '', image: '' }
  uploadedImage.value = form.value.image ? { url: form.value.image, public_id: form.value.image } : null
  showModal.value = true
}

const closeModal = () => { showModal.value = false }

const submitSubcategory = async () => {
  submitting.value = true
  try {
    if (uploadedImage.value?.url) form.value.image = uploadedImage.value.url
    const headers = { Authorization: `Bearer ${userStore.token}` }
    if (editMode.value) {
      await $fetch(`${config.public.baseUrl}/subcategories?id=${form.value.id}`, { method: 'PUT', headers, body: form.value })
    } else {
      await $fetch(`${config.public.baseUrl}/subcategories`, { method: 'POST', headers, body: form.value })
    }
    closeModal()
    fetchSubcategories()
  } catch (err) { alert(err.data?.message || t('admin.errors.saveSubcategory')) }
  submitting.value = false
}

const requestDelete = (subcategory) => {
  subcategoryToDelete.value = subcategory
  confirmDeleteOpen.value = true
}

const clearDeleteTarget = () => {
  subcategoryToDelete.value = null
}

const confirmDelete = async () => {
  if (!subcategoryToDelete.value?.id) return
  deleting.value = true
  try {
    await $fetch(`${config.public.baseUrl}/subcategories?id=${subcategoryToDelete.value.id}`, {
      method: 'DELETE',
      headers: { Authorization: `Bearer ${userStore.token}` },
    })
    confirmDeleteOpen.value = false
    clearDeleteTarget()
    fetchSubcategories()
  } catch (err) {
    alert(err.data?.message || t('admin.errors.deleteSubcategory'))
  } finally {
    deleting.value = false
  }
}

const handleLogout = () => { userStore.logout(); router.push('/login') }

onMounted(() => { fetchSubcategories(); fetchCategories() })

definePageMeta({ layout: false })
</script>

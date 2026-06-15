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
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $t('admin.pages.products.title') }}</h1>
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-6 flex flex-wrap gap-4 items-center justify-between">
          <div class="flex flex-wrap gap-4 items-center">
            <input v-model="searchQuery" @input="fetchProducts" type="text" :placeholder="$t('admin.common.searchProducts')" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            <select v-model="categoryFilter" @change="fetchProducts" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option value="">{{ $t('admin.pages.products.allCategories') }}</option>
              <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.title }}</option>
            </select>
            <select v-model="sortBy" @change="fetchProducts" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option value="newest">{{ $t('admin.pages.products.sortNewest') }}</option>
              <option value="oldest">{{ $t('admin.pages.products.sortOldest') }}</option>
              <option value="price_asc">{{ $t('admin.pages.products.sortPriceAsc') }}</option>
              <option value="price_desc">{{ $t('admin.pages.products.sortPriceDesc') }}</option>
            </select>
          </div>
          <button @click="openModal('create')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      {{ $t('admin.pages.products.addProduct') }}
    </button>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
          <div v-if="loading" class="p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.common.loadingProducts') }}</div>
          <div v-else-if="products.length === 0" class="p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.common.noProducts') }}</div>
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.products.tableProduct') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.products.tableCategory') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.products.tableSize') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.products.tableColor') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.products.tablePrice') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.products.tableStatus') }}</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ $t('admin.pages.products.tableActions') }}</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <tr v-for="product in products" :key="product.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <img v-if="product.imageUrl" :src="product.imageUrl" :alt="product.productName" class="w-12 h-12 object-cover rounded" />
                      <div v-else class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center text-gray-400 text-xs">{{ $t('admin.pages.products.noImage') }}</div>
                      <div>
                        <div class="font-medium text-gray-900 dark:text-white">{{ product.productName }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ product.brand }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ getCategoryName(product.category_id) }}</td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                    {{ (Array.isArray(product.size) ? product.size.join(', ') : product.size) || $t('admin.common.na') }}
                  </td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                    {{ (Array.isArray(product.color) ? product.color.join(', ') : product.color) || $t('admin.common.na') }}
                  </td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ formatPrice(product.price, product.currency) }}</td>
                  <td class="px-6 py-4">
                    <span v-if="product.isOnSale" class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs rounded-full">{{ $t('admin.pages.products.onSale') }}</span>
            <span v-else class="px-2 py-1 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs rounded-full">{{ $t('admin.pages.products.regular') }}</span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex gap-2">
                      <button @click="openViewModal(product)" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">{{ $t('admin.common.view') }}</button>
                      <button @click="openModal('edit', product)" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">{{ $t('admin.common.edit') }}</button>
                      <button @click="requestDelete(product)" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">{{ $t('admin.common.delete') }}</button>
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
        <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ editMode ? $t('admin.pages.products.modalEditTitle') : $t('admin.pages.products.modalAddTitle') }}</h2>
          <button @click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>
        <form @submit.prevent="submitProduct" class="p-6 space-y-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.productName') }}</label>
              <input v-model="form.productName" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.brand') }}</label>
              <input v-model="form.brand" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.description') }}</label>
            <textarea v-model="form.description" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.category') }}</label>
              <select v-model="form.category_id" required class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">{{ $t('admin.pages.products.selectCategory') }}</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.title }}</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.subcategory') }}</label>
              <select v-model="form.subCategory_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" :disabled="!subcategories.length">
                <option value="">{{ form.category_id ? $t('admin.pages.products.selectSubcategory') : $t('admin.pages.products.selectCategoryFirst') }}</option>
                <option v-for="sub in subcategories" :key="sub.id" :value="sub.id">{{ sub.name }}</option>
              </select>
            </div>
          </div>

          <div class="grid grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.price') }}</label>
              <input v-model.number="form.price" type="number" step="0.01" required min="0" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.currency') }}</label>
              <select v-model="form.currency" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="RWF">RWF</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
                <option value="CAD">CAD</option>
                <option value="AUD">AUD</option>
                <option value="JPY">JPY</option>
                <option value="CNY">CNY</option>
                <option value="INR">INR</option>
                <option value="NGN">NGN</option>
                <option value="KES">KES</option>
                <option value="UGX">UGX</option>
                <option value="TZS">TZS</option>
                <option value="ZAR">ZAR</option>
                <option value="GHS">GHS</option>
                <option value="XOF">XOF</option>
                <option value="XAF">XAF</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.stock') }}</label>
              <input v-model.number="form.stock" type="number" min="0" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.size') }}</label>
              <div class="border rounded-lg dark:bg-gray-700 dark:border-gray-600 px-3 py-2">
                <div class="flex flex-wrap gap-2 mb-2">
                  <span v-for="(size, index) in form.size" :key="index" class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded-full">
                    {{ size }}
                    <button type="button" @click="removeTag('size', index)" class="hover:text-red-600">×</button>
                  </span>
                </div>
                <input 
                  v-model="tempSizeInput" 
                  @keydown="handleKeyDown($event, 'size', tempSizeInput)"
                  @blur="addTag('size', tempSizeInput)"
                  placeholder="Enter size, comma separate (e.g., S, M, L)" 
                  class="w-full bg-transparent text-gray-900 dark:text-white outline-none" 
                />
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.products.color') }}</label>
              <div class="border rounded-lg dark:bg-gray-700 dark:border-gray-600 px-3 py-2">
                <div class="flex flex-wrap gap-2 mb-2">
                  <span v-for="(color, index) in form.color" :key="index" class="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded-full">
                    {{ color }}
                    <button type="button" @click="removeTag('color', index)" class="hover:text-red-600">×</button>
                  </span>
                </div>
                <input 
                  v-model="tempColorInput" 
                  @keydown="handleKeyDown($event, 'color', tempColorInput)"
                  @blur="addTag('color', tempColorInput)"
                  placeholder="Enter color, comma separate (e.g., Red, Blue)" 
                  class="w-full bg-transparent text-gray-900 dark:text-white outline-none" 
                />
              </div>
            </div>
          </div>

          <!-- Cloudinary Multi-Image Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              {{ $t('admin.pages.products.imagesTitle') }} <span class="text-gray-400 text-xs">{{ $t('admin.upload.hintFirstMain') }}</span>
            </label>

            <!-- Drop zone -->
            <div
              class="border-2 border-dashed border-green-400 dark:border-green-600 rounded-lg p-6 text-center cursor-pointer hover:bg-green-50 dark:hover:bg-gray-700 transition-colors relative"
              @click="$refs.fileInput.click()"
              @dragover.prevent
              @drop.prevent="onDrop"
            >
              <svg class="w-10 h-10 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t('admin.upload.dropMany') }}</p>
              <input ref="fileInput" type="file" multiple accept="image/*" class="hidden" @change="onFileChange" />
            </div>

            <!-- Upload progress -->
            <div v-if="uploading" class="mt-2 space-y-2">
              <div class="flex items-center gap-2 text-green-600 dark:text-green-400 text-sm">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                {{ $t('admin.upload.uploadingImages', { done: uploadProgress.done, total: uploadProgress.total }) }}
              </div>
              <!-- Progress bar -->
              <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                <div 
                  class="bg-green-600 h-2.5 rounded-full transition-all duration-300" 
                  :style="{ width: (uploadProgress.done / uploadProgress.total * 100) + '%' }"
                ></div>
              </div>
            </div>

            <!-- Uploaded images preview -->
            <div v-if="uploadedImages.length" class="mt-3 grid grid-cols-4 gap-2">
              <div v-for="(img, i) in uploadedImages" :key="img.public_id" class="relative group">
                <img :src="img.url" class="w-full h-20 object-cover rounded-lg border-2" :class="i === 0 ? 'border-green-500' : 'border-gray-200 dark:border-gray-600'" />
                <span v-if="i === 0" class="absolute top-1 left-1 bg-green-500 text-white text-xs px-1 rounded">{{ $t('admin.pages.products.main') }}</span>
                <button type="button" @click="removeImage(i)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs items-center justify-center hidden group-hover:flex">×</button>
              </div>
            </div>

          </div>

          <div class="flex items-center gap-4">
            <label class="flex items-center">
              <input v-model="form.isOnSale" type="checkbox" class="w-4 h-4 text-green-600 rounded" />
              <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $t('admin.pages.products.onSaleToggle') }}</span>
            </label>
          </div>

          <div class="flex justify-end gap-4 pt-4">
            <button type="button" @click="closeModal" class="px-4 py-2 border rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ $t('admin.common.cancel') }}</button>
            <button type="submit" :disabled="submitting || uploading" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50">
              {{ submitting ? $t('admin.common.saving') : $t('admin.pages.products.saveProduct') }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Product Details View Modal -->
    <div v-if="showViewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $t('admin.pages.products.detailsTitle') }}</h2>
          <button @click="closeViewModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <div v-if="selectedProduct" class="p-6 space-y-6">
          <!-- Product Images -->
          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ $t('admin.pages.products.imagesTitle') }}</h3>
            <div class="grid grid-cols-4 gap-3">
              <div v-for="(img, i) in (selectedProduct.possibleImagesUrls ? (Array.isArray(selectedProduct.possibleImagesUrls) ? selectedProduct.possibleImagesUrls : JSON.parse(selectedProduct.possibleImagesUrls)) : [selectedProduct.imageUrl])" :key="i" class="relative">
                <img :src="img" class="w-full h-24 object-cover rounded-lg border-2" :class="i === 0 ? 'border-green-500' : 'border-gray-200 dark:border-gray-600'" />
                <span v-if="i === 0" class="absolute top-1 left-1 bg-green-500 text-white text-xs px-1 rounded">{{ $t('admin.pages.products.main') }}</span>
              </div>
            </div>
          </div>

          <!-- Basic Info -->
          <div class="grid grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.productName') }}</h4>
              <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ selectedProduct.productName }}</p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.brand') }}</h4>
              <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ selectedProduct.brand || $t('admin.common.na') }}</p>
            </div>
          </div>

          <div>
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.description') }}</h4>
            <p class="text-gray-700 dark:text-gray-300">{{ selectedProduct.description || $t('admin.pages.products.noDescription') }}</p>
          </div>

          <div class="grid grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.tableCategory') }}</h4>
              <p class="text-gray-900 dark:text-white">{{ getCategoryName(selectedProduct.category_id) }}</p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.subcategory') }}</h4>
              <p class="text-gray-900 dark:text-white">{{ subcategories.find(s => s.id === selectedProduct.subCategory_id)?.name || $t('admin.common.na') }}</p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.tablePrice') }}</h4>
              <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ formatPrice(selectedProduct.price, selectedProduct.currency) }}</p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.stock') }}</h4>
              <p class="text-xl font-bold text-gray-900 dark:text-white">{{ selectedProduct.stock || 0 }}</p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.tableSize') }}</h4>
              <p class="text-xl font-bold text-gray-900 dark:text-white">
                {{ (Array.isArray(selectedProduct.size) ? selectedProduct.size.join(', ') : selectedProduct.size) || $t('admin.common.na') }}
              </p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.tableColor') }}</h4>
              <p class="text-xl font-bold text-gray-900 dark:text-white">
                {{ (Array.isArray(selectedProduct.color) ? selectedProduct.color.join(', ') : selectedProduct.color) || $t('admin.common.na') }}
              </p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.pages.products.tableStatus') }}</h4>
              <span v-if="selectedProduct.isOnSale" class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-sm rounded-full">{{ $t('admin.pages.products.onSale') }}</span>
              <span v-else class="px-3 py-1 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-sm rounded-full">{{ $t('admin.pages.products.regular') }}</span>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $t('admin.common.id') }}</h4>
              <p class="text-gray-900 dark:text-white">{{ selectedProduct.id }}</p>
            </div>
          </div>
        </div>

        <div class="p-6 border-t dark:border-gray-700 flex justify-end">
          <button @click="closeViewModal" class="px-4 py-2 border rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
            {{ $t('admin.common.close') }}
          </button>
        </div>
      </div>
    </div>

    <ConfirmModal
      v-model="confirmDeleteOpen"
      tone="danger"
      :title="$t('admin.confirm.deleteProductTitle')"
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

const products = ref([])
const categories = ref([])
const subcategories = ref([])
const loading = ref(false)
const submitting = ref(false)
const showModal = ref(false)
const editMode = ref(false)
const showViewModal = ref(false)
const selectedProduct = ref(null)
const searchQuery = ref('')
const categoryFilter = ref('')
const sortBy = ref('newest')
const currentPage = ref(1)
const totalPages = ref(1)

// Cloudinary upload state
const uploading = ref(false)
const uploadProgress = ref({ done: 0, total: 0 })
const uploadedImages = ref([]) // [{ url, public_id }]
const fileInput = ref(null)

const confirmDeleteOpen = ref(false)
const deleting = ref(false)
const productToDelete = ref(null)

const confirmDeleteMessage = computed(() => {
  const name = productToDelete.value?.productName
  return name
    ? t('admin.confirm.deleteMessageNamed', { name })
    : t('admin.confirm.deleteMessageGeneric')
})

const form = ref({
  productName: '', brand: '', description: '', category_id: '',
  subCategory_id: '', price: 0, isOnSale: false, 
  stock: 0, size: [], color: [], currency: 'RWF'
})

const tempSizeInput = ref('')
const tempColorInput = ref('')

const addTag = (type, value) => {
  if (!value.trim()) return
  const trimmed = value.trim()
  // Split by comma and add all non-empty values
  const values = trimmed.split(',').map(s => s.trim()).filter(s => s)
  values.forEach(v => {
    if (!form.value[type].includes(v)) {
      form.value[type].push(v)
    }
  })
  if (type === 'size') tempSizeInput.value = ''
  if (type === 'color') tempColorInput.value = ''
}

const removeTag = (type, index) => {
  form.value[type].splice(index, 1)
}

const handleKeyDown = (e, type, tempValue) => {
  if (e.key === 'Enter' || e.key === ',') {
    e.preventDefault()
    addTag(type, tempValue)
  }
}

// Upload a single file to Cloudinary
const uploadToCloudinary = async (file) => {
  console.log('Starting upload for file:', file.name)
  console.log('Cloudinary config:', {
    cloudName: config.public.cloudinaryCloudName,
    uploadPreset: config.public.cloudinaryUploadPreset
  })
  
  const fd = new FormData()
  fd.append('file', file)
  fd.append('upload_preset', config.public.cloudinaryUploadPreset)
  fd.append('cloud_name', config.public.cloudinaryCloudName)
  
  try {
    const res = await fetch(
      `https://api.cloudinary.com/v1_1/${config.public.cloudinaryCloudName}/image/upload`,
      { method: 'POST', body: fd }
    )
    console.log('Cloudinary response status:', res.status)
    const data = await res.json()
    console.log('Cloudinary response data:', data)
    
    if (!res.ok) {
      throw new Error(data.error?.message || `Upload failed with status ${res.status}`)
    }
    
    console.log('Upload successful! URL:', data.secure_url)
    return { url: data.secure_url, public_id: data.public_id }
  } catch (err) {
    console.error('Cloudinary upload error:', err)
    throw err
  }
}

const uploadFiles = async (files) => {
  uploading.value = true
  uploadProgress.value = { done: 0, total: files.length }
  
  try {
    // Upload all files in parallel with proper progress tracking
    const uploadPromises = files.map(async (file) => {
      const result = await uploadToCloudinary(file)
      uploadProgress.value.done++
      return result
    })
    
    uploadedImages.value = await Promise.all(uploadPromises)
    console.log('All uploads completed! Uploaded images:', uploadedImages.value)
  } catch (err) {
    console.error('Upload failed:', err)
    alert(`Failed to upload images: ${err.message}`)
    uploadedImages.value = []
    uploadProgress.value = { done: 0, total: 0 }
  } finally {
    uploading.value = false
  }
}

const onFileChange = (e) => uploadFiles(Array.from(e.target.files))
const onDrop = (e) => uploadFiles(Array.from(e.dataTransfer.files))
const removeImage = (i) => uploadedImages.value.splice(i, 1)

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
    const res = await $fetch(`${config.public.baseUrl}/categories`, {
      headers: { 'Accept-Language': locale.value }
    })
    if (res.success) categories.value = res.categories || []
  } catch (err) { console.error(err) }
}

const fetchSubcategoriesByCategory = async (categoryId) => {
  if (!categoryId) { subcategories.value = []; return }
  try {
    const res = await $fetch(`${config.public.baseUrl}/subcategories?category_id=${categoryId}`, {
      headers: { 'Accept-Language': locale.value }
    })
    if (res.success) subcategories.value = res.subcategories || []
  } catch (err) { console.error(err) }
}

watch(() => form.value.category_id, (newCatId) => {
  form.value.subCategory_id = ''
  fetchSubcategoriesByCategory(newCatId)
})

const getCategoryName = (id) => categories.value.find(c => c.id === id)?.title || t('admin.common.na')
const formatPrice = (price, currency = 'RWF') => {
  const localeMap = { en: 'en-RW', fr: 'fr-FR', rw: 'rw-RW' }
  return new Intl.NumberFormat(localeMap[locale.value] || 'en-RW', { style: 'currency', currency }).format(price || 0)
}

const parseTags = (value) => {
  if (!value) return []
  if (Array.isArray(value)) return value
  // Try JSON parse first (if it's a JSON array string)
  try {
    const parsed = JSON.parse(value)
    if (Array.isArray(parsed)) return parsed
  } catch (e) { /* ignore */ }
  // Otherwise, split by comma
  return value.split(',').map(s => s.trim()).filter(s => s)
}

const openModal = (mode, product = null) => {
  editMode.value = mode === 'edit'
  uploadedImages.value = []
  tempSizeInput.value = ''
  tempColorInput.value = ''
  if (editMode.value && product) {
    form.value = {
      id: product.id,
      productName: product.productName || '',
      brand: product.brand || '',
      description: product.description || '',
      category_id: product.category_id || '',
      subCategory_id: product.subCategory_id || '',
      price: product.price || 0,
      isOnSale: product.isOnSale || false,
      stock: product.stock || 0,
      size: parseTags(product.size),
      color: parseTags(product.color),
      currency: product.currency || 'RWF'
    }
    // Populate existing images for preview
    const existing = Array.isArray(product.possibleImagesUrls)
      ? product.possibleImagesUrls
      : (product.possibleImagesUrls ? JSON.parse(product.possibleImagesUrls) : [])
    if (existing.length) {
      uploadedImages.value = existing.map(url => ({ url, public_id: url }))
    } else if (product.imageUrl) {
      uploadedImages.value = [{ url: product.imageUrl, public_id: product.imageUrl }]
    }
  } else {
    form.value = { productName: '', brand: '', description: '', category_id: '', subCategory_id: '', price: 0, isOnSale: false, stock: 0, size: [], color: [], currency: 'RWF' }
  }
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  uploadedImages.value = []
}

const openViewModal = (product) => {
  selectedProduct.value = product
  showViewModal.value = true
}

const closeViewModal = () => {
  showViewModal.value = false
  selectedProduct.value = null
}

const submitProduct = async () => {
  if (!uploadedImages.value.length) {
    alert(t('admin.upload.uploadRequiredProduct'))
    return
  }
  submitting.value = true
  try {
    const urls = uploadedImages.value.map(i => i.url)
    const body = {
      ...form.value,
      imageUrl: urls[0],
      possibleImagesUrls: urls
    }
    
    const headers = { Authorization: `Bearer ${userStore.token}` }
    
    if (editMode.value) {
      await $fetch(`${config.public.baseUrl}/products?id=${form.value.id}`, { method: 'PUT', headers, body })
    } else {
      await $fetch(`${config.public.baseUrl}/products`, { method: 'POST', headers, body })
    }
    closeModal()
    fetchProducts()
  } catch (err) {
    console.error('❌ Product submission error:', err)
    alert(err.data?.message || t('admin.errors.saveProduct'))
  }
  submitting.value = false
}

const requestDelete = (product) => {
  productToDelete.value = product
  confirmDeleteOpen.value = true
}

const clearDeleteTarget = () => {
  productToDelete.value = null
}

const confirmDelete = async () => {
  if (!productToDelete.value?.id) return
  deleting.value = true
  try {
    await $fetch(`${config.public.baseUrl}/products?id=${productToDelete.value.id}`, {
      method: 'DELETE',
      headers: { Authorization: `Bearer ${userStore.token}` },
    })
    confirmDeleteOpen.value = false
    clearDeleteTarget()
    fetchProducts()
  } catch (err) {
    alert(err.data?.message || t('admin.errors.deleteProduct'))
  } finally {
    deleting.value = false
  }
}

const handleLogout = () => { userStore.logout(); router.push('/login') }

onMounted(() => { fetchProducts(); fetchCategories() })

definePageMeta({ layout: false })
</script>

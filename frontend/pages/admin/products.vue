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

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
          <div v-if="loading" class="p-8 text-center text-gray-500 dark:text-gray-400">Loading products...</div>
          <div v-else-if="products.length === 0" class="p-8 text-center text-gray-500 dark:text-gray-400">No products found.</div>
          <div v-else class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Size</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Color</th>
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
                      <div v-else class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center text-gray-400 text-xs">No img</div>
                      <div>
                        <div class="font-medium text-gray-900 dark:text-white">{{ product.productName }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ product.brand }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ getCategoryName(product.category_id) }}</td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ product.size || 'N/A' }}</td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ product.color || 'N/A' }}</td>
                  <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ formatPrice(product.price, product.currency) }}</td>
                  <td class="px-6 py-4">
                    <span v-if="product.isOnSale" class="px-2 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs rounded-full">On Sale</span>
            <span v-else class="px-2 py-1 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-xs rounded-full">Regular</span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex gap-2">
                      <button @click="openViewModal(product)" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm">View</button>
                      <button @click="openModal('edit', product)" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-sm">Edit</button>
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
        <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ editMode ? 'Edit Product' : 'Add New Product' }}</h2>
          <button @click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
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
              <select v-model="form.subCategory_id" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" :disabled="!subcategories.length">
                <option value="">{{ form.category_id ? 'Select Subcategory' : 'Select category first' }}</option>
                <option v-for="sub in subcategories" :key="sub.id" :value="sub.id">{{ sub.name }}</option>
              </select>
            </div>
          </div>

          <div class="grid grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price *</label>
              <input v-model.number="form.price" type="number" step="0.01" required min="0" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Currency</label>
              <select v-model="form.currency" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="RWF">RWF - Rwandan Franc</option>
                <option value="USD">USD - US Dollar</option>
                <option value="EUR">EUR - Euro</option>
                <option value="GBP">GBP - British Pound</option>
                <option value="CAD">CAD - Canadian Dollar</option>
                <option value="AUD">AUD - Australian Dollar</option>
                <option value="JPY">JPY - Japanese Yen</option>
                <option value="CNY">CNY - Chinese Yuan</option>
                <option value="INR">INR - Indian Rupee</option>
                <option value="NGN">NGN - Nigerian Naira</option>
                <option value="KES">KES - Kenyan Shilling</option>
                <option value="UGX">UGX - Ugandan Shilling</option>
                <option value="TZS">TZS - Tanzanian Shilling</option>
                <option value="ZAR">ZAR - South African Rand</option>
                <option value="GHS">GHS - Ghanaian Cedi</option>
                <option value="XOF">XOF - West African CFA Franc</option>
                <option value="XAF">XAF - Central African CFA Franc</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock</label>
              <input v-model.number="form.stock" type="number" min="0" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Size</label>
              <input v-model="form.size" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color</label>
              <input v-model="form.color" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
          </div>

          <!-- Cloudinary Multi-Image Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              Product Images <span class="text-gray-400 text-xs">(first image = main, multiple allowed)</span>
            </label>

            <!-- Drop zone -->
            <div
              class="border-2 border-dashed border-green-400 dark:border-green-600 rounded-lg p-6 text-center cursor-pointer hover:bg-green-50 dark:hover:bg-gray-700 transition-colors relative"
              @click="$refs.fileInput.click()"
              @dragover.prevent
              @drop.prevent="onDrop"
            >
              <svg class="w-10 h-10 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              <p class="text-sm text-gray-500 dark:text-gray-400">Click or drag & drop images here</p>
              <input ref="fileInput" type="file" multiple accept="image/*" class="hidden" @change="onFileChange" />
            </div>

            <!-- Upload progress -->
            <div v-if="uploading" class="mt-2 space-y-2">
              <div class="flex items-center gap-2 text-green-600 dark:text-green-400 text-sm">
                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                Uploading {{ uploadProgress.done }} / {{ uploadProgress.total }} images...
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
                <span v-if="i === 0" class="absolute top-1 left-1 bg-green-500 text-white text-xs px-1 rounded">Main</span>
                <button type="button" @click="removeImage(i)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs items-center justify-center hidden group-hover:flex">×</button>
              </div>
            </div>

          </div>

          <div class="flex items-center gap-4">
            <label class="flex items-center">
              <input v-model="form.isOnSale" type="checkbox" class="w-4 h-4 text-green-600 rounded" />
              <span class="ml-2 text-gray-700 dark:text-gray-300">On Sale</span>
            </label>
          </div>

          <div class="flex justify-end gap-4 pt-4">
            <button type="button" @click="closeModal" class="px-4 py-2 border rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Cancel</button>
            <button type="submit" :disabled="submitting || uploading" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50">
              {{ submitting ? 'Saving...' : 'Save Product' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Product Details View Modal -->
    <div v-if="showViewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">Product Details</h2>
          <button @click="closeViewModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <div v-if="selectedProduct" class="p-6 space-y-6">
          <!-- Product Images -->
          <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Product Images</h3>
            <div class="grid grid-cols-4 gap-3">
              <div v-for="(img, i) in (selectedProduct.possibleImagesUrls ? (Array.isArray(selectedProduct.possibleImagesUrls) ? selectedProduct.possibleImagesUrls : JSON.parse(selectedProduct.possibleImagesUrls)) : [selectedProduct.imageUrl])" :key="i" class="relative">
                <img :src="img" class="w-full h-24 object-cover rounded-lg border-2" :class="i === 0 ? 'border-green-500' : 'border-gray-200 dark:border-gray-600'" />
                <span v-if="i === 0" class="absolute top-1 left-1 bg-green-500 text-white text-xs px-1 rounded">Main</span>
              </div>
            </div>
          </div>

          <!-- Basic Info -->
          <div class="grid grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Product Name</h4>
              <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ selectedProduct.productName }}</p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Brand</h4>
              <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ selectedProduct.brand || 'N/A' }}</p>
            </div>
          </div>

          <div>
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h4>
            <p class="text-gray-700 dark:text-gray-300">{{ selectedProduct.description || 'No description' }}</p>
          </div>

          <div class="grid grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</h4>
              <p class="text-gray-900 dark:text-white">{{ getCategoryName(selectedProduct.category_id) }}</p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Subcategory</h4>
              <p class="text-gray-900 dark:text-white">{{ subcategories.find(s => s.id === selectedProduct.subCategory_id)?.name || 'N/A' }}</p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</h4>
              <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ formatPrice(selectedProduct.price, selectedProduct.currency) }}</p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stock</h4>
              <p class="text-xl font-bold text-gray-900 dark:text-white">{{ selectedProduct.stock || 0 }}</p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Size</h4>
              <p class="text-xl font-bold text-gray-900 dark:text-white">{{ selectedProduct.size || 'N/A' }}</p>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Color</h4>
              <p class="text-xl font-bold text-gray-900 dark:text-white">{{ selectedProduct.color || 'N/A' }}</p>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6">
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</h4>
              <span v-if="selectedProduct.isOnSale" class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-sm rounded-full">On Sale</span>
              <span v-else class="px-3 py-1 bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 text-sm rounded-full">Regular</span>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Product ID</h4>
              <p class="text-gray-900 dark:text-white">{{ selectedProduct.id }}</p>
            </div>
          </div>
        </div>

        <div class="p-6 border-t dark:border-gray-700 flex justify-end">
          <button @click="closeViewModal" class="px-4 py-2 border rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
            Close
          </button>
        </div>
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

const form = ref({
  productName: '', brand: '', description: '', category_id: '',
  subCategory_id: '', price: 0, isOnSale: false, 
  stock: 0, size: '', color: '', currency: 'RWF'
})

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
    const res = await $fetch(`${config.public.baseUrl}/categories`)
    if (res.success) categories.value = res.categories || []
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
const formatPrice = (price, currency = 'RWF') => new Intl.NumberFormat('en-RW', { style: 'currency', currency: currency }).format(price || 0)

const openModal = (mode, product = null) => {
  editMode.value = mode === 'edit'
  uploadedImages.value = []
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
      size: product.size || '',
      color: product.color || '',
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
    form.value = { productName: '', brand: '', description: '', category_id: '', subCategory_id: '', price: 0, isOnSale: false, stock: 0, size: '', color: '', currency: 'RWF' }
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
    alert('Please upload at least one product image.')
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

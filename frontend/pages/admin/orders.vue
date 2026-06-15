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

    <!-- Main -->
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 mb-6 flex flex-wrap justify-between items-center gap-4">
          <select v-model="statusFilter" @change="currentPage = 1; fetchOrders()" class="px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <option value="">{{ $t('admin.pages.orders.allStatuses') }}</option>
            <option value="pending">{{ $t('admin.status.pending') }}</option>
            <option value="processing">{{ $t('admin.status.processing') }}</option>
            <option value="shipped">{{ $t('admin.status.shipped') }}</option>
            <option value="delivered">{{ $t('admin.status.delivered') }}</option>
            <option value="cancelled">{{ $t('admin.status.cancelled') }}</option>
          </select>
          <button @click="openModal('create')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            {{ $t('admin.pages.orders.addOrder') }}
          </button>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">
          <div v-if="loading" class="p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.common.loadingOrders') }}</div>
          <div v-else-if="orders.length === 0" class="p-8 text-center text-gray-500 dark:text-gray-400">{{ $t('admin.common.noOrders') }}</div>
          <div v-else class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 uppercase text-xs">
                <tr>
                  <th class="px-4 py-3 text-left">{{ $t('admin.common.id') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.orders.customer') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.orders.phone') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.orders.date') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.orders.payment') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.orders.total') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.orders.status') }}</th>
                  <th class="px-4 py-3 text-left">{{ $t('admin.pages.products.tableActions') }}</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                  <td class="px-4 py-3 text-gray-500 dark:text-gray-400">#{{ order.id }}</td>
                  <td class="px-4 py-3">
                    <p class="font-medium text-gray-900 dark:text-white">{{ order.full_name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ order.email }}</p>
                  </td>
                  <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ order.phone_number }}</td>
                  <td class="px-4 py-3 text-gray-700 dark:text-gray-300 whitespace-nowrap">{{ formatDate(order.created_at) }}</td>
                  <td class="px-4 py-3 text-gray-700 dark:text-gray-300 capitalize">{{ order.payment_method }}</td>
                  <td class="px-4 py-3 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ formatPrice(order.orderTotalAmount) }}</td>
                  <td class="px-4 py-3">
                    <span :class="statusClass(order.status)" class="px-2 py-1 rounded-full text-xs font-medium">{{ statusLabel(order.status) }}</span>
                  </td>
                  <td class="px-4 py-3">
                    <div class="flex gap-2">
                      <button @click="openModal('edit', order)" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700 text-xs">{{ $t('admin.common.edit') }}</button>
                      <button @click="requestDelete(order)" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">{{ $t('admin.common.delete') }}</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div v-if="totalPages > 1" class="mt-6 flex justify-center gap-2">
          <button v-for="page in totalPages" :key="page" @click="currentPage = page; fetchOrders()" :class="currentPage === page ? 'bg-green-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300'" class="px-3 py-1 rounded hover:opacity-80">{{ page }}</button>
        </div>
      </main>
    </div>

    <!-- Order Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
          <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ editMode ? $t('admin.pages.orders.modalEditTitle') : $t('admin.pages.orders.modalAddTitle') }}</h2>
          <button @click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        </div>

        <!-- Edit: view details + update status -->
        <div v-if="editMode" class="p-6 space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><p class="text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.customer') }}</p><p class="font-medium text-gray-900 dark:text-white">{{ form.full_name }}</p></div>
            <div><p class="text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.phone') }}</p><p class="text-gray-900 dark:text-white">{{ form.phone_number }}</p></div>
            <div><p class="text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.email') }}</p><p class="text-gray-900 dark:text-white">{{ form.email }}</p></div>
            <div><p class="text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.payment') }}</p><p class="text-gray-900 dark:text-white capitalize">{{ form.payment_method }}</p></div>
            <div class="md:col-span-2"><p class="text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.address') }}</p><p class="text-gray-900 dark:text-white">{{ form.sector }}, {{ form.district }}, {{ form.province }}, {{ form.country }}</p></div>
          </div>
          <div v-if="form.items && form.items.length" class="border-t dark:border-gray-700 pt-4">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ $t('admin.pages.orders.items', { count: form.items.length }) }}</p>
            <div class="space-y-2">
              <div v-for="item in form.items" :key="item.id" class="flex items-center gap-3 p-2 bg-gray-50 dark:bg-gray-700 rounded">
                <img v-if="item.image_url" :src="item.image_url" :alt="item.product_name" class="w-10 h-10 object-cover rounded" />
                <div class="flex-1">
                  <p class="font-medium text-gray-900 dark:text-white text-sm">{{ item.product_name }}</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.qtyEach', { qty: item.quantity, price: formatPrice(item.price_cents) }) }}</p>
                </div>
                <p class="font-medium text-gray-900 dark:text-white text-sm">{{ formatPrice(item.productTotalAmount) }}</p>
              </div>
            </div>
          </div>
          <div class="border-t dark:border-gray-700 pt-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.status') }}</label>
            <select v-model="form.status" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <option value="pending">{{ $t('admin.status.pending') }}</option>
              <option value="processing">{{ $t('admin.status.processing') }}</option>
              <option value="shipped">{{ $t('admin.status.shipped') }}</option>
              <option value="delivered">{{ $t('admin.status.delivered') }}</option>
              <option value="cancelled">{{ $t('admin.status.cancelled') }}</option>
            </select>
          </div>
          <div class="flex justify-end gap-4 pt-2">
            <button @click="closeModal" class="px-4 py-2 border rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ $t('admin.common.cancel') }}</button>
            <button @click="submitOrder" :disabled="submitting" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50">{{ submitting ? $t('admin.common.saving') : $t('admin.common.save') }}</button>
          </div>
        </div>

        <!-- Add: full form with validation -->
        <form v-else @submit.prevent="submitOrder" novalidate class="p-6 space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('signup.fullName') }} *</label>
              <input v-model="form.fullName" @blur="touch('fullName')" :class="err.fullName ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
              <p v-if="err.fullName" class="text-red-500 text-xs mt-1">{{ err.fullName }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.phone') }} *</label>
              <input v-model="form.phoneNumber" @blur="touch('phoneNumber')" :class="err.phoneNumber ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
              <p v-if="err.phoneNumber" class="text-red-500 text-xs mt-1">{{ err.phoneNumber }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.email') }}</label>
              <input v-model="form.email" @blur="touch('email')" type="email" :class="err.email ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
              <p v-if="err.email" class="text-red-500 text-xs mt-1">{{ err.email }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.payment') }} *</label>
              <select v-model="form.paymentMethod" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="mobile_money">Mobile Money</option>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
              </select>
            </div>

            <div v-if="form.paymentMethod === 'mobile_money'">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.mobileNumber') }} *</label>
              <input v-model="form.mobileMoneyNumber" @blur="touch('mobileMoneyNumber')" :class="err.mobileMoneyNumber ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
              <p v-if="err.mobileMoneyNumber" class="text-red-500 text-xs mt-1">{{ err.mobileMoneyNumber }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.country') }} *</label>
              <input v-model="form.country" @blur="touch('country')" :class="err.country ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
              <p v-if="err.country" class="text-red-500 text-xs mt-1">{{ err.country }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.province') }} *</label>
              <input v-model="form.province" @blur="touch('province')" :class="err.province ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
              <p v-if="err.province" class="text-red-500 text-xs mt-1">{{ err.province }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.district') }} *</label>
              <input v-model="form.district" @blur="touch('district')" :class="err.district ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
              <p v-if="err.district" class="text-red-500 text-xs mt-1">{{ err.district }}</p>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.sector') }} *</label>
              <input v-model="form.sector" @blur="touch('sector')" :class="err.sector ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white" />
              <p v-if="err.sector" class="text-red-500 text-xs mt-1">{{ err.sector }}</p>
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ $t('admin.pages.orders.landmark') }}</label>
              <input v-model="form.nearbyLandmark" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white" />
            </div>
          </div>

          <!-- Order Items -->
          <div class="border-t dark:border-gray-700 pt-4">
            <div class="flex justify-between items-center mb-2">
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('admin.pages.orders.orderItems') }} *</p>
              <button type="button" @click="addItem" class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">+ {{ $t('admin.pages.orders.addItem') }}</button>
            </div>
            <p v-if="err.orderItems" class="text-red-500 text-xs mb-2">{{ err.orderItems }}</p>

            <div v-for="(item, i) in form.orderItems" :key="i" class="mb-3 p-3 border dark:border-gray-600 rounded-lg">
              <div class="flex gap-2 items-start">
                <div class="flex-1">
                  <select
                    v-model="item.productId"
                    @change="onProductSelect(item)"
                    :class="err['item_' + i] ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="w-full px-3 py-2 border rounded-lg text-sm dark:bg-gray-700 dark:text-white"
                  >
                    <option :value="null">{{ $t('admin.pages.orders.selectProduct') }}</option>
                    <option v-for="p in products" :key="p.id" :value="p.id">{{ p.productName }}</option>
                  </select>
                  <p v-if="err['item_' + i]" class="text-red-500 text-xs mt-1">{{ err['item_' + i] }}</p>
                </div>
                <div>
                  <input
                    v-model.number="item.quantity"
                    type="number" min="1"
                    :class="err['qty_' + i] ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="w-20 px-3 py-2 border rounded-lg text-sm dark:bg-gray-700 dark:text-white"
                  />
                  <p v-if="err['qty_' + i]" class="text-red-500 text-xs mt-1">{{ err['qty_' + i] }}</p>
                </div>
                <button type="button" @click="form.orderItems.splice(i, 1)" class="px-2 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-xs flex-shrink-0 mt-0.5">✕</button>
              </div>
              <div v-if="item.colors.length || item.sizes.length" class="mt-2 flex gap-2 items-center flex-wrap">
                <img v-if="item.imageUrl" :src="item.imageUrl" class="w-8 h-8 object-cover rounded flex-shrink-0" />
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ formatPrice(item.priceCents) }}</span>
                <div v-if="item.colors.length" class="flex items-center gap-1">
                  <span class="text-xs text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.color') }}:</span>
                  <label v-for="c in item.colors" :key="c" class="flex items-center gap-1 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs dark:bg-gray-700 dark:text-white cursor-pointer hover:bg-green-50 dark:hover:bg-gray-600">
                    <input type="checkbox" :value="c" v-model="item.selectedColors" class="w-3 h-3 text-green-600" />
                    {{ c }}
                  </label>
                </div>
                <div v-if="item.sizes.length" class="flex items-center gap-1">
                  <span class="text-xs text-gray-500 dark:text-gray-400">{{ $t('admin.pages.orders.size') }}:</span>
                  <label v-for="s in item.sizes" :key="s" class="flex items-center gap-1 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded text-xs dark:bg-gray-700 dark:text-white cursor-pointer hover:bg-green-50 dark:hover:bg-gray-600">
                    <input type="checkbox" :value="s" v-model="item.selectedSizes" class="w-3 h-3 text-green-600" />
                    {{ s }}
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div v-if="formError" class="p-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-lg text-red-800 dark:text-red-200 text-sm">{{ formError }}</div>

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
      :title="$t('admin.confirm.deleteOrderTitle')"
      :message="confirmDeleteMessage"
      :confirm-text="$t('admin.confirm.yesDelete')"
      :cancel-text="$t('admin.common.cancel')"
      :loading="deleting"
      @confirm="confirmDelete"
      @cancel="orderToDelete = null"
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

const orders = ref([])
const products = ref([])
const loading = ref(false)
const submitting = ref(false)
const showModal = ref(false)
const editMode = ref(false)
const statusFilter = ref('')
const currentPage = ref(1)
const totalPages = ref(1)
const formError = ref('')
const err = ref({})

const emptyForm = () => ({
  fullName: '', phoneNumber: '', email: '', country: '', province: '',
  district: '', sector: '', nearbyLandmark: '', paymentMethod: 'mobile_money',
  mobileMoneyNumber: '',
  orderItems: [{ productId: null, productName: '', priceCents: 0, quantity: 1, selectedColors: [], selectedSizes: [], imageUrl: '', colors: [], sizes: [], stock: 0 }]
})

const form = ref(emptyForm())

// ── Validation ────────────────────────────────────────────────────────────────
const required = (val) => !String(val ?? '').trim()

const isValidPhone = (phone) => {
  // Matches formats like: +2507XXXXXXXX, 07XXXXXXXX, +250XXXXXXXXX, etc.
  // Allows optional + prefix, then 9-15 digits
  return /^[\+]?[0-9\s\-]{9,15}$/.test(phone.replace(/\s/g, ''))
}

const validateField = (field) => {
  const f = form.value
  const e = { ...err.value }
  const req = t('admin.validation.required')

  switch (field) {
    case 'fullName':        e.fullName = required(f.fullName) ? req : ''; break
    case 'phoneNumber':     e.phoneNumber = required(f.phoneNumber) ? req : (!isValidPhone(f.phoneNumber) ? t('admin.validation.invalidPhone') : ''); break
    case 'email':           e.email = f.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.email) ? t('admin.validation.invalidEmail') : ''; break
    case 'mobileMoneyNumber': e.mobileMoneyNumber = f.paymentMethod === 'mobile_money' && required(f.mobileMoneyNumber) ? req : ''; break
    case 'country':         e.country = required(f.country) ? req : ''; break
    case 'province':        e.province = required(f.province) ? req : ''; break
    case 'district':        e.district = required(f.district) ? req : ''; break
    case 'sector':          e.sector = required(f.sector) ? req : ''; break
  }
  err.value = e
}

const touch = (field) => validateField(field)

const validateAll = () => {
  const fields = ['fullName', 'phoneNumber', 'email', 'mobileMoneyNumber', 'country', 'province', 'district', 'sector']
  fields.forEach(validateField)

  const e = { ...err.value }

  if (form.value.orderItems.length === 0) {
    e.orderItems = t('admin.validation.atLeastOneItem')
  } else {
    e.orderItems = ''
    form.value.orderItems.forEach((item, i) => {
      e['item_' + i] = !item.productId ? t('admin.validation.selectProduct') : ''
      if (!item.quantity || item.quantity < 1) {
        e['qty_' + i] = t('admin.validation.qtyMin')
      } else if (item.stock !== undefined && item.stock !== null && item.quantity > item.stock) {
        e['qty_' + i] = t('admin.validation.qtyExceedsStock', { stock: item.stock })
      } else {
        e['qty_' + i] = ''
      }
    })
  }

  err.value = e
  return Object.values(e).every(v => !v)
}

// ── Products ──────────────────────────────────────────────────────────────────
const fetchProducts = async () => {
  try {
    const res = await $fetch(`${config.public.baseUrl}/products?limit=100`, {
      headers: { Authorization: `Bearer ${userStore.token}` }
    })
    products.value = res.data || res.products || []
  } catch (e) { console.error(e) }
}

const getProduct = (id) => products.value.find(p => p.id === id)

const parseOptions = (val) => {
  if (!val) return []
  if (Array.isArray(val)) return val
  try { const p = JSON.parse(val); if (Array.isArray(p)) return p } catch {}
  return val.split(',').map(s => s.trim()).filter(Boolean)
}

const onProductSelect = (item) => {
  const p = getProduct(item.productId)
  if (!p) { item.productName = ''; item.priceCents = 0; item.imageUrl = ''; item.colors = []; item.sizes = []; item.stock = 0; item.selectedColors = []; item.selectedSizes = []; return }
  item.productName = p.productName
  item.priceCents = Math.round((parseFloat(p.price) || 0) * 100)
  item.imageUrl = p.imageUrl || ''
  item.colors = parseOptions(p.color)
  item.sizes = parseOptions(p.size)
  item.stock = parseInt(p.stock) || 0
  item.selectedColors = []
  item.selectedSizes = []
}

// ── Orders ────────────────────────────────────────────────────────────────────
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
  } catch (e) { console.error(e) }
  loading.value = false
}

const openModal = (mode, order = null) => {
  editMode.value = mode === 'edit'
  err.value = {}
  formError.value = ''
  form.value = editMode.value && order ? { ...order } : emptyForm()
  showModal.value = true
}

const closeModal = () => { showModal.value = false }

const addItem = () => {
  form.value.orderItems.push({ productId: null, productName: '', priceCents: 0, quantity: 1, selectedColors: [], selectedSizes: [], imageUrl: '', colors: [], sizes: [], stock: 0 })
}

const submitOrder = async () => {
  formError.value = ''
  if (!editMode.value && !validateAll()) return

  submitting.value = true
  try {
    const headers = { Authorization: `Bearer ${userStore.token}` }
    if (editMode.value) {
      await $fetch(`${config.public.baseUrl}/orders?id=${form.value.id}`, {
        method: 'PUT', headers, body: { status: form.value.status }
      })
    } else {
      await $fetch(`${config.public.baseUrl}/orders`, {
        method: 'POST',
        headers,
        body: {
          fullName: form.value.fullName,
          phoneNumber: form.value.phoneNumber,
          email: form.value.email,
          country: form.value.country,
          province: form.value.province,
          district: form.value.district,
          sector: form.value.sector,
          nearbyLandmark: form.value.nearbyLandmark,
          paymentMethod: form.value.paymentMethod,
          mobileMoneyNumber: form.value.mobileMoneyNumber,
          orderItems: form.value.orderItems.map(item => ({
            productId: item.productId ?? null,
            productName: item.productName,
            priceCents: item.priceCents,
            quantity: item.quantity,
            selectedColors: Array.isArray(item.selectedColors) ? item.selectedColors : [],
            selectedSizes: Array.isArray(item.selectedSizes) ? item.selectedSizes : [],
            imageUrl: item.imageUrl ?? ''
          }))
        }
      })
    }
    closeModal()
    fetchOrders()
  } catch (e) { formError.value = e.data?.message || t('admin.errors.saveOrder') }
  submitting.value = false
}

// ── Delete ────────────────────────────────────────────────────────────────────
const confirmDeleteOpen = ref(false)
const deleting = ref(false)
const orderToDelete = ref(null)

const confirmDeleteMessage = computed(() => {
  const id = orderToDelete.value?.id
  return id ? t('admin.confirm.deleteMessageNamed', { name: `#${id}` }) : t('admin.confirm.deleteMessageGeneric')
})

const requestDelete = (order) => { orderToDelete.value = order; confirmDeleteOpen.value = true }

const confirmDelete = async () => {
  if (!orderToDelete.value?.id) return
  deleting.value = true
  try {
    await $fetch(`${config.public.baseUrl}/orders?id=${orderToDelete.value.id}`, {
      method: 'DELETE', headers: { Authorization: `Bearer ${userStore.token}` }
    })
    confirmDeleteOpen.value = false
    orderToDelete.value = null
    fetchOrders()
  } catch (e) { alert(e.data?.message || t('admin.errors.deleteOrder')) }
  deleting.value = false
}

// ── Helpers ───────────────────────────────────────────────────────────────────
const formatPrice = (cents) => {
  const localeMap = { en: 'en-RW', fr: 'fr-FR', rw: 'rw-RW' }
  return new Intl.NumberFormat(localeMap[locale.value] || 'en-RW', { style: 'currency', currency: 'RWF' }).format((cents || 0) / 100)
}
const formatDate = (d) => {
  if (!d) return t('admin.common.na')
  const localeMap = { en: 'en-US', fr: 'fr-FR', rw: 'rw-RW' }
  return new Date(d).toLocaleDateString(localeMap[locale.value] || 'en-US', { year: 'numeric', month: 'short', day: 'numeric' })
}
const statusClass = (s) => ({ pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', processing: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200', shipped: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200', delivered: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200', cancelled: 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }[s] || 'bg-gray-100 text-gray-800')
const statusLabel = (s) => t(`admin.status.${s}`, s)
const handleLogout = () => { userStore.logout(); router.push('/login') }

onMounted(() => { fetchOrders(); fetchProducts() })
definePageMeta({ layout: false })
</script>

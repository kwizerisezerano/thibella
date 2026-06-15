<template>
  <div class="flex justify-center items-center min-h-screen bg-gray-100 dark:bg-gray-900 p-6">
    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md dark:shadow-gray-900">

      <!-- Order Summary -->
      <div>
        <h2 class="text-xl font-semibold mb-4 dark:text-white">Review Your Order:</h2>
        <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg">
          <div
            v-for="product in cartStore.cart"
            :key="product.cartItemId"
            class="flex gap-4 mb-6 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0 last:mb-0 last:pb-0"
          >
            <div class="w-24 h-24 bg-gray-300 dark:bg-gray-600 rounded overflow-hidden flex-shrink-0">
              <img :src="product.imageUrl" :alt="product.name" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1 space-y-1">
              <p class="text-gray-700 dark:text-gray-200 text-sm font-medium">{{ product.name }}</p>

              <p class="text-gray-500 dark:text-gray-400 text-sm">
                <span class="font-semibold">Qty:</span> {{ cartStore.getProductQuantity(product.cartItemId) }}
              </p>

              <p class="text-gray-500 dark:text-gray-400 text-sm">
                Color:
                <span
                  :class="{
                    'text-blue-500': product.selectedColor === 'blue',
                    'text-red-500': product.selectedColor?.toLowerCase().includes('red'),
                    'text-yellow-500': product.selectedColor === 'yellow',
                    'text-gray-500': product.selectedColor === 'white',
                    'text-green-500': product.selectedColor === 'green',
                  }"
                >
                  {{ product.selectedColor }}
                </span>
              </p>

              <p v-if="product.selectedSize" class="text-gray-500 dark:text-gray-400 text-sm">
                <span class="font-semibold">Size:</span> {{ product.selectedSize }}
              </p>

              <p class="font-semibold text-sm dark:text-white">
                {{ formatCurrency(cartStore.convertPrice(product.priceCents), cartStore.selectedCurrency) }}
              </p>
            </div>
          </div>

          <!-- Totals -->
          <div class="mt-4 space-y-2">
            <div class="flex justify-between text-sm dark:text-gray-300">
              <span>Subtotal:</span>
              <span>{{ formatCurrency(cartStore.convertPrice(cartStore.calculateTotalPrice), cartStore.selectedCurrency) }}</span>
            </div>
            <div class="flex justify-between text-sm dark:text-gray-300">
              <span>Shipping:</span>
              <span>{{ cartStore.getShippingCost() }}</span>
            </div>
            <div class="flex justify-between font-semibold text-base border-t border-gray-200 dark:border-gray-600 pt-2 mt-2 dark:text-white">
              <span>Total:</span>
              <span>{{ computedTotal }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Checkout Form -->
      <div>
        <h2 class="text-xl font-semibold mb-4 dark:text-white">Checkout</h2>

        <!-- Global error banner -->
        <div v-if="submitError" class="mb-4 p-3 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded text-sm">
          {{ submitError }}
        </div>

        <div class="space-y-4">

          <!-- Phone Number -->
          <div>
            <label class="block text-sm font-semibold mb-1 dark:text-gray-200">Phone Number</label>
            <div class="flex gap-2">
              <select
                v-model="formData.countryCode"
                class="border border-gray-300 dark:border-gray-600 p-2 rounded bg-white dark:bg-gray-700 dark:text-white"
              >
                <option v-for="country in countryCodes" :key="country.code" :value="country.code">
                  {{ country.flag }} {{ country.code }}
                </option>
              </select>
              <input
                type="tel"
                id="phoneNumber"
                placeholder="Phone Number"
                v-model="formData.phoneNumber"
                class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
                :class="fieldClass('phoneNumber')"
              />
            </div>
            <p v-if="errors.phoneNumber" class="text-red-500 text-xs mt-1">{{ errors.phoneNumber }}</p>
          </div>

          <!-- Full Name -->
          <div>
            <label for="fullName" class="block text-sm font-semibold mb-1 dark:text-gray-200">Full Name</label>
            <input
              type="text"
              id="fullName"
              placeholder="Write your full name here"
              v-model="formData.fullName"
              class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
              :class="fieldClass('fullName')"
            />
            <p v-if="errors.fullName" class="text-red-500 text-xs mt-1">{{ errors.fullName }}</p>
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-semibold mb-1 dark:text-gray-200">Email</label>
            <input
              type="email"
              id="email"
              placeholder="Enter your email"
              v-model="formData.email"
              class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
              :class="fieldClass('email')"
            />
            <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
          </div>

          <!-- Shipping Address -->
          <div>
            <h3 class="font-semibold mb-1 dark:text-gray-200">Shipping Address</h3>
            <div class="space-y-2">
              <div>
                <label for="country" class="sr-only">Country</label>
                <input
                  type="text"
                  id="country"
                  placeholder="Country"
                  v-model="formData.country"
                  class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
                  :class="fieldClass('country')"
                />
                <p v-if="errors.country" class="text-red-500 text-xs mt-1">{{ errors.country }}</p>
              </div>
              <div>
                <label for="province" class="sr-only">Province</label>
                <input type="text" id="province" placeholder="Province" v-model="formData.province"
                  class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white" />
              </div>
              <div>
                <label for="district" class="sr-only">District</label>
                <input type="text" id="district" placeholder="District" v-model="formData.district"
                  class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white" />
              </div>
              <div>
                <label for="sector" class="sr-only">Sector</label>
                <input type="text" id="sector" placeholder="Sector" v-model="formData.sector"
                  class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white" />
              </div>
              <div>
                <label for="nearbyLandmark" class="sr-only">Nearby Landmark</label>
                <input type="text" id="nearbyLandmark" placeholder="Nearby Landmark" v-model="formData.nearbyLandmark"
                  class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white" />
              </div>
            </div>
          </div>

          <!-- Payment Method -->
          <div>
            <label for="paymentMethod" class="block font-semibold mb-1 dark:text-gray-200">Payment Method</label>
            <select
              id="paymentMethod"
              v-model="formData.paymentMethod"
              class="border border-gray-300 dark:border-gray-600 p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
            >
              <option value="mobile_money">Mobile Money</option>
              <option value="bank_account">Bank Account</option>
            </select>

            <!-- Mobile Money -->
            <div v-if="formData.paymentMethod === 'mobile_money'" class="mt-2">
              <label for="mobileMoneyNumber" class="sr-only">Mobile Money Number</label>
              <input
                type="tel"
                id="mobileMoneyNumber"
                placeholder="Mobile Money Number"
                v-model="formData.mobileMoneyNumber"
                class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
                :class="fieldClass('mobileMoneyNumber')"
              />
              <p v-if="errors.mobileMoneyNumber" class="text-red-500 text-xs mt-1">{{ errors.mobileMoneyNumber }}</p>
            </div>

            <!-- Bank / Card -->
            <div v-if="formData.paymentMethod === 'bank_account'" class="mt-2 space-y-2">
              <p class="text-xs text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 p-2 rounded">
                ⚠️ For security, card details are tokenized and never stored on our servers.
              </p>
              <div>
                <label for="nameOnCard" class="sr-only">Name on Card</label>
                <input
                  type="text"
                  id="nameOnCard"
                  placeholder="Name on Card"
                  v-model="formData.nameOnCard"
                  class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
                  :class="fieldClass('nameOnCard')"
                />
                <p v-if="errors.nameOnCard" class="text-red-500 text-xs mt-1">{{ errors.nameOnCard }}</p>
              </div>
              <div>
                <label for="cardNumber" class="sr-only">Card Number</label>
                <input
                  type="text"
                  id="cardNumber"
                  placeholder="Card Number (XXXX XXXX XXXX XXXX)"
                  inputmode="numeric"
                  maxlength="19"
                  v-model="formattedCardNumber"
                  class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
                  :class="fieldClass('cardNumber')"
                />
                <p v-if="errors.cardNumber" class="text-red-500 text-xs mt-1">{{ errors.cardNumber }}</p>
              </div>
              <div class="flex gap-2">
                <div class="w-1/2">
                  <label for="cardExpiry" class="sr-only">Expiry</label>
                  <input
                    type="text"
                    id="cardExpiry"
                    placeholder="MM/YY"
                    maxlength="5"
                    v-model="formData.cardExpiry"
                    class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
                    :class="fieldClass('cardExpiry')"
                  />
                  <p v-if="errors.cardExpiry" class="text-red-500 text-xs mt-1">{{ errors.cardExpiry }}</p>
                </div>
                <div class="w-1/2">
                  <label for="cardCVC" class="sr-only">CVC</label>
                  <input
                    type="text"
                    id="cardCVC"
                    placeholder="CVC"
                    maxlength="4"
                    inputmode="numeric"
                    v-model="formData.cardCVC"
                    class="border p-2 w-full rounded bg-white dark:bg-gray-700 dark:text-white"
                    :class="fieldClass('cardCVC')"
                  />
                  <p v-if="errors.cardCVC" class="text-red-500 text-xs mt-1">{{ errors.cardCVC }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="mt-6">
            <button
              type="button"
              @click="handlePlaceOrder"
              :disabled="isSubmitting"
              class="w-full bg-green-600 text-white py-3 px-6 rounded-md transition-colors dark:bg-green-700 dark:hover:bg-green-800 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed"
              :class="isSubmitting ? '' : 'hover:bg-green-700'"
            >
              <svg v-if="isSubmitting" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
              </svg>
              {{ isSubmitting ? 'Placing Order...' : 'Place Order' }}
            </button>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { formatCurrency } from '~/stores/currencyFormatter';
import { useCartStore } from '~/stores/cart';
import { useUserStore } from '~/stores/user'; // ✅ use userStore, not authStore

const cartStore = useCartStore();
const userStore = useUserStore();
const router = useRouter();

// ─── Guard: redirect if not authenticated or not admin ───────────────────────
onMounted(() => {
  cartStore.loadCart();
  userStore.hydrate(); // ✅ restore name/role/token from localStorage first

  if (!userStore.token) {
    router.push('/login');
    return;
  }

  // Only admins can place orders
  if (userStore.role !== 'admin') {
    router.push('/');
  }
});

// ─── Form State ───────────────────────────────────────────────────────────────

const formData = ref({
  countryCode: '+250',
  phoneNumber: '',
  fullName: '',
  email: '',
  country: '',
  province: '',
  district: '',
  sector: '',
  nearbyLandmark: '',
  paymentMethod: 'mobile_money',
  mobileMoneyNumber: '',
  nameOnCard: '',
  cardNumber: '',
  cardExpiry: '',
  cardCVC: '',
});

const errors = ref({});
const isSubmitting = ref(false);
const submitError = ref('');

// ─── Card Number Formatting ───────────────────────────────────────────────────

const formattedCardNumber = computed({
  get() {
    return formData.value.cardNumber
      .replace(/\D/g, '')
      .replace(/(.{4})/g, '$1 ')
      .trim();
  },
  set(val) {
    formData.value.cardNumber = val.replace(/\s/g, '');
  },
});

// ─── Total Calculation ────────────────────────────────────────────────────────

const computedTotal = computed(() => {
  const subtotal = cartStore.calculateTotalPrice ?? 0;
  const shipping = 0;
  return formatCurrency(
    cartStore.convertPrice(subtotal + shipping),
    cartStore.selectedCurrency
  );
});

// ─── Order Items (sent to backend) ───────────────────────────────────────────

const orderItems = computed(() =>
  cartStore.cart.map((item) => ({
    productId: item.id,
    productName: item.name,
    priceCents: item.priceCents,
    quantity: item.quantity,
    selectedColor: item.selectedColor ?? '',
    selectedSize: item.selectedSize ?? '',
    cartItemId: item.cartItemId,
    imageUrl: item.imageUrl,
  }))
);

// ─── Country Codes ────────────────────────────────────────────────────────────

const countryCodes = [
  { code: '+250', country: 'Rwanda',   flag: '🇷🇼' },
  { code: '+254', country: 'Kenya',    flag: '🇰🇪' },
  { code: '+255', country: 'Tanzania', flag: '🇹🇿' },
  { code: '+256', country: 'Uganda',   flag: '🇺🇬' },
  { code: '+44',  country: 'UK',       flag: '🇬🇧' },
  { code: '+33',  country: 'France',   flag: '🇫🇷' },
  { code: '+49',  country: 'Germany',  flag: '🇩🇪' },
];

// ─── Validation ───────────────────────────────────────────────────────────────

const fieldClass = (field) =>
  errors.value[field]
    ? 'border-red-400 dark:border-red-500'
    : 'border-gray-300 dark:border-gray-600';

const validateForm = () => {
  const e = {};
  const f = formData.value;

  if (!f.fullName.trim()) e.fullName = 'Full name is required.';

  if (!f.email.trim()) {
    e.email = 'Email is required.';
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(f.email)) {
    e.email = 'Enter a valid email address.';
  }

  if (!f.phoneNumber.trim()) {
    e.phoneNumber = 'Phone number is required.';
  } else if (!/^\d{6,15}$/.test(f.phoneNumber.replace(/\s/g, ''))) {
    e.phoneNumber = 'Enter a valid phone number.';
  }

  if (!f.country.trim()) e.country = 'Country is required.';

  if (f.paymentMethod === 'mobile_money') {
    if (!f.mobileMoneyNumber.trim()) {
      e.mobileMoneyNumber = 'Mobile money number is required.';
    } else if (!/^\d{6,15}$/.test(f.mobileMoneyNumber.replace(/\s/g, ''))) {
      e.mobileMoneyNumber = 'Enter a valid mobile money number.';
    }
  }

  if (f.paymentMethod === 'bank_account') {
    if (!f.nameOnCard.trim()) e.nameOnCard = 'Name on card is required.';

    const rawCard = f.cardNumber.replace(/\s/g, '');
    if (!rawCard) {
      e.cardNumber = 'Card number is required.';
    } else if (!/^\d{13,19}$/.test(rawCard)) {
      e.cardNumber = 'Enter a valid card number.';
    }

    if (!f.cardExpiry) {
      e.cardExpiry = 'Expiry is required.';
    } else if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(f.cardExpiry)) {
      e.cardExpiry = 'Use MM/YY format.';
    }

    if (!f.cardCVC) {
      e.cardCVC = 'CVC is required.';
    } else if (!/^\d{3,4}$/.test(f.cardCVC)) {
      e.cardCVC = 'Enter a valid CVC.';
    }
  }

  errors.value = e;
  return Object.keys(e).length === 0;
};

// ─── Submit ───────────────────────────────────────────────────────────────────
const handlePlaceOrder = async () => {
  submitError.value = '';

  if (!userStore.token) {
    submitError.value = 'You must be logged in to place an order.';
    router.push('/login');
    return;
  }

  if (!validateForm()) return;

  isSubmitting.value = true;

  try {
    const payload = {
      ...formData.value,
      orderItems: orderItems.value,
    };

    const res = await $fetch(`${useRuntimeConfig().public.baseUrl}/orders`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${userStore.token}`,
      },
      body: payload,
    });

    if (res.success) {
      cartStore.clearCart();
      router.push('/orders/orderConfirmation');
    } else {
      submitError.value = res.message || 'Something went wrong. Please try again.';
    }
  } catch (err) {
    console.error('Order error:', err);
    submitError.value =
      err?.data?.message ||
      err?.message ||
      'Failed to place order. Please check your connection and try again.';
  } finally {
    isSubmitting.value = false;
  }
};
</script>
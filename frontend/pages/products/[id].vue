<script setup>
import { ref, onMounted, watch, computed } from "vue";
import { useRouter } from 'vue-router';
import { useCartStore } from '~/stores/cart';
import { useI18n } from 'vue-i18n';

const router = useRouter();
const cartStore = useCartStore();
const route = useRoute();
const { t } = useI18n();
// const pending = ref(true);
// const product = ref(null);
const loading = ref(true);
// const error = ref(null);
const selectedImage = ref(null);
const selectedColor = ref('');
const selectedSize = ref('');

const confirmDuplicateOpen = ref(false)
const pendingDuplicateOptions = ref(null)

const duplicateConfirmMessage = computed(() => {
  if (!product.value) return ''
  const parts = []
  if (selectedColor.value) parts.push(`Color: ${selectedColor.value}`)
  if (selectedSize.value) parts.push(`Size: ${selectedSize.value}`)
  const suffix = parts.length ? ` (${parts.join(', ')})` : ''
  return `Are you sure you want to add “${product.value.productName}”${suffix} again into your cart?`
})


const whatsappMessage = computed(() => {
  if (!product.value) return 'Hello, I am interested in one of your products.';

  const lines = [
    `Hello, I am interested in the following product:`,
    `Product: ${product.value.productName}`,
  ];

  if (selectedColor.value) lines.push(` Color: ${selectedColor.value}`);
  if (selectedSize.value)  lines.push(` Size: ${selectedSize.value}`);

    lines.push(``);
    lines.push(`https://thibella.com/products/${product.value.id}`);

  return lines.join('\n');
});

const permanentlySelectedImage = ref(null);

// Computed property to check if current product with selected options is already in cart
const isProductInCart = computed(() => {
  if (!product.value) return false;
  
  // color and size in the cart
  const currentOptions = {
    color: selectedColor.value,
    size: selectedSize.value,
  };
  
  // Check if item exists in cart using the cart store method
  return cartStore.isProductInCart(product.value.id, currentOptions);
});

// Computed property for button text
const buttonText = computed(() => {
  return isProductInCart.value ? 'Add it again' : 'Buy Now';
});

// use local state to select color 
const selectColor = (color) => {
  selectedColor.value = color;
};

// use local state to select clothing size
const selectSize = (size) => {
  selectedSize.value = size;
};

cartStore.loadCart();


const baseUrl = useRuntimeConfig().public.baseUrl;
const productId = route.params.id

const { data, pending: pendings, error } = await useFetch(
  `${baseUrl}/products`,
  {
    params: { id: productId }
  }
)

const product = computed(() => {
  const p = data.value?.data || null;
  if (p) {
    // Safety check: ensure color and size are arrays
    if (!Array.isArray(p.color)) {
      p.color = p.color ? [p.color] : [];
    }
    if (!Array.isArray(p.size)) {
      p.size = p.size ? [p.size] : [];
    }
  }
  return p;
})

console.log(product.value, "product");


watch(product, (newProduct) => {
  if (newProduct) {
    // Set initial image as the main product image
    selectedImage.value = newProduct.imageUrl;
    permanentlySelectedImage.value = newProduct.imageUrl; // Set as permanently selected
  }
});

// Function to handle image selection (click)
const selectImage = (image) => {
  selectedImage.value = image;
  permanentlySelectedImage.value = image; // Remember the clicked image
};

// Function to handle hover (for hover effect)
const hoverImage = (image) => {
  selectedImage.value = image;
};

// Function to reset to permanently selected image when hover ends
const resetImage = () => {
  if (permanentlySelectedImage.value) {
    selectedImage.value = permanentlySelectedImage.value;
  } else if (product.value) {
    selectedImage.value = product.value.imageUrl;
  }
};

// Function to handle buy now button click
const handleBuyNow = () => {
  if (!product.value) return;

  const currentOptions = {
    color: selectedColor.value,
    size: selectedSize.value,
  };

  // Check if product with these exact options is already in cart
  if (cartStore.isProductInCart(product.value.id, currentOptions)) {
    pendingDuplicateOptions.value = currentOptions
    confirmDuplicateOpen.value = true
  } else {
    // Add product to cart for the first time
    cartStore.addToCart(product.value, currentOptions);
    
    const optionsText = [];
    if (selectedColor.value) optionsText.push(`Color: ${selectedColor.value}`);
    if (selectedSize.value) optionsText.push(`Size: ${selectedSize.value}`);

    alert(`${product.value.productName}${optionsText.length ? ` (${optionsText.join(', ')})` : ''} is added to cart`);
  }

  // console.log("Product added to cart:", product.value);
  // console.log("Selected options:", currentOptions);
};

const confirmDuplicateAdd = () => {
  if (!product.value || !pendingDuplicateOptions.value) return
  cartStore.addToCart(product.value, pendingDuplicateOptions.value)
  const optionsText = []
  if (selectedColor.value) optionsText.push(`Color: ${selectedColor.value}`)
  if (selectedSize.value) optionsText.push(`Size: ${selectedSize.value}`)
  alert(`${product.value.productName}${optionsText.length ? ` (${optionsText.join(', ')})` : ''} is added to cart again`)
  confirmDuplicateOpen.value = false
  pendingDuplicateOptions.value = null
}

const cancelDuplicateAdd = () => {
  confirmDuplicateOpen.value = false
  pendingDuplicateOptions.value = null
}


const colorClasses = {
  Black: "bg-gray-900",
  Gray: "bg-gray-400",
  White: "bg-white border border-gray-300",
  Blue: "bg-blue-500",
  Red: "bg-red-500",
  Green: "bg-green-500",
  Yellow: "bg-yellow-300",
  Pink: "bg-pink-400",
  Purple: "bg-purple-500",
  Orange: "bg-orange-400",
  Brown: "bg-amber-700",
  Navy: "bg-blue-900",
  Beige: "bg-amber-100 border border-gray-300",
};

const defaultColorClass = "bg-gray-400";




</script>

<template>
    <!-- Add dark mode background to the main wrapper -->
  <div class="bg-gray-100 dark:bg-gray-900">

  <!-- Loading State -->
  <div v-if="pendings" class="container mx-auto px-4 pt-4 text-center">
    <div class="animate-spin rounded-full h-32 w-32 border-b-2 border-green-500 dark:border-blue-400 mx-auto"></div>
    <p class="mt-4 text-green-600 dark:text-green-300">{{ $t('product.loading') }}</p>
  </div>

  <!-- Error State -->
  <div v-else-if="error" class="container mx-auto px-4 pt-4 text-center">
    <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-lg shadow">
      <p class="font-medium">{{ error }}</p>
      <button 
        @click="$router.go(-1)" 
        class="mt-3 bg-red-500 dark:bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-600 dark:hover:bg-red-700 transition-colors duration-200"
      >
        {{ $t('product.goBack') }}
      </button>
    </div>
  </div>

  <!-- Product Details -->
  <div v-else-if="product" class="container mx-auto px-4 pt-4 pb-0">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start bg-white dark:bg-gray-900 p-6 rounded-lg shadow dark:shadow-gray-800">
      <!-- Image Gallery (Top-Left) - Modified Layout -->
      <div class="self-start">
        <div class="flex gap-4 max-h-96">
          <!-- Main Product Image -->
          <div class="flex-1">
            <img 
              :src="selectedImage || product.imageUrl" 
              alt="Product" 
              class="w-full h-96 object-contain rounded-lg shadow-lg bg-gray-50 dark:bg-gray-800 transition-all duration-300"
            />
          </div>
          
          <!-- Thumbnail Images on the Right Side -->
          <div class="flex flex-col gap-2 w-20 overflow-y-auto">
            <!-- Main image thumbnail -->
            <img
              :src="product.imageUrl"
              alt="Main product"
              class="w-16 h-16 object-contain rounded-lg cursor-pointer border-2 transition-all duration-200 flex-shrink-0"
              :class="selectedImage === product.imageUrl || (!selectedImage) ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-300 hover:border-blue-400'"
              @click="selectImage(product.imageUrl)"
            />
            <!-- Additional product images thumbnails -->
            <img
              v-for="(image, index) in product.possibleImagesUrls"
              :key="index"
              :src="image"
              alt="Product variation"
              class="w-16 h-16 object-contain rounded-lg cursor-pointer border-2 transition-all duration-200 flex-shrink-0"
              :class="selectedImage === image ? 'border-blue-500 ring-2 ring-blue-200' : 'border-gray-300 hover:border-blue-400'"
              @mouseenter="hoverImage(image)"
              @mouseleave="resetImage"
              @click="selectImage(image)"
            /> 
          </div>
        </div>
      </div>

      <!-- Product Details (Right) -->
      <div class="text-gray-900 dark:text-white">
        <div class="flex items-center gap-2 mb-2">
          <h1 class="text-2xl font-bold dark:text-white">{{ product.productName }}</h1>
          <span v-if="product.isOnSale" class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">SALE</span>
        </div>
        
        <!-- Brand -->
        <p v-if="product.brand" class="text-gray-600 dark:text-gray-400 text-sm mb-2">
          <span class="font-semibold">Brand:</span> {{ product.brand }}
        </p>

        <!-- Price -->
        <p class="text-3xl font-bold my-2" :class="product.isOnSale ? 'text-red-500' : 'text-green-600 dark:text-green-400'">
          {{ product.price }} {{ product.currency }}
        </p>

        <!-- Stock -->
        <p v-if="product.stock !== null && product.stock !== undefined" class="text-gray-600 dark:text-gray-400 mb-4">
          <span class="font-semibold">Stock:</span> 
          <span :class="product.stock > 0 ? 'text-green-600' : 'text-red-500'">
            {{ product.stock > 0 ? `${product.stock} available` : 'Out of stock' }}
          </span>
        </p>

        <!-- Description -->
        <p class="text-gray-700 dark:text-gray-300 mb-4">{{ product.description }}</p>

        <!-- loop in product.color and display buttons of Colors -->

        <!-- loop in product.color and display color dot selectors -->
                
        <div v-if="Array.isArray(product.color) && product.color.length" class="mt-4">
          <p class="font-semibold mb-2 dark:text-white">{{ $t('product.colors') }}</p>

          <div class="flex flex-wrap gap-3">
            <button
              v-for="color in product.color"
              :key="color"
              @click="selectColor(color)"
              :title="color"
              class="relative w-10 h-10 rounded-full transition-all duration-200 focus:outline-none border-2 border-gray-200"
              :class="[
                colorClasses[color] || defaultColorClass,
                selectedColor === color
                  ? 'ring-4 ring-offset-2 ring-blue-500 scale-110 shadow-lg'
                  : 'hover:scale-105 hover:shadow-md'
              ]"
            >
              <!-- Checkmark for selected -->
              <span
                v-if="selectedColor === color"
                class="absolute inset-0 flex items-center justify-center text-white text-sm font-bold"
              >
                ✓
              </span>
            </button>
          </div>

          <!-- display selected color label -->
          <div v-if="selectedColor" class="mt-2">
            <p class="text-sm text-gray-600 dark:text-gray-400">
              {{ $t('product.selected') }}
              <span class="font-semibold capitalize dark:text-white">{{ selectedColor }}</span>
            </p>
          </div>
        </div>

        <!-- loop in product.size and Display Sizes-->
        <div v-if="Array.isArray(product.size) && product.size.length > 0" class="mt-6">
          <p class="font-semibold mb-2">{{ $t('product.sizes') }}</p>
          <div class="flex flex-wrap gap-2">
            <button
              v-for="size in product.size" 
              :key="size"
              @click="selectSize(size)"
              class="px-4 py-2 rounded-lg border-2 transition-all duration-200"
              :class="[
                selectedSize === size
                  ? 'border-green-500 bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-300 font-semibold'
                  : 'border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:border-green-400'
              ]"
            >
              {{ size }}
            </button>
          </div>
        </div>

         <!-- Display selected size of clothing -->
           <div v-if="selectedSize" class="mt-2">
              <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ $t('product.selectedSize') }}: 
                <span class="font-semibold dark:text-white">{{ selectedSize }}</span>
              </p>
           </div>

           <!-- Buy Now Button with dynamic styling -->
<span class="flex flex-row justify-start gap-4">
  
  <!-- <a  href="https://wa.me/250795149806"
    target="_blank"
    rel="noopener noreferrer"
    class="mt-6 inline-flex items-center justify-center gap-2 text-white px-6 py-3 rounded-lg w-48 transition-colors bg-green-500 dark:bg-green-400 hover:bg-green-600"
  > -->
  <a  
  :href="`https://wa.me/250795149806?text=${encodeURIComponent(whatsappMessage)}`"
  target="_blank"
  rel="noopener noreferrer"
  class="mt-6 inline-flex items-center justify-center gap-2 text-white px-6 py-3 rounded-lg w-48 transition-colors bg-green-500 dark:bg-green-400 hover:bg-green-600"
>
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
      <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
    {{ $t('product.callSeller') }}
  </a>

</span>


        <!-- Buy Now Button with dynamic styling -->
         <!-- <span class="flex flex-row justify-start gap-4">
           <button 
           @click="handleBuyNow"
           :class="isProductInCart ? 'bg-green-500 dark:bg-green-400 hover:bg-green-600' : 'bg-green-500 dark:bg-green-400 hover:bg-green-600'"
           class="mt-6 text-white px-6 py-3 rounded-lg w-48 transition-colors"
           >
           {{ buttonText }}
          </button>

          <button 
          v-if="isProductInCart"
           @click="$router.push('/cart')"
           class="mt-6 text-gray-700 dark:text-gray-300 px-4 py-3 rounded-lg w-38 border border-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
           >
           <span class="text-xl sm:text-2xl">🛒 View Cart</span> -->
           <!-- <span class="text-sm sm:text-base text-green-400">🛒 View Cart</span>

          </button>
      </span> --> 
 
      </div>
    </div>
  </div>

  <!-- Product Not Found -->
  <div v-else class="container mx-auto px-4 pt-4 text-center">
    <p class="text-gray-500 dark:text-gray-300">{{ $t('product.notFound') }}</p>
    <button 
      @click="$router.go(-1)" 
      class="mt-2 bg-green-500 dark:bg-green-400 text-white px-4 py-2 rounded hover:bg-green-600"
    >
      {{ $t('product.goBack') }}
    </button>
  </div>

  <ConfirmModal
    v-model="confirmDuplicateOpen"
    tone="primary"
    title="Add to cart again?"
    :message="duplicateConfirmMessage"
    confirm-text="Yes, add"
    cancel-text="Cancel"
    @confirm="confirmDuplicateAdd"
    @cancel="cancelDuplicateAdd"
  />
  </div>
</template>

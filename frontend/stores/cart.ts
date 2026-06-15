import { defineStore } from "pinia";
import { apiFetch } from "~/utils/api";
import { ref, onMounted } from "vue";
import type { Product } from "~/stores/productStore";

const products = ref<Product[]>([]);

onMounted(async () => {
  try {
    const response = await apiFetch("api/products", {
      method: "GET",
      headers: { "Content-Type": "application/json", "Accept-Language": "en" },
    });
    products.value = response as Product[];
  } catch (error) {
    console.error("Error fetching products", error);
  }
});

export const useCartStore = defineStore("cart", {
  state: () => ({
    cart: [] as Product[],
    selectedCurrency: "RWF",
    selectedImage: "",
    selectedShipping: "Standard",
    selectedColor: "",
    selectedSize: "",
  }),
  getters: {
    // ✅ Uses cartItemId as the unique key for variant-aware lookup
    getProductQuantity: (state) => {
      return (cartItemId: string): number => {
        const item = state.cart.find((i) => i.cartItemId === cartItemId);
        return item ? item.quantity : 0;
      };
    },

    // ✅ Removed nested computed() — plain getter works correctly in Pinia
    cartTotalQuantity: (state): number => {
      return state.cart.reduce((total, product) => total + product.quantity, 0);
    },

    // ✅ Removed nested computed() — plain getter works correctly in Pinia
    calculateTotalPrice: (state): number => {
      return state.cart.reduce(
        (total, product) => total + product.priceCents * product.quantity,
        0
      );
    },

    cartItems: (state) => state.cart,
  },
  actions: {
    // ✅ Uses cartItemId so only the specific variant is updated
    incrementQuantity(cartItemId: string) {
      const item = this.cart.find((i) => i.cartItemId === cartItemId);
      if (item) item.quantity++;
      this.updateLocalStorage();
    },

    // ✅ Uses cartItemId so only the specific variant is updated
    decrementQuantity(cartItemId: string) {
      const item = this.cart.find((i) => i.cartItemId === cartItemId);
      if (!item) return;
      if (item.quantity > 1) {
        item.quantity--;
        this.updateLocalStorage();
      } else {
        this.removeFromCart(cartItemId);
        this.updateLocalStorage();
      }
    },

    // Convert price based on selected currency
    convertPrice(priceCents: number) {
      const exchangeRates: Record<string, number> = {
        USD: 0.00071,
        EUR: 0.00068,
        RWF: 1,
      };
      const convertedPrice = parseFloat(
        (priceCents * exchangeRates[this.selectedCurrency]).toFixed(2)
      );
      return convertedPrice;
    },

    // Generate a consistent unique cartItemId based on product + variant options
    generateCartItemId(
      productId: string,
      options: { color?: string; size?: string } = {}
    ) {
      return `${productId}-${options.color || "default"}-${
        options.size || "default"
      }`;
    },

    // Check if a specific product+variant combo is already in the cart
    isProductInCart(
      productId: string,
      options: { color?: string; size?: string } = {}
    ) {
      if (!this.cart || this.cart.length === 0) return false;
      const cartItemId = this.generateCartItemId(productId, options);
      return this.cart.some((item) => item.cartItemId === cartItemId);
    },

    // Shipping and handling cost
    getShippingCost() {
      switch (this.selectedShipping) {
        case "Standard":
        default:
          return "Free";
      }
    },

    // Estimated delivery date based on shipping method
    getEstimatedDeliveryDate() {
      if (!this.selectedShipping) return "";

      const today = new Date();
      const deliveryDate = new Date(today);

      switch (this.selectedShipping) {
        case "Standard":
          deliveryDate.setDate(today.getDate() + 7);
          break;
        case "Express":
          deliveryDate.setDate(today.getDate() + 3);
          break;
        case "Overnight":
          deliveryDate.setDate(today.getDate() + 1);
          break;
        default:
          return "";
      }

      return deliveryDate.toLocaleDateString("en-US", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    },

    setSelectedImage(imageUrl: string) {
      this.selectedImage = imageUrl;
      if (import.meta.client) {
        localStorage.setItem("selectedImage", imageUrl);
      }
      this.updateLocalStorage();
    },

    setShipping(shipping: string) {
      this.selectedShipping = shipping;
      if (import.meta.client) {
        localStorage.setItem("selectedShipping", shipping);
      }
      this.updateLocalStorage();
    },

    setCurrency(newCurrency: string) {
      this.selectedCurrency = newCurrency;
      if (import.meta.client) {
        localStorage.setItem("selectedCurrency", newCurrency);
      }
      this.updateLocalStorage();
    },

    setSelectedColor(color: string) {
      this.selectedColor = color;
      if (import.meta.client) {
        localStorage.setItem("selectedColor", color);
      }
      this.updateLocalStorage();
    },

    setSelectedSize(size: string) {
      this.selectedSize = size;
      if (import.meta.client) {
        localStorage.setItem("selectedSize", size);
      }
      this.updateLocalStorage();
    },

    // Load cart and preferences from localStorage
    loadCart() {
      if (import.meta.client) {
        const storedCart = localStorage.getItem("cart");
        const storedCurrency = localStorage.getItem("selectedCurrency");
        const storedImage = localStorage.getItem("selectedImage");
        const storedShipping = localStorage.getItem("selectedShipping");
        const storedColor = localStorage.getItem("selectedColor");
        const storedSize = localStorage.getItem("selectedSize");

        this.cart = storedCart ? JSON.parse(storedCart) : [];
        this.selectedCurrency = storedCurrency ?? "RWF";
        this.selectedImage = storedImage ?? "";
        this.selectedShipping = storedShipping ?? "Standard";
        this.selectedColor = storedColor ?? "";
        this.selectedSize = storedSize ?? "";
      }
    },

    // Persist all cart state to localStorage
    updateLocalStorage() {
      if (import.meta.client) {
        localStorage.setItem("cart", JSON.stringify(this.cart));
        localStorage.setItem("selectedCurrency", this.selectedCurrency);
        localStorage.setItem("selectedImage", this.selectedImage);
        localStorage.setItem("selectedShipping", this.selectedShipping);
        localStorage.setItem("selectedColor", this.selectedColor);
        localStorage.setItem("selectedSize", this.selectedSize);
      }
    },

    addToCart(
      product: Product,
      selectedOptions: { color?: string; size?: string } = {}
    ) {
      if (!product) return;

      const cartItemId = this.generateCartItemId(product.id, selectedOptions);
      const existingProduct = this.cart.find(
        (item) => item.cartItemId === cartItemId
      );

      if (existingProduct) {
        existingProduct.quantity++;
      } else {
        this.cart.push({
          ...product,
          quantity: 1,
          selectedColor: selectedOptions.color || "",
          selectedSize: selectedOptions.size || "",
          cartItemId,
        });
      }

      this.updateLocalStorage();
    },

    // Remove item from cart by cartItemId
    removeFromCart(cartItemId: string) {
      this.cart = this.cart.filter((item) => item.cartItemId !== cartItemId);
      this.updateLocalStorage();
    },

    // Get a specific cart item by cartItemId
    getCartItem(cartItemId: string) {
      return this.cart.find((item) => item.cartItemId === cartItemId);
    },

    // Update quantity for a specific cart item
    updateCartItemQuantity(cartItemId: string, newQuantity: number) {
      const item = this.cart.find((item) => item.cartItemId === cartItemId);
      if (item) {
        if (newQuantity <= 0) {
          this.removeFromCart(cartItemId);
        } else {
          item.quantity = newQuantity;
          this.updateLocalStorage();
        }
      }
    },

    // Clear entire cart
    clearCart() {
      this.cart = [];
      this.updateLocalStorage();
    },
  },
});
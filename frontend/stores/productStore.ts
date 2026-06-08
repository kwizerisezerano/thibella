import { defineStore } from "pinia";
import { ref } from "vue";
import { apiFetch } from "~/utils/api";

export type Product = {
  id: string;
  image: string;
  imageOfColors: {
    imageA: string;
    imageB: string;
    imageC: string;
    imageD: string;
  };
  name: string;
  description: string;
  rating: {
    stars: number;
    count: number;
  };
  priceCents: number;
  keywords: string[];
  quantity: number;
  type: string;
  color: {
    color1: string;
    color2: string;
    color3: string;
    color4: string;
  };
  clothingSize: {
    small: string;
    medium: string;
    large: string;
    xlarge: string;
  };
  shoesSize: number[];
};

export const useProductStore = defineStore("product", {
  state: () => ({
    products: [] as Product[],
    isLoading: false,
  }),

  getters: {
    getProductById: (state) => (id: string) => {
      return state.products.find((product) => product.id === id);
    },
  },

  actions: {
    async fetchProducts() {
      this.isLoading = true;
      try {
        const response = await apiFetch("products2", {
          method: "GET",
          headers: { "Content-Type": "application/json", "Accept-Language": "en" },
        });
        console.log("API Response:", response);
        this.products = response as Product[];
      } catch (error) {
        console.error("Error fetching products", error);
      } finally {
        this.isLoading = false;
      }
    },
  },
});

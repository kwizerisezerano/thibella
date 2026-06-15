import { defineStore } from "pinia";
import { useI18n } from "vue-i18n";
import { apiFetch } from "~/utils/api";

export type Product = {
  id: string;
  productName: string;
  description: string;
  imageUrl: string;
  possibleImagesUrls: string | string[];
  categoryId?: string;
  categoryName?: string;
  subCategoryId?: string;
  subCategoryName?: string;
  price: number;
  priceCents: number;
  currency: string;
  isOnSale: boolean;
  salePrice?: number;
  brand?: string;
  size: string | string[];
  color: string | string[];
  stock: number;
  createdAt?: string;
  updatedAt?: string;
};

type Pagination = {
  total: number;
  page: number;
  limit: number;
  totalPages: number;
};

export const useProductStore = defineStore("product", {
  state: () => ({
    products: [] as Product[],
    currentProduct: null as Product | null,
    isLoading: false,
    isLoadingSingle: false,
    pagination: null as Pagination | null,
    error: null as string | null,
  }),

  getters: {
    getProductById: (state) => (id: string) => {
      return state.products.find((product) => product.id === id);
    },
    getProductsByCategory: (state) => (categoryId: string) => {
      return state.products.filter((product) => product.categoryId === categoryId);
    },
    getProductsBySubcategory: (state) => (subcategoryId: string) => {
      return state.products.filter((product) => product.subCategoryId === subcategoryId);
    },
  },

  actions: {
    async fetchProducts(params: {
      page?: number;
      limit?: number;
      category_id?: string;
      subcategory_id?: string;
      search?: string;
      sort?: string;
    } = {}) {
      this.isLoading = true;
      this.error = null;
      const { locale } = useI18n();

      try {
        const searchParams = new URLSearchParams();
        if (params.page) searchParams.set('page', params.page.toString());
        if (params.limit) searchParams.set('limit', params.limit.toString());
        if (params.category_id) searchParams.set('category_id', params.category_id);
        if (params.subcategory_id) searchParams.set('subcategory_id', params.subcategory_id);
        if (params.search) searchParams.set('search', params.search);
        if (params.sort) searchParams.set('sort', params.sort);

        const response = await apiFetch<{
          success: boolean;
          products: Product[];
          pagination: Pagination;
        }>(`products?${searchParams.toString()}`, {
          method: "GET",
          headers: { "Accept-Language": locale.value },
        });
        
        if (response.success) {
          if (params.page && params.page > 1) {
            this.products = [...this.products, ...response.products];
          } else {
            this.products = response.products;
          }
          this.pagination = response.pagination;
        }
      } catch (error) {
        console.error("Error fetching products", error);
        this.error = "Failed to load products";
      } finally {
        this.isLoading = false;
      }
    },

    async fetchProductById(id: string) {
      this.isLoadingSingle = true;
      this.error = null;
      const { locale } = useI18n();

      try {
        const response = await apiFetch<{
          success: boolean;
          data: Product;
        }>(`products?id=${id}`, {
          method: "GET",
          headers: { "Accept-Language": locale.value },
        });
        
        if (response.success) {
          this.currentProduct = response.data;
        }
      } catch (error) {
        console.error("Error fetching product", error);
        this.error = "Failed to load product";
      } finally {
        this.isLoadingSingle = false;
      }
    },

    clearCurrentProduct() {
      this.currentProduct = null;
    },
  },
});

import { defineStore } from "pinia";
import { useI18n } from "vue-i18n";
import { apiFetch } from "~/utils/api";

export type Subcategory = {
  id: number;
  categoryId: number;
  name: string;
  description?: string;
  image?: string;
  slug?: string;
  createdAt?: string;
  updatedAt?: string;
};

export type Category = {
  id: number;
  title: string;
  description?: string;
  slug: string;
  image?: string;
  subcategories?: Subcategory[];
  createdAt?: string;
  updatedAt?: string;
};

type Pagination = {
  total: number;
  page: number;
  limit: number;
  totalPages: number;
};

export const useCategoryStore = defineStore("category", {
  state: () => ({
    categories: [] as Category[],
    currentCategory: null as Category | null,
    isLoading: false,
    isLoadingSingle: false,
    pagination: null as Pagination | null,
    error: null as string | null,
  }),

  getters: {
    getCategoryById: (state) => (id: number) => {
      return state.categories.find((category) => category.id === id);
    },
    getCategoryBySlug: (state) => (slug: string) => {
      return state.categories.find((category) => category.slug === slug);
    },
  },

  actions: {
    async fetchCategories(params: {
      page?: number;
      limit?: number;
      withSubcategories?: boolean;
    } = {}) {
      this.isLoading = true;
      this.error = null;
      const { locale } = useI18n();

      try {
        const searchParams = new URLSearchParams();
        if (params.page) searchParams.set('page', params.page.toString());
        if (params.limit) searchParams.set('limit', params.limit.toString());
        if (params.withSubcategories) searchParams.set('with_subcategories', '1');

        const response = await apiFetch<{
          success: boolean;
          categories: Category[];
          pagination: Pagination;
        }>(`categories?${searchParams.toString()}`, {
          method: "GET",
          headers: { "Accept-Language": locale.value },
        });
        
        if (response.success) {
          if (params.page && params.page > 1) {
            this.categories = [...this.categories, ...response.categories];
          } else {
            this.categories = response.categories;
          }
          this.pagination = response.pagination;
        }
      } catch (error) {
        console.error("Error fetching categories", error);
        this.error = "Failed to load categories";
      } finally {
        this.isLoading = false;
      }
    },

    async fetchCategoryBySlug(slug: string, withSubcategories: boolean = false) {
      this.isLoadingSingle = true;
      this.error = null;
      const { locale } = useI18n();

      try {
        const searchParams = new URLSearchParams();
        searchParams.set('slug', slug);
        if (withSubcategories) searchParams.set('with_subcategories', '1');

        const response = await apiFetch<{
          success: boolean;
          data: Category;
        }>(`categories?${searchParams.toString()}`, {
          method: "GET",
          headers: { "Accept-Language": locale.value },
        });
        
        if (response.success) {
          this.currentCategory = response.data;
        }
      } catch (error) {
        console.error("Error fetching category", error);
        this.error = "Failed to load category";
      } finally {
        this.isLoadingSingle = false;
      }
    },

    async fetchCategoryById(id: number, withSubcategories: boolean = false) {
      this.isLoadingSingle = true;
      this.error = null;
      const { locale } = useI18n();

      try {
        const searchParams = new URLSearchParams();
        searchParams.set('id', id.toString());
        if (withSubcategories) searchParams.set('with_subcategories', '1');

        const response = await apiFetch<{
          success: boolean;
          data: Category;
        }>(`categories?${searchParams.toString()}`, {
          method: "GET",
          headers: { "Accept-Language": locale.value },
        });
        
        if (response.success) {
          this.currentCategory = response.data;
        }
      } catch (error) {
        console.error("Error fetching category", error);
        this.error = "Failed to load category";
      } finally {
        this.isLoadingSingle = false;
      }
    },

    clearCurrentCategory() {
      this.currentCategory = null;
    },
  },
});

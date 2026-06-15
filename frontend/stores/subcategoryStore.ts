import { defineStore } from "pinia";
import { useI18n } from "vue-i18n";
import { apiFetch } from "~/utils/api";

export type Subcategory = {
  id: number;
  categoryId: number;
  name: string;
  description?: string;
  slug: string;
  image?: string;
  category?: any;
  createdAt?: string;
  updatedAt?: string;
};

type Pagination = {
  total: number;
  page: number;
  limit: number;
  totalPages: number;
};

export const useSubcategoryStore = defineStore("subcategory", {
  state: () => ({
    subcategories: [] as Subcategory[],
    currentSubcategory: null as Subcategory | null,
    isLoading: false,
    isLoadingSingle: false,
    pagination: null as Pagination | null,
    error: null as string | null,
  }),

  getters: {
    getSubcategoryById: (state) => (id: number) => {
      return state.subcategories.find((subcategory) => subcategory.id === id);
    },
    getSubcategoryBySlug: (state) => (slug: string) => {
      return state.subcategories.find((subcategory) => subcategory.slug === slug);
    },
    getSubcategoriesByCategoryId: (state) => (categoryId: number) => {
      return state.subcategories.filter((subcategory) => subcategory.categoryId === categoryId);
    },
  },

  actions: {
    async fetchSubcategories(params: {
      page?: number;
      limit?: number;
      categoryId?: number;
      withCategory?: boolean;
    } = {}) {
      this.isLoading = true;
      this.error = null;
      const { locale } = useI18n();

      try {
        const searchParams = new URLSearchParams();
        if (params.page) searchParams.set('page', params.page.toString());
        if (params.limit) searchParams.set('limit', params.limit.toString());
        if (params.categoryId) searchParams.set('category_id', params.categoryId.toString());
        if (params.withCategory) searchParams.set('with_category', '1');

        const response = await apiFetch<{
          success: boolean;
          subcategories: Subcategory[];
          pagination: Pagination;
        }>(`subcategories?${searchParams.toString()}`, {
          method: "GET",
          headers: { "Accept-Language": locale.value },
        });
        
        if (response.success) {
          if (params.page && params.page > 1) {
            this.subcategories = [...this.subcategories, ...response.subcategories];
          } else {
            this.subcategories = response.subcategories;
          }
          this.pagination = response.pagination;
        }
      } catch (error) {
        console.error("Error fetching subcategories", error);
        this.error = "Failed to load subcategories";
      } finally {
        this.isLoading = false;
      }
    },

    async fetchSubcategoryBySlug(slug: string, withCategory: boolean = false) {
      this.isLoadingSingle = true;
      this.error = null;
      const { locale } = useI18n();

      try {
        const searchParams = new URLSearchParams();
        searchParams.set('slug', slug);
        if (withCategory) searchParams.set('with_category', '1');

        const response = await apiFetch<{
          success: boolean;
          data: Subcategory;
        }>(`subcategories?${searchParams.toString()}`, {
          method: "GET",
          headers: { "Accept-Language": locale.value },
        });
        
        if (response.success) {
          this.currentSubcategory = response.data;
        }
      } catch (error) {
        console.error("Error fetching subcategory", error);
        this.error = "Failed to load subcategory";
      } finally {
        this.isLoadingSingle = false;
      }
    },

    async fetchSubcategoryById(id: number, withCategory: boolean = false) {
      this.isLoadingSingle = true;
      this.error = null;
      const { locale } = useI18n();

      try {
        const searchParams = new URLSearchParams();
        searchParams.set('id', id.toString());
        if (withCategory) searchParams.set('with_category', '1');

        const response = await apiFetch<{
          success: boolean;
          data: Subcategory;
        }>(`subcategories?${searchParams.toString()}`, {
          method: "GET",
          headers: { "Accept-Language": locale.value },
        });
        
        if (response.success) {
          this.currentSubcategory = response.data;
        }
      } catch (error) {
        console.error("Error fetching subcategory", error);
        this.error = "Failed to load subcategory";
      } finally {
        this.isLoadingSingle = false;
      }
    },

    clearCurrentSubcategory() {
      this.currentSubcategory = null;
    },
  },
});

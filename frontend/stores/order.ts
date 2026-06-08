import { defineStore } from 'pinia';
import { useCartStore } from '@/stores/cart';
import { useAuthStore } from '@/stores/auth';

export const useOrderStore = defineStore('order', {
  state: () => ({
    orders: (import.meta.client && localStorage.getItem('orders')) 
      ? JSON.parse(localStorage.getItem('orders')!)
      : [] as {
          id: string;
          userId: string;
          items: any[];
          status: string;
          totalAmount?: number;
          orderDate?: string;
          contactInfo: {
            email: string;
            phone: string;
          };
          shippingAddress: {
            country: string;
            fullName: string;
            addressLine1: string;
            addressLine2?: string;
            city: string;
            state?: string;
            zipCode?: string;
          };
          payment: {
            method: string;
            details: 
              | { mobileMoneyNumber: string }
              | { nameOnCard: string; cardNumber: string; cardExpiry: string; cardCVC: string };
          };
          subscription: boolean;
          promoCode?: string;
          currency: string;
        }[]
  }),

  getters: {
    getOrdersByUserId: (state) => (userId: string) => {
      return state.orders.filter((order: { id: string; userId: string; items: any[]; status: string; totalAmount?: number; orderDate?: string }) => order.userId === userId);
    },
    getOrderById: (state) => (orderId: string) => {
      return state.orders.find((order: { id: string; userId: string; items: any[]; status: string; totalAmount?: number; orderDate?: string }) => order.id === orderId);
    }
  },

  actions: {
    async placeOrder(userId: string) {
      const cartStore = useCartStore();
      const authStore = useAuthStore();

      // Input validation
      if (!authStore.userId) {
        throw new Error("Please log in first!");
      }

      if (cartStore.cart.length === 0) {
        throw new Error("Your cart is empty!");
      }

      // Determine order status
      const orderStatus = authStore.status === "connected" 
        ? "Confirmed"
        : "Pending Verification";

      // Calculate total amount
      const totalAmount = cartStore.cart.reduce((total, item) => 
        total + (item.priceCents * item.quantity), 0);

      // Get order metadata if available
      let orderMetadata = {};
      if (import.meta.client && localStorage.getItem('lastOrderMetadata')) {
        orderMetadata = JSON.parse(localStorage.getItem('lastOrderMetadata')!);
        // Clear the metadata after retrieving it
        localStorage.removeItem('lastOrderMetadata');
      }

      // Create a new order
      const newOrder = {
        id: `ORD${Date.now()}`,
        userId: authStore.userId,
        items: [...cartStore.cart],
        status: orderStatus,
        totalAmount: totalAmount,
        orderDate: new Date().toISOString(),
        ...orderMetadata // Add the metadata to the order
      };

      console.log("Placing order:", newOrder);

      try {
        // Send order to the REAL API endpoint
        const response = await apiFetch(`api/orders`, { 
          method: 'POST',
          headers: {
            "Content-Type": "application/json",
            'Accept-Language': 'en'
          },
          body: JSON.stringify(newOrder),
        });

        console.log("Full response:", response);

        // Update local state
        this.orders.push({
          ...newOrder
        });

        // Update local storage
        if (import.meta.client) {
          localStorage.setItem('orders', JSON.stringify(this.orders));
        }

        // Clear cart
        cartStore.clearCart();

        return newOrder;

      } catch (error) {
        console.error("Error placing order:", error);
        throw error;
      }
    },

    // Additional methods to interact with the API
    async fetchUserOrders(userId: string) {
      try {
        const response = await apiFetch(`orders/user/${userId}`, {
          method: 'GET',
          headers: {
            'Accept-Language': 'en'
          }
        });
        
        // Update local orders with fetched data
        this.orders = response;
        
        // Update local storage
        if (import.meta.client) {
          localStorage.setItem('orders', JSON.stringify(this.orders));
        }
        
        return response;
      } catch (error) {
        console.error("Error fetching user orders:", error);
        throw error;
      }
    },

    async updateOrderStatus(orderId: string, status: string) {
      try {
        const response = await apiFetch(`orders/${orderId}/status`, {
          method: 'PUT',
          headers: {
            "Content-Type": "application/json",
            'Accept-Language': 'en'
          },
          body: JSON.stringify(status)
        });

        // Update local order status
        const orderIndex = this.orders.findIndex(order => order.id === orderId);
        if (orderIndex !== -1) {
          this.orders[orderIndex].status = status;
          
          // Update local storage
          if (import.meta.client) {
            localStorage.setItem('orders', JSON.stringify(this.orders));
          }
        }

        return response;
      } catch (error) {
        console.error("Error updating order status:", error);
        throw error;
      }
    }
  }
});
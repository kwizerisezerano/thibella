export default defineNuxtConfig({  

  ssr: false,
  nitro: {
    preset: 'static',
    prerender: {failOnError: false }

  },  
    runtimeConfig: {
      public: {
        // API_URL: process.env.BASE_URL,
        baseUrl: process.env.NUXT_PUBLIC_BASE_URL || 'http://localhost:8080'
      },
    },
    components: true,
    css: ['@/assets/css/tailwind.css'],

    vite: {
      css: {
        postcss: {
          plugins: [require('tailwindcss'), require('autoprefixer')],
        },
      },
    },

    app: {
      head: {
        title: 'thibella.com',
        meta: [{ name: 'description', content: 'A Nuxt 3 project using Options API' }],
        link: [
          { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
          { rel: 'icon', type: 'image/png', sizes: '16x16', href: '/favicon-16x16.png' },
          { rel: 'icon', type: 'image/png', sizes: '32x32', href: '/favicon-32x32.png' },
          { rel: 'apple-touch-icon', sizes: '180x180', href: '/apple-touch-icon.png' },
        ],
      },
      baseURL: '/'
    },

    modules: [
      '@nuxtjs/i18n',
      'nuxt-icon',
      "@pinia/nuxt",
    ],
    
    imports: {
      dirs: ["stores"], // Auto-import stores
    },

    i18n: {
      locales: [
        {
          code: 'en',
          file: 'en.json'
        },
        {
          code: 'rw',
          file: 'rw.json'
        }
      ],
      lazy: true,
      langDir: 'lang',
      defaultLocale: 'rw',
      strategy: 'no_prefix'
    },

    compatibilityDate: '2025-02-09',

    devtools: {
      enabled: true
    },
    typescript: {
      strict: false
    },
    
  })

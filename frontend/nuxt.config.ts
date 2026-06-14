export default defineNuxtConfig({  

  ssr: false,
  loading: false,
  nitro: {
    preset: process.env.NODE_ENV === 'production' ? 'static' : undefined,
    prerender: { failOnError: false }
  },  
    runtimeConfig: {
      public: {
        // API_URL: process.env.BASE_URL,
        baseUrl: process.env.NUXT_PUBLIC_BASE_URL || 'http://localhost/thibella/backend/api'
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
        style: [
          {
            children: `
              #thibella-splash {
                position: fixed; inset: 0; z-index: 99999;
                display: flex; flex-direction: column;
                align-items: center; justify-content: center;
                background: #fff; transition: opacity 0.3s ease;
              }
              #thibella-splash svg text { fill: #059669; }
              #thibella-splash .dots { display: flex; gap: 8px; margin-top: 24px; }
              #thibella-splash .dot {
                width: 10px; height: 10px; border-radius: 50%;
                background: #10B981; animation: tb-bounce 0.6s infinite alternate;
              }
              #thibella-splash .dot:nth-child(2) { animation-delay: 0.15s; }
              #thibella-splash .dot:nth-child(3) { animation-delay: 0.3s; }
              @keyframes tb-bounce { from { transform: translateY(0); } to { transform: translateY(-10px); } }
            `
          }
        ],
        script: [
          {
            children: `
              (function() {
                var el = document.createElement('div');
                el.id = 'thibella-splash';
                el.innerHTML = '<svg viewBox="0 0 500 110" xmlns="http://www.w3.org/2000/svg" style="height:64px;width:auto"><text x="60" y="95" font-family="Georgia,serif" font-size="64" font-weight="700" letter-spacing="2" fill="#059669" font-style="italic">Thibella</text><path d="M 60 105 Q 130 108, 200 105 T 340 105" stroke="#10B981" stroke-width="2.5" fill="none" stroke-linecap="round"/></svg><div class="dots"><div class="dot"></div><div class="dot"></div><div class="dot"></div></div>';
                document.addEventListener('DOMContentLoaded', function() {
                  document.body.appendChild(el);
                  window.__removeSplash = function() {
                    el.style.opacity = '0';
                    setTimeout(function() { el.remove(); }, 300);
                  };
                });
              })();
            `,
            tagPosition: 'head'
          }
        ]
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
        { code: 'en', file: 'en.json' },
        { code: 'rw', file: 'rw.json' },
        { code: 'fr', file: 'fr.json' }
      ],
      lazy: true,
      langDir: 'lang',
      defaultLocale: 'rw',
      strategy: 'no_prefix'
    },

    compatibilityDate: '2025-02-09',

    devtools: {
      enabled: false
    },
    typescript: {
      strict: false
    },
    
  })

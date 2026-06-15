module.exports = {
  darkMode: 'class',
  content: [
    './app.vue',
    './pages/**/*.{vue,js,ts}',
    './components/**/*.{vue,js,ts}',
    './layouts/**/*.{vue,js,ts}',
    './composables/**/*.{js,ts}',
    './stores/**/*.{js,ts}',
    './plugins/**/*.{js,ts}',
    './node_modules/flowbite/**/*.js'
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('flowbite/plugin'),
  ],
}

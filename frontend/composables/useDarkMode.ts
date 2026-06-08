import { watch, onMounted } from 'vue'

export const useDarkMode = () => {
  const isDark = useState<boolean>('darkMode', () => {
    if (import.meta.client) {
      const saved = localStorage.getItem('theme')
      if (saved) {
        return saved === 'dark'
      }
      // If no saved preference, check system preference
      return window.matchMedia('(prefers-color-scheme: dark)').matches
    }
    return false
  })

  const toggleDarkMode = (): void => {
    isDark.value = !isDark.value
    if (import.meta.client) {
      if (isDark.value) {
        document.documentElement.classList.add('dark')
        localStorage.setItem('theme', 'dark')
      } else {
        document.documentElement.classList.remove('dark')
        localStorage.setItem('theme', 'light')
      }
    }
  }

  // Apply dark mode class on mount and watch for changes
  if (import.meta.client) {
    onMounted(() => {
      // Apply the current state to the DOM
      if (isDark.value) {
        document.documentElement.classList.add('dark')
      } else {
        document.documentElement.classList.remove('dark')
      }
    })

    // Watch for changes and update DOM
    watch(isDark, (newValue) => {
      if (newValue) {
        document.documentElement.classList.add('dark')
        localStorage.setItem('theme', 'dark')
      } else {
        document.documentElement.classList.remove('dark')
        localStorage.setItem('theme', 'light')
      }
    })
  }

  return {
    isDark,
    toggleDarkMode
  }
}
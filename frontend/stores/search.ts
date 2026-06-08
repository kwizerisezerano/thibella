// stores/search.ts
import { defineStore } from 'pinia'

export const useSearchStore = defineStore('search', () => {
  const query = ref('')
  const suggestions = ref<string[]>([])
  const showSuggestions = ref(false)

  function setQuery(searchQuery: string) {
    query.value = searchQuery
  }

  function setSuggestions(items: string[]) {
    suggestions.value = items
  }

  function clearSuggestions() {
    suggestions.value = []
    showSuggestions.value = false
  }

  return { query, setQuery, suggestions, setSuggestions, showSuggestions, clearSuggestions }
})
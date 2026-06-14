<template>
  <div v-if="loading" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-white dark:bg-gray-900">
    <svg viewBox="0 0 500 110" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto mb-6">
      <text x="110" y="95" font-family="Georgia, serif" font-size="64" font-weight="700" letter-spacing="2" fill="#059669" font-style="italic">
        Thibella
      </text>
      <path d="M 110 105 Q 180 108, 250 105 T 390 105" stroke="#10B981" stroke-width="2.5" fill="none" opacity="0.8" stroke-linecap="round"/>
      <circle cx="395" cy="105" r="3" fill="#10B981"/>
      <circle cx="405" cy="105" r="2" fill="#34D399" opacity="0.7"/>
    </svg>
    <div class="flex gap-2">
      <span v-for="i in 3" :key="i"
        class="w-2.5 h-2.5 rounded-full bg-green-500 animate-bounce"
        :style="{ animationDelay: `${(i - 1) * 0.15}s` }"
      />
    </div>
  </div>
</template>

<script setup>
const loading = ref(true)
onMounted(() => {
  loading.value = false
})
</script>

<template>
  <TransitionRoot as="template" :show="modelValue">
    <Dialog as="div" class="relative z-[1000]" :initialFocus="cancelButtonRef" @close="cancel">
      <TransitionChild
        as="template"
        enter="ease-out duration-200"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-150"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black/50 backdrop-blur-[1px]" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 sm:p-6">
          <TransitionChild
            as="template"
            enter="ease-out duration-200"
            enter-from="opacity-0 translate-y-2 sm:translate-y-0 sm:scale-95"
            enter-to="opacity-100 translate-y-0 sm:scale-100"
            leave="ease-in duration-150"
            leave-from="opacity-100 translate-y-0 sm:scale-100"
            leave-to="opacity-0 translate-y-2 sm:translate-y-0 sm:scale-95"
          >
            <DialogPanel
              class="w-full max-w-md overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5 dark:bg-gray-800 dark:ring-white/10"
            >
              <div class="p-6">
                <div class="flex items-start gap-4">
                  <div :class="iconWrapClass" class="flex h-10 w-10 flex-none items-center justify-center rounded-full">
                    <component :is="iconComponent" :class="iconClass" class="h-6 w-6" />
                  </div>

                  <div class="min-w-0 flex-1">
                    <DialogTitle class="text-base font-semibold text-gray-900 dark:text-white">
                      {{ title }}
                    </DialogTitle>
                    <div v-if="message" class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                      {{ message }}
                    </div>
                    <div v-if="$slots.default" class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                      <slot />
                    </div>
                  </div>
                </div>
              </div>

              <div class="flex items-center justify-end gap-3 bg-gray-50 px-6 py-4 dark:bg-gray-900/30">
                <button
                  ref="cancelButtonRef"
                  type="button"
                  class="inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition-colors hover:bg-gray-50 disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700"
                  :disabled="loading"
                  @click="cancel"
                >
                  {{ cancelText }}
                </button>

                <button
                  type="button"
                  :class="confirmButtonClass"
                  class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-semibold text-white shadow-sm transition-colors disabled:opacity-50"
                  :disabled="loading"
                  @click="confirm"
                >
                  <svg v-if="loading" class="-ml-0.5 mr-2 h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                  </svg>
                  {{ confirmText }}
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { computed, ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon, InformationCircleIcon } from '@heroicons/vue/24/outline'

const props = defineProps({
  modelValue: { type: Boolean, default: false },
  title: { type: String, default: 'Are you sure?' },
  message: { type: String, default: '' },
  confirmText: { type: String, default: 'Confirm' },
  cancelText: { type: String, default: 'Cancel' },
  tone: { type: String, default: 'danger' },
  loading: { type: Boolean, default: false },
})

const emit = defineEmits(['update:modelValue', 'confirm', 'cancel'])

const cancelButtonRef = ref(null)

const iconComponent = computed(() => (props.tone === 'danger' ? ExclamationTriangleIcon : InformationCircleIcon))
const iconWrapClass = computed(() =>
  props.tone === 'danger' ? 'bg-red-50 dark:bg-red-900/30' : 'bg-green-50 dark:bg-green-900/30'
)
const iconClass = computed(() => (props.tone === 'danger' ? 'text-red-600 dark:text-red-300' : 'text-green-600 dark:text-green-300'))

const confirmButtonClass = computed(() => {
  if (props.tone === 'danger') return 'bg-red-600 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-500'
  return 'bg-green-600 hover:bg-green-700 dark:bg-green-600 dark:hover:bg-green-500'
})

const close = () => emit('update:modelValue', false)

const cancel = () => {
  if (props.loading) return
  emit('cancel')
  close()
}

const confirm = () => {
  if (props.loading) return
  emit('confirm')
}
</script>

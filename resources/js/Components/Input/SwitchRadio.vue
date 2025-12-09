<template>
  <button
    type="button"
    role="switch"
    :aria-checked="modelValue"
    @click="toggle"
    :class="[
      'w-12 h-6 flex items-center rounded-full p-1 transition-colors duration-300',
      modelValue ? 'bg-green-500' : 'bg-gray-300'
    ]"
  >
    <div
      :class="[
        'bg-white w-4 h-4 rounded-full shadow-md transform transition duration-300',
        modelValue ? 'translate-x-6' : 'translate-x-0'
      ]"
    ></div>
  </button>
</template>

<script setup>
const props = defineProps({
  modelValue: {
    type: Boolean,
    required: true,
  }
})

const emit = defineEmits(['update:modelValue'])

function toggle() {
  emit('update:modelValue', !props.modelValue)
}
</script>
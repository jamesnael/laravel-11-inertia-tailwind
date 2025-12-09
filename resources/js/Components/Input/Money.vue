<template>
  <div class="relative">
    <span class="absolute left-3 top-2 text-gray-500">Rp</span>
    <input
      type="text"
      :value="modelValue"
      @input="handleInput"
      @keydown="handleKeydown"
      class="w-full pl-10"
      :class="class"
      :style="style"
      :readonly="readonly"
      :placeholder="placeholder"
      :disabled="disabled"
    />
  </div>
</template>

<script>
import { onMounted, watch, nextTick } from "vue";
import { formatMoney } from '../../mixins';
export default {
  name: 'InputMoney',
  emits: ['update:modelValue'],
  props: {
    modelValue: {
      type: String || Number,
      default: ''
    },
    class: [String, Array, Object],
    style: [String, Array, Object],
    placeholder: String,
    readonly: Boolean,
    disabled: Boolean
  },
  watch: {
    modelValue: {
      immediate: true,
      handler(val) {
        if (val !== '') {
          const numericValue = String(val).replace(/\D/g, '');
          this.$emit('update:modelValue', formatMoney(numericValue));
        }
      }
    }
  },
  methods: {
    handleKeydown(event) {
      if ([
        'Backspace', 'Delete', 'Tab', 'Escape', 'Enter',
        'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown',
        'Home', 'End'
      ].includes(event.key)) {
        return;
      }
      
      if ((event.ctrlKey || event.metaKey) && ['c', 'v', 'a', 'x'].includes(event.key.toLowerCase())) {
        return;
      }

      if (!/\d/.test(event.key)) {
        event.preventDefault();
      }
    },
    handleInput(event) {
      const input = event.target;

      const digitsBeforeCursor = input.value.slice(0, input.selectionStart).replace(/\D/g, '').length;

      let rawValue = input.value.replace(/\D/g, '');

      if (!rawValue) {
        this.$emit('update:modelValue', '');
        return;
      }

      if (rawValue.length > 1 && rawValue.startsWith('0')) {
        rawValue = rawValue.replace(/^0+/, '');
      }

      const formattedValue = formatMoney(rawValue);

      this.$emit('update:modelValue', formattedValue);

      nextTick(() => {
        let newCursorPos = 0;
        let digitsSeen = 0;
        while (newCursorPos < formattedValue.length && digitsSeen < digitsBeforeCursor) {
          if (/\d/.test(formattedValue[newCursorPos])) {
            digitsSeen++;
          }
          newCursorPos++;
        }

        if (!digitsBeforeCursor) {
          newCursorPos = formattedValue.length;
        }
        input.selectionStart = input.selectionEnd = newCursorPos;
      });
    }
  }
}
</script>
<template>
  <div class="relative">
    <span class="absolute left-3 top-[10px] text-gray-500 text-[1rem]">+62</span>
    <input
      type="text"
      :value="computedValue"
      @input="handleInput"
      class="w-full pl-12"
      :class="class"
      :style="style"
      :readonly="readonly"
      :placeholder="placeholder"
      :disabled="disabled"
    />
  </div>
</template>

<script>
export default {
  name: 'InputPhoneNumber',
  emits: ['update:modelValue'],
  props: {
    modelValue: {
      type: String,
      default: ''
    },
    class: [String, Array, Object],
    style: [String, Array, Object],
    placeholder: String,
    readonly: Boolean,
    disabled: Boolean
  },
  computed: {
    computedValue() {
      // Hapus prefix +62 untuk ditampilkan ke user
      return _.replace(this.modelValue, '+62', '');
    }
  },
  methods: {
    handleInput(event) {
      // Ambil hanya digit, maksimal 14 digit
      let value = event.target.value.replace(/\D/g, '').slice(0, 13);

      // Update nilai input DOM agar tetap sinkron
      event.target.value = value;

      // Emit nilai yang digabungkan dengan +62
      this.$emit('update:modelValue', value ? '+62' + value : '');
    }
  }
}
</script>
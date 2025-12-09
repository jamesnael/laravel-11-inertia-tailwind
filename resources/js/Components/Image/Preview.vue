<template>
  <img v-if="src" :src="src" class="w-40 h-auto cursor-pointer" @click="show = !show">

  <teleport to="body">
    <div v-show="show" class="fixed inset-0 z-50 px-0 py-10 sm:px-32 overflow-y-auto max-h-screen min-h-screen">
      <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm" @click="show = !show"></div>

      <!-- Image Preview -->
      <div class="relative z-10 flex justify-center items-center min-h-[89vh] max-h-[89vh]" @click="show = !show">
        <img :src="src" class="max-w-full max-h-[89vh] transform transition-all cursor-pointer">
      </div>
    </div>
  </teleport>
</template>

<script>
import { ref, watch, onMounted, onUnmounted } from 'vue'

export default {
  name: 'PreviewImage',
  props: {
    src: {
      type: String,
      default: ''
    }
  },
  setup(props) {
    const show = ref(false)

    const close = () => {
      show.value = false
    }

    const closeOnEscape = (e) => {
      if (e.key === 'Escape' && show.value) {
        close()
      }
    }

    watch(show, (value) => {
      console.log(value);
      document.body.style.overflow = value ? 'hidden' : ''
    });

    onMounted(() => {
      document.addEventListener('keydown', closeOnEscape)
    })
    onUnmounted(() => {
      document.removeEventListener('keydown', closeOnEscape)
      document.body.style.overflow = ''
    })

    return {
      show,
      close,
    }
  }
}
</script>

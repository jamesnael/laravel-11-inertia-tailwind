<template>
  <div class="relative w-full rounded-md border border-gray-500 flex items-center gap-x-3 px-3 transition-all duration-300 focus-within:border-indigo-500 focus-within:ring-2 focus-within:ring-indigo-500/30">
    
    <!-- Color Preview: Added flex-shrink-0 to prevent resizing -->
    <div class="w-9 h-9 rounded-lg border border-slate-300 shadow-sm flex-shrink-0" :style="{ backgroundColor: modelValue }"></div>

    <!-- Hex Code Display: Used flex-grow to fill available space -->
    <input
      type="text"
      :value="modelValue"
      @input="updateColor($event.target.value)"
      class="flex-grow text-center font-mono text-slate-800 py-[7px] text-lg bg-transparent outline-none p-2 border-none"
      aria-label="Hex Color Code"
      maxlength="7"
    />

    <!-- Icon & Hidden Input: Wrapped in a label, with flex-shrink-0 -->
    <label class="cursor-pointer flex-shrink-0">
      <div class="w-9 h-9 rounded-lg flex items-center justify-center bg-slate-100 hover:bg-slate-200 active:bg-slate-300 transition-colors">
        <svg fill="#919191" height="18" width="18" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512.002 512.002" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M512,89.938c0-24.023-9.356-46.61-26.343-63.595C468.671,9.356,446.086,0,422.062,0c-24.022,0-46.608,9.356-63.595,26.343 L214.668,170.141l-13.504-13.504c-9.573-9.573-25.097-9.573-34.672,0c-9.575,9.573-9.575,25.097,0,34.672l26.354,26.354 l-159.23,159.23c-11.013,11.013-17.079,25.656-17.079,41.231c0,11.82,3.501,23.1,10,32.668L7.182,470.148 c-9.575,9.573-9.575,25.097,0,34.672c4.787,4.787,11.062,7.182,17.335,7.182c6.273,0,12.549-2.394,17.335-7.182l19.355-19.355 c9.568,6.499,20.848,10,32.668,10c15.573,0,30.216-6.065,41.231-17.079l159.23-159.23l26.354,26.354 c4.787,4.787,11.062,7.182,17.335,7.182s12.549-2.394,17.335-7.182c9.575-9.573,9.575-25.097,0-34.672l-13.504-13.504 l143.799-143.799C502.646,136.547,512,113.962,512,89.938z M100.435,443.714c-2.363,2.363-5.124,2.716-6.559,2.716 c-1.437,0-4.196-0.353-6.561-2.716l-19.027-19.03c-2.363-2.363-2.716-5.124-2.716-6.561c0-1.435,0.353-4.194,2.716-6.559 l70.754-70.754l32.148,32.147L100.435,443.714z M205.863,338.286l-32.148-32.147l53.803-53.803l32.148,32.148L205.863,338.286z M450.986,118.863L307.187,262.662l-57.849-57.849l143.8-143.799c7.728-7.726,17.999-11.981,28.924-11.981 s21.197,4.255,28.924,11.981c7.726,7.726,11.981,17.999,11.981,28.924C462.966,100.863,458.712,111.136,450.986,118.863z"></path> </g> </g> </g></svg>
      </div>
      <input
        type="color"
        :value="modelValue"
        @input="updateColor($event.target.value)"
        class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer"
        aria-label="Select Color"
      />
    </label>
  </div>
</template>

<script>
  export default {
    name: 'ColorPicker',
    props: {
      modelValue: {
        type: String,
        default: '#000000'
      }
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
      // Function to emit the update event
      const updateColor = (color) => {
        // Allow partial hex codes during typing
        if (color.startsWith('#')) {
            emit('update:modelValue', color);
        }
      };

      return {
        updateColor
      };
    }
  }
</script>
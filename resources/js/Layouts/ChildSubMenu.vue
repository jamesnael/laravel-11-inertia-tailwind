<template>
          <div>
              <a v-if="hasAccess(submenu.access, $page.props.currentUser.jabatan.hak_akses)" href="javascript:;" :class="{ 'ml-3 h-12 flex items-center pl-5 mb-1 relative rounded-full': true, 'text-white': submenu.active, 'text-gray-300 hover:bg-dark-2 hover:text-gray-200': !submenu.active }" @click.prevent="openSubMenu = !openSubMenu">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-2 h-2" viewBox="0 0 16 16">
                  <circle cx="8" cy="8" r="8"/>
                </svg>
                <div class="w-full ml-3 flex items-center">
                    {{ submenu.text }} 
                    <transition-rotate v-if="openSubMenu" from="180" to="0" class="ml-auto mr-5 transform rotate-180">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 transform rotate-180" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                      </svg>
                    </transition-rotate>
                    <transition-rotate v-else from="0" to="180" class="ml-auto mr-5">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                      </svg>
                    </transition-rotate>
                </div>
            </a>

              <TransitionSlide :show="openSubMenu">
                <ul class="rounded-md bg-dark-2 ml-7">
                    <li v-for="subsubmenu in submenu.children">
                        <Link v-if="hasAccess(subsubmenu.access, $page.props.currentUser.jabatan.hak_akses)" :href="subsubmenu.route === '#' ? '#' : route(subsubmenu.route)" :class="{ 'h-12 flex items-center pl-5 mb-1 relative rounded-full': true, 'text-white': subsubmenu.active, 'text-gray-300': !subsubmenu.active }">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <div class="w-full ml-3 flex items-center"> {{ subsubmenu.text }} </div>
                        </Link>
                    </li>
                </ul>
              </TransitionSlide>
          </div>
</template>

<script>
  import { ref, onMounted } from "vue";
  import { usePage, Link } from '@inertiajs/inertia-vue3';
  import TransitionSlide from "@/Transitions/Slide.vue";
  import TransitionRotate from "@/Transitions/Rotate.vue";

  export default {
    name: 'ChildSubMenu',
    components: {
      Link,
      TransitionSlide,
      TransitionRotate
    },
    props: {
      submenu: {
        type: Object,
      }
    },
    setup(props) {
      let openSubMenu = ref(false)

      function scopedHeaderSlotName(uniqid) {
        return 'icon-menu-' + uniqid
      }
      onMounted(() => { openSubMenu.value = props.submenu.open })

      return {
        openSubMenu,
        scopedHeaderSlotName,
      }
    }
  }
</script>
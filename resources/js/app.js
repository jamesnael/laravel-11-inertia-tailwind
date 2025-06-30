import './bootstrap'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { formatMoney, hasAccess, lang, formatDate } from './mixins';
import Multiselect from 'vue-multiselect'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const mixins = {
    methods: {
        route,
        formatMoney,
        hasAccess,
        lang,
        formatDate,
    },
    components: {
        Multiselect,
    }
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
      const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})
      return pages[`./Pages/${name}.vue`]
    },
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props)})
            .use(plugin)
            .mixin(mixins)
            .mount(el);
    },
});

InertiaProgress.init({
    color: '#34D399',
    showSpinner: true,
});

import '../css/app.css';
import './bootstrap';
import '@coreui/coreui/dist/css/coreui.min.css';
import "@fortawesome/fontawesome-free/css/all.min.css";

import {createInertiaApp} from '@inertiajs/vue3';
import CoreuiVue from '@coreui/vue'
// import CIcon from '@coreui/icons-vue'
import * as iconSet from '@coreui/icons'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers';
import {createApp, h} from 'vue';
import {ZiggyVue} from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({el, App, props, plugin}) {
        const app = createApp({render: () => h(App, props)});
        app.use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue)
            .use(CoreuiVue);

        Object.entries(iconSet).forEach(([key, component]) => {
            app.component(key, component);
        });

        app.mount(el);

        /*return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(CoreuiVue)
            // .component('CIcon', CIcon)

            .mount(el);*/
    },
    progress: {
        color: '#4B5563',
    },
});

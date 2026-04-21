import '../css/app.css';
import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import { MotionPlugin } from '@vueuse/motion';

const appName = import.meta.env.VITE_APP_NAME || 'Omar Mohammed Sultan';

createInertiaApp({
    title: (title) => (title ? `${title} — ${appName}` : appName),

    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin);
        app.use(ZiggyVue);
        app.use(MotionPlugin);

        // Global Inertia components available everywhere
        app.component('Head', Head);
        app.component('Link', Link);

        app.mount(el);
    },

    progress: {
        color: '#6366f1',
        showSpinner: false,
    },
});

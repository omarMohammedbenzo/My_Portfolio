import { usePage } from '@inertiajs/vue3';

export function useLocaleRoute() {
    const page = usePage();

    return function lroute(name, params = {}, absolute = false) {
        const locale = page.props.locale ?? 'en';
        const merged = (typeof params === 'object' && params !== null && !Array.isArray(params))
            ? { locale, ...params }
            : { locale };
        return route(name, merged, absolute);
    };
}

import { usePage } from '@inertiajs/vue3';

export function useTranslations() {
    const page = usePage();

    function t(key, replacements = {}) {
        const translations = page.props.translations ?? {};
        let text = key.split('.').reduce((obj, k) => obj?.[k], translations) ?? key;

        Object.entries(replacements).forEach(([k, v]) => {
            text = text.replaceAll(`:${k}`, v);
        });

        return text;
    }

    function locale() {
        return page.props.locale ?? 'en';
    }

    function isRtl() {
        return locale() === 'ar';
    }

    return { t, locale, isRtl };
}

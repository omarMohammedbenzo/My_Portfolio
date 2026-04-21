import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useSeo(options = {}) {
    const page = usePage();

    const siteName = computed(() => page.props.translations?.['site_name'] ?? 'Omar Mohammed Sultan');

    const meta = computed(() => ({
        title:       options.title ?? siteName.value,
        description: options.description ?? page.props.translations?.['site_description'] ?? '',
        ogTitle:     options.ogTitle ?? options.title ?? siteName.value,
        ogDescription: options.ogDescription ?? options.description ?? '',
        ogImage:     options.ogImage ?? '/og-image.png',
        canonical:   options.canonical ?? (typeof window !== 'undefined' ? window.location.href : ''),
    }));

    return { meta };
}

<script setup>
import { useTranslations } from '@/composables/useTranslations';

const props = defineProps({
    educations: Array,
});

const { locale } = useTranslations();
const loc        = locale();
function tr(obj) { return obj?.[loc] || obj?.en || ''; }

function formatYear(date) {
    if (!date) return '';
    return new Date(date).getFullYear();
}
</script>

<template>
    <section id="education" class="py-24" style="background: var(--color-background);">
        <div class="mx-auto max-w-4xl px-4">

            <!-- Header -->
            <div class="mb-14 text-center">
                <p class="eyebrow mb-3">Where I Studied</p>
                <h2 class="text-3xl font-bold text-foreground sm:text-4xl">Education</h2>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div
                    v-for="(edu, idx) in educations"
                    :key="edu.id"
                    v-motion
                    :initial="{ opacity: 0, y: 30 }"
                    :visibleOnce="{ opacity: 1, y: 0, transition: { duration: 500, delay: idx * 100 } }"
                    class="glass-card p-6 glow-on-hover"
                >
                    <!-- School + years -->
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-xl"
                            :style="{ background: 'rgba(var(--color-accent-primary-rgb), 0.15)' }">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                :style="{ color: 'var(--color-accent-primary)' }">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 14l6.16-3.42A12.083 12.083 0 0118.75 19.5H5.25a12.083 12.083 0 01.59-8.92L12 14z"/>
                            </svg>
                        </div>
                        <span class="text-xs text-muted-foreground shrink-0">
                            {{ formatYear(edu.start_date) }}–{{ formatYear(edu.end_date) }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <h3 class="font-bold text-foreground">{{ edu.school }}</h3>
                        <p class="mt-1 text-sm gradient-text font-semibold">{{ tr(edu.degree) }}</p>
                        <p class="mt-0.5 text-sm text-muted-foreground">{{ tr(edu.field) }}</p>
                        <p v-if="edu.location" class="mt-1 text-xs text-muted-foreground">📍 {{ tr(edu.location) }}</p>
                        <p v-if="edu.gpa" class="mt-1 text-xs text-muted-foreground">GPA: {{ edu.gpa }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

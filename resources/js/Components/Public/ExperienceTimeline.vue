<script setup>
import { ref, computed } from 'vue';
import { useTranslations } from '@/composables/useTranslations';

const props = defineProps({
    experiences: Array,
});

const { locale } = useTranslations();
const loc        = locale();
function tr(obj) { return obj?.[loc] || obj?.en || ''; }

const expanded = ref({});
function toggleExpand(id) {
    expanded.value[id] = !expanded.value[id];
}

function formatDate(date) {
    if (!date) return '';
    return new Date(date).toLocaleDateString(loc === 'ar' ? 'ar-EG' : 'en-US', {
        month: 'short', year: 'numeric',
    });
}

function dateRange(exp) {
    const start = formatDate(exp.start_date);
    const end   = exp.is_current
        ? (loc === 'ar' ? 'حتى الآن' : 'Present')
        : formatDate(exp.end_date);
    return `${start} – ${end}`;
}

const typeLabels = {
    'full-time':  { en: 'Full-time',  ar: 'دوام كامل' },
    'part-time':  { en: 'Part-time',  ar: 'دوام جزئي' },
    'freelance':  { en: 'Freelance',  ar: 'مستقل' },
    'internship': { en: 'Internship', ar: 'تدريب' },
    'contract':   { en: 'Contract',   ar: 'عقد' },
};
function empLabel(type) { return typeLabels[type]?.[loc] ?? type; }
</script>

<template>
    <section id="experience" class="py-24" style="background: var(--color-bg-elevated, #12121a);">
        <div class="mx-auto max-w-4xl px-4">

            <!-- Header -->
            <div class="mb-14 text-center">
                <p class="eyebrow mb-3">Where I've Worked</p>
                <h2 class="text-3xl font-bold text-foreground sm:text-4xl">Experience</h2>
            </div>

            <!-- Timeline -->
            <div class="relative">
                <!-- Glowing spine -->
                <div
                    class="absolute start-5 top-0 bottom-0 w-0.5 md:start-1/2 md:-translate-x-0.5"
                    :style="{ background: `linear-gradient(to bottom, var(--color-accent-primary), var(--color-accent-secondary), transparent)` }"
                    aria-hidden="true"
                />

                <div class="space-y-10">
                    <div
                        v-for="(exp, idx) in experiences"
                        :key="exp.id"
                        v-motion
                        :initial="{ opacity: 0, x: idx % 2 === 0 ? -40 : 40 }"
                        :visibleOnce="{ opacity: 1, x: 0, transition: { duration: 550, delay: idx * 80 } }"
                        class="relative flex items-start gap-6 md:gap-0"
                        :class="idx % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'"
                    >
                        <!-- Node dot on spine -->
                        <div
                            class="timeline-node relative z-10 flex-shrink-0 h-3 w-3 rounded-full border-2 ms-3.5 mt-5 md:mx-auto md:ms-0"
                            :style="{
                                background:   'var(--color-accent-primary)',
                                borderColor:  'var(--color-accent-glow)',
                                animation: 'pulse-node 2s ease-in-out infinite',
                            }"
                            aria-hidden="true"
                        />

                        <!-- Card — takes 50% width on desktop, offset from center -->
                        <div
                            class="flex-1 glass-card p-6 glow-on-hover md:max-w-[calc(50%-2.5rem)]"
                            :class="idx % 2 === 0 ? 'md:ms-auto md:me-8' : 'md:me-auto md:ms-8'"
                        >
                            <!-- Company + date range -->
                            <div class="flex flex-wrap items-start justify-between gap-2 mb-3">
                                <div>
                                    <h3 class="text-base font-bold text-foreground">{{ exp.company }}</h3>
                                    <p class="text-sm gradient-text font-semibold">{{ tr(exp.role) }}</p>
                                </div>
                                <div class="flex flex-col items-end gap-1 text-end shrink-0">
                                    <span class="text-xs text-muted-foreground">{{ dateRange(exp) }}</span>
                                    <span
                                        v-if="exp.is_current"
                                        class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold text-white"
                                        :style="{ background: 'var(--color-accent-primary)' }"
                                    >Present</span>
                                </div>
                            </div>

                            <!-- Location + type -->
                            <div class="mb-3 flex flex-wrap gap-3 text-xs text-muted-foreground">
                                <span>📍 {{ tr(exp.location) }}</span>
                                <span>· {{ empLabel(exp.employment_type) }}</span>
                            </div>

                            <!-- Description (truncated + expand) -->
                            <div
                                class="html-content text-sm text-muted-foreground leading-relaxed overflow-hidden transition-all duration-300"
                                :class="expanded[exp.id] ? '' : 'line-clamp-3'"
                                v-html="tr(exp.description)"
                            />
                            <button
                                v-if="tr(exp.description).length > 200"
                                class="mt-2 text-xs font-medium transition-colors"
                                :style="{ color: 'var(--color-accent-primary)' }"
                                @click="toggleExpand(exp.id)"
                            >
                                {{ expanded[exp.id] ? (loc === 'ar' ? 'أقل' : 'Show less') : (loc === 'ar' ? 'المزيد' : 'Read more') }}
                            </button>

                            <!-- Tech stack chips -->
                            <div v-if="exp.tech_stack?.length" class="mt-4 flex flex-wrap gap-1.5">
                                <span
                                    v-for="tech in exp.tech_stack"
                                    :key="tech"
                                    class="rounded-full px-2.5 py-0.5 text-xs font-medium"
                                    style="background: rgba(var(--color-accent-primary-rgb), 0.12); color: var(--color-accent-primary);"
                                >{{ tech }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

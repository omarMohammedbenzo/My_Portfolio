<script setup>
import { Head, Link }     from '@inertiajs/vue3';
import { computed }        from 'vue';
import PublicLayout        from '@/Layouts/PublicLayout.vue';
import HeartButton         from '@/Components/HeartButton.vue';
import { useTranslations } from '@/composables/useTranslations';
import { useLocaleRoute }  from '@/composables/useLocaleRoute';

const props = defineProps({
    personalInfo: Object,
    experiences:  Array,
    educations:   Array,
    skills:       Array,
    settings:     Object,
});

const { t, locale } = useTranslations();
const loc    = locale();
const lroute = useLocaleRoute();
function tr(obj) { return obj?.[loc] || obj?.en || ''; }

const img1    = computed(() => props.settings?.about_image_1    ? `/${props.settings.about_image_1}`    : null);
const img2    = computed(() => props.settings?.about_image_2    ? `/${props.settings.about_image_2}`    : null);
const img1Alt = computed(() => props.settings?.about_image_1_alt || '');
const img2Alt = computed(() => props.settings?.about_image_2_alt || '');

const skillCategories = computed(() => {
    const map = {};
    for (const s of props.skills ?? []) {
        if (!map[s.category]) map[s.category] = [];
        map[s.category].push(s);
    }
    return map;
});

const categoryLabel = {
    backend:  t('skills.backend'),
    frontend: t('skills.frontend'),
    tools:    t('skills.tools'),
    other:    t('skills.other'),
};

function formatDate(dateStr) {
    if (!dateStr) return t('experience.present');
    const d = new Date(dateStr);
    return d.toLocaleDateString(loc === 'ar' ? 'ar-EG' : 'en-GB', { month: 'short', year: 'numeric' });
}
</script>

<template>
    <Head :title="t('nav.about')" />
    <PublicLayout>

        <!-- Intro -->
        <section class="py-20">
            <div class="mx-auto max-w-6xl px-4">
                <div class="grid items-center gap-12 md:grid-cols-2">

                    <!-- Text -->
                    <div
                        v-motion
                        :initial="{ opacity: 0, x: -30 }"
                        :enter="{ opacity: 1, x: 0, transition: { duration: 600 } }"
                    >
                        <p class="mb-3 text-sm font-medium text-primary">{{ t('about.label') }}</p>
                        <h1 class="text-4xl font-bold text-foreground">{{ t('about.title') }}</h1>
                        <div
                            class="mt-5 text-base text-muted-foreground leading-relaxed html-content"
                            v-html="tr(personalInfo?.summary)"
                        />
                        <div class="mt-6 flex flex-wrap gap-4 text-sm text-muted-foreground">
                            <span v-if="tr(personalInfo?.location)">📍 {{ tr(personalInfo?.location) }}</span>
                            <a v-if="personalInfo?.socials?.github"   :href="personalInfo.socials.github"   target="_blank" class="hover:text-foreground">GitHub ↗</a>
                            <a v-if="personalInfo?.socials?.linkedin" :href="personalInfo.socials.linkedin" target="_blank" class="hover:text-foreground">LinkedIn ↗</a>
                            <a v-if="personalInfo?.email"             :href="`mailto:${personalInfo.email}`"              class="hover:text-foreground">{{ personalInfo.email }}</a>
                        </div>
                        <div class="mt-6">
                            <a :href="lroute('cv.download')" target="_blank">
                                <button class="inline-flex items-center rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-primary-foreground hover:opacity-90 transition-opacity">
                                    {{ t('hero.download_cv') }}
                                </button>
                            </a>
                        </div>
                    </div>

                    <!-- Photos -->
                    <div class="grid grid-cols-2 gap-4"
                        v-motion
                        :initial="{ opacity: 0, x: 30 }"
                        :enter="{ opacity: 1, x: 0, transition: { duration: 600, delay: 150 } }"
                    >
                        <div class="rounded-2xl overflow-hidden aspect-3/4 shadow-lg">
                            <img v-if="img1" :src="img1" :alt="img1Alt" class="h-full w-full object-cover" />
                            <div v-else class="h-full w-full bg-linear-to-br from-violet-500 to-indigo-600" />
                        </div>
                        <div class="rounded-2xl overflow-hidden aspect-3/4 shadow-lg mt-8">
                            <img v-if="img2" :src="img2" :alt="img2Alt" class="h-full w-full object-cover" />
                            <div v-else class="h-full w-full bg-linear-to-br from-indigo-500 to-purple-600" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Skills -->
        <section class="py-20 bg-muted/30">
            <div class="mx-auto max-w-6xl px-4">
                <div class="mb-10 text-center">
                    <p class="mb-2 text-sm font-medium text-primary">{{ t('skills.label') }}</p>
                    <h2 class="text-3xl font-bold text-foreground">{{ t('skills.title') }}</h2>
                </div>

                <div class="space-y-10">
                    <div v-for="(items, cat) in skillCategories" :key="cat">
                        <h3 class="mb-4 text-xs font-semibold uppercase tracking-widest text-muted-foreground">
                            {{ categoryLabel[cat] ?? cat }}
                        </h3>
                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                            <div
                                v-for="skill in items"
                                :key="skill.id"
                                class="rounded-xl border border-border bg-card px-4 py-3 flex items-center justify-between gap-3"
                                v-motion
                                :initial="{ opacity: 0, y: 20 }"
                                :visible="{ opacity: 1, y: 0, transition: { duration: 400 } }"
                            >
                                <span class="text-sm font-medium text-foreground">{{ tr(skill.name) }}</span>
                                <div class="flex gap-0.5 shrink-0">
                                    <div
                                        v-for="n in 5"
                                        :key="n"
                                        :class="['h-1.5 w-4 rounded-full transition-colors', n <= skill.level ? 'bg-primary' : 'bg-muted']"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Experience -->
        <section class="py-20">
            <div class="mx-auto max-w-4xl px-4">
                <div class="mb-10 text-center">
                    <p class="mb-2 text-sm font-medium text-primary">{{ t('experience.label') }}</p>
                    <h2 class="text-3xl font-bold text-foreground">{{ t('experience.title') }}</h2>
                </div>

                <div class="relative">
                    <!-- Timeline line -->
                    <div class="absolute inset-s-6 top-0 bottom-0 w-px bg-border" />

                    <div class="space-y-8">
                        <div
                            v-for="exp in experiences"
                            :key="exp.id"
                            class="relative ps-16"
                            v-motion
                            :initial="{ opacity: 0, x: -20 }"
                            :visible="{ opacity: 1, x: 0, transition: { duration: 500 } }"
                        >
                            <!-- Dot -->
                            <div class="absolute inset-s-4 top-1.5 h-4 w-4 rounded-full border-2 border-primary bg-background" />

                            <div class="rounded-xl border border-border bg-card p-5">
                                <div class="flex flex-wrap items-start justify-between gap-2">
                                    <div>
                                        <h3 class="font-semibold text-foreground">{{ tr(exp.role) }}</h3>
                                        <p class="text-sm font-medium text-primary">{{ tr(exp.company) }}</p>
                                    </div>
                                    <p class="text-xs text-muted-foreground shrink-0">
                                        {{ formatDate(exp.start_date) }} – {{ formatDate(exp.end_date) }}
                                    </p>
                                </div>
                                <p v-if="tr(exp.location)" class="mt-1 text-xs text-muted-foreground">
                                    📍 {{ tr(exp.location) }}
                                </p>
                                <div
                                    v-if="tr(exp.description)"
                                    class="mt-3 text-sm text-muted-foreground leading-relaxed html-content"
                                    v-html="tr(exp.description)"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Education -->
        <section class="py-20 bg-muted/30">
            <div class="mx-auto max-w-4xl px-4">
                <div class="mb-10 text-center">
                    <p class="mb-2 text-sm font-medium text-primary">{{ t('education.label') }}</p>
                    <h2 class="text-3xl font-bold text-foreground">{{ t('education.title') }}</h2>
                </div>

                <div class="space-y-4">
                    <div
                        v-for="edu in educations"
                        :key="edu.id"
                        class="rounded-xl border border-border bg-card p-5"
                        v-motion
                        :initial="{ opacity: 0, y: 20 }"
                        :visible="{ opacity: 1, y: 0, transition: { duration: 400 } }"
                    >
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <div>
                                <h3 class="font-semibold text-foreground">{{ tr(edu.degree) }}</h3>
                                <p class="text-sm text-primary font-medium">{{ edu.school }}</p>
                                <p v-if="tr(edu.field)" class="text-sm text-muted-foreground">{{ tr(edu.field) }}</p>
                            </div>
                            <p class="text-xs text-muted-foreground shrink-0">
                                {{ formatDate(edu.start_date) }} – {{ formatDate(edu.end_date) }}
                            </p>
                        </div>
                        <div
                            v-if="tr(edu.description)"
                            class="mt-3 text-sm text-muted-foreground html-content"
                            v-html="tr(edu.description)"
                        />
                    </div>
                </div>
            </div>
        </section>

        <HeartButton />
    </PublicLayout>
</template>

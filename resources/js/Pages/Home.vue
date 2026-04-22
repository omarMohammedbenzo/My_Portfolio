<script setup>
import { Head, Link }           from '@inertiajs/vue3';
import { computed }              from 'vue';
import PublicLayout              from '@/Layouts/PublicLayout.vue';
import HeartButton               from '@/Components/HeartButton.vue';
import ScrollProgressBar         from '@/Components/Public/ScrollProgressBar.vue';
import HeroSection               from '@/Components/Public/HeroSection.vue';
import AboutBrief                from '@/Components/Public/AboutBrief.vue';
import SkillsGrid                from '@/Components/Public/SkillsGrid.vue';
import ExperienceTimeline        from '@/Components/Public/ExperienceTimeline.vue';
import EducationSection          from '@/Components/Public/EducationSection.vue';
import ContactCta                from '@/Components/Public/ContactCta.vue';
import { useTranslations }       from '@/composables/useTranslations';
import { useLocaleRoute }        from '@/composables/useLocaleRoute';

const props = defineProps({
    personalInfo:     Object,
    featuredProjects: Array,
    skills:           Object,
    experiences:      Array,
    educations:       Array,
    settings:         Object,
});

const { t, locale } = useTranslations();
const loc    = locale();
const lroute = useLocaleRoute();

function tr(obj) { return obj?.[loc] || obj?.en || ''; }

const gradientStyle = (p) => {
    const g = p.gradient_colors ?? {};
    const colorMap = {
        'from-violet-600': '#7c3aed', 'via-purple-600': '#9333ea', 'to-indigo-700': '#4338ca',
        'from-blue-600': '#2563eb', 'via-cyan-500': '#06b6d4', 'to-teal-600': '#0d9488',
        'from-emerald-500': '#10b981', 'via-green-500': '#22c55e', 'to-teal-600': '#0d9488',
        'from-rose-500': '#f43f5e', 'via-pink-500': '#ec4899', 'to-fuchsia-600': '#c026d3',
        'from-orange-500': '#f97316', 'via-amber-500': '#f59e0b', 'to-yellow-500': '#eab308',
        'from-slate-600': '#475569', 'via-gray-600': '#4b5563', 'to-zinc-700': '#3f3f46',
        'from-cyan-500': '#06b6d4', 'via-sky-500': '#0ea5e9', 'to-blue-600': '#2563eb',
    };
    return {
        background: `linear-gradient(135deg, ${colorMap[g.from] ?? '#7c3aed'}, ${colorMap[g.to] ?? '#4338ca'})`,
    };
};
</script>

<template>
    <Head :title="t('nav.home')" />
    <PublicLayout>
        <!-- Global scroll progress indicator -->
        <ScrollProgressBar />

        <!-- 1. Hero -->
        <HeroSection :personalInfo="personalInfo" :settings="settings" />

        <!-- 2. About Brief -->
        <AboutBrief :settings="settings" />

        <!-- 3. Skills & Tools -->
        <SkillsGrid :skills="skills" />

        <!-- 4. Experience Timeline -->
        <ExperienceTimeline :experiences="experiences" />

        <!-- 5. Education -->
        <EducationSection :educations="educations" />

        <!-- 6. Featured Projects -->
        <section v-if="featuredProjects?.length" id="projects" class="py-24" style="background: var(--color-bg-elevated, #12121a);">
            <div class="mx-auto max-w-6xl px-4">
                <div class="mb-12 text-center">
                    <p class="eyebrow mb-3">{{ t('projects.featured_label') }}</p>
                    <h2 class="text-3xl font-bold text-foreground sm:text-4xl">{{ t('projects.featured_title') }}</h2>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="(project, idx) in featuredProjects"
                        :key="project.id"
                        :href="lroute('projects.show', { slug: project.slug })"
                        v-motion
                        :initial="{ opacity: 0, y: 30 }"
                        :visibleOnce="{ opacity: 1, y: 0, transition: { duration: 500, delay: idx * 100 } }"
                        class="group glass-card overflow-hidden transition-all duration-300 hover:-translate-y-1"
                        style="border-radius: 1rem;"
                    >
                        <!-- Thumbnail -->
                        <div class="relative h-48 overflow-hidden rounded-t-2xl">
                            <img
                                v-if="project.cover_url"
                                :src="project.cover_url"
                                :alt="tr(project.title)"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            />
                            <div
                                v-else
                                class="h-full w-full flex items-center justify-center"
                                :style="gradientStyle(project)"
                            >
                                <span class="text-4xl font-bold text-white opacity-80">
                                    {{ tr(project.title)?.slice(0, 2).toUpperCase() }}
                                </span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-5">
                            <h3 class="font-semibold text-foreground transition-colors group-hover:text-(--color-accent-primary)">
                                {{ tr(project.title) }}
                            </h3>
                            <p class="mt-1.5 text-sm text-muted-foreground line-clamp-2">
                                {{ tr(project.description) }}
                            </p>
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                <span
                                    v-for="tech in (project.tech_stack ?? []).slice(0, 4)"
                                    :key="tech"
                                    class="rounded-full px-2.5 py-0.5 text-xs font-medium"
                                    style="background: rgba(var(--color-accent-primary-rgb), 0.12); color: var(--color-accent-primary);"
                                >{{ tech }}</span>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- View all CTA -->
                <div class="mt-10 text-center">
                    <Link
                        :href="lroute('projects.index')"
                        class="inline-flex items-center gap-2 rounded-xl border px-7 py-3 text-sm font-semibold text-foreground transition-all duration-200 hover:border-(--color-accent-primary) hover:text-(--color-accent-primary)"
                        style="border-color: rgba(255,255,255,0.15); background: rgba(255,255,255,0.04);"
                    >
                        {{ t('projects.view_all') }}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- 7. Contact CTA -->
        <ContactCta :personalInfo="personalInfo" :settings="settings" />

        <!-- Heart reaction button -->
        <HeartButton />
    </PublicLayout>
</template>

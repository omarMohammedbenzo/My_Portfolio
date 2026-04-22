<script setup>
import { Head, Link }         from '@inertiajs/vue3';
import { computed }            from 'vue';
import PublicLayout            from '@/Layouts/PublicLayout.vue';
import HeartButton             from '@/Components/HeartButton.vue';
import { useTranslations }     from '@/composables/useTranslations';

const props = defineProps({
    personalInfo:     Object,
    featuredProjects: Array,
    settings:         Object,
});

const { t, locale } = useTranslations();
const loc = locale();

function tr(obj) { return obj?.[loc] || obj?.en || ''; }

const heroImage    = computed(() => props.settings?.hero_image    ? `/${props.settings.hero_image}`    : null);
const heroImageAlt = computed(() => props.settings?.hero_image_alt || tr(props.personalInfo?.name));

const gradientStyle = (p) => {
    const g = p.gradient_colors ?? {};
    const from = g.from ?? 'violet-500';
    const to   = g.to   ?? 'indigo-600';
    const colorMap = {
        'violet-500': '#8b5cf6', 'purple-500': '#a855f7', 'indigo-600': '#4f46e5',
        'blue-500': '#3b82f6', 'cyan-500': '#06b6d4', 'emerald-500': '#10b981',
        'rose-500': '#f43f5e', 'orange-500': '#f97316', 'pink-500': '#ec4899',
    };
    return {
        background: `linear-gradient(135deg, ${colorMap[from] ?? '#8b5cf6'}, ${colorMap[to] ?? '#4f46e5'})`,
    };
};
</script>

<template>
    <Head :title="t('nav.home')" />
    <PublicLayout>

        <!-- Hero -->
        <section class="relative overflow-hidden py-20 md:py-32">
            <div class="mx-auto max-w-6xl px-4">
                <div class="grid items-center gap-12 md:grid-cols-2">

                    <!-- Text -->
                    <div
                        v-motion
                        :initial="{ opacity: 0, y: 40 }"
                        :enter="{ opacity: 1, y: 0, transition: { duration: 600 } }"
                    >
                        <p class="mb-3 text-sm font-medium text-primary">{{ t('hero.greeting') }}</p>
                        <h1 class="text-4xl font-bold leading-tight text-foreground md:text-5xl lg:text-6xl">
                            {{ tr(personalInfo?.name) }}
                        </h1>
                        <p class="mt-2 text-xl font-medium text-primary md:text-2xl">
                            {{ tr(personalInfo?.title) }}
                        </p>
                        <p class="mt-5 max-w-lg text-base text-muted-foreground leading-relaxed">
                            {{ tr(personalInfo?.summary) }}
                        </p>

                        <div class="mt-8 flex flex-wrap gap-3">
                            <Link :href="route('projects.index')">
                                <button class="inline-flex items-center rounded-lg bg-primary px-6 py-2.5 text-sm font-medium text-primary-foreground hover:opacity-90 transition-opacity">
                                    {{ t('hero.view_projects') }}
                                </button>
                            </Link>
                            <a :href="route('cv.download')" target="_blank">
                                <button class="inline-flex items-center rounded-lg border border-border bg-card px-6 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                                    {{ t('hero.download_cv') }}
                                </button>
                            </a>
                            <Link :href="route('contact')">
                                <button class="inline-flex items-center rounded-lg border border-border bg-card px-6 py-2.5 text-sm font-medium text-foreground hover:bg-muted transition-colors">
                                    {{ t('hero.contact_me') }}
                                </button>
                            </Link>
                        </div>

                        <!-- Social links -->
                        <div v-if="personalInfo?.socials" class="mt-6 flex gap-4">
                            <a
                                v-if="personalInfo.socials.github"
                                :href="personalInfo.socials.github"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-sm text-muted-foreground hover:text-foreground transition-colors"
                            >GitHub ↗</a>
                            <a
                                v-if="personalInfo.socials.linkedin"
                                :href="personalInfo.socials.linkedin"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-sm text-muted-foreground hover:text-foreground transition-colors"
                            >LinkedIn ↗</a>
                        </div>
                    </div>

                    <!-- Photo -->
                    <div
                        class="flex justify-center"
                        v-motion
                        :initial="{ opacity: 0, scale: 0.9 }"
                        :enter="{ opacity: 1, scale: 1, transition: { duration: 700, delay: 200 } }"
                    >
                        <div class="relative h-72 w-72 md:h-96 md:w-96">
                            <img
                                v-if="heroImage"
                                :src="heroImage"
                                :alt="heroImageAlt"
                                class="h-full w-full rounded-3xl object-cover shadow-2xl"
                            />
                            <div
                                v-else
                                class="h-full w-full rounded-3xl bg-gradient-to-br from-violet-500 to-indigo-600 shadow-2xl flex items-center justify-center"
                            >
                                <span class="text-6xl text-white font-bold">{{ tr(personalInfo?.name)?.charAt(0) }}</span>
                            </div>
                            <!-- Decorative ring -->
                            <div class="absolute -inset-3 rounded-3xl border-2 border-primary/20 -z-10" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Projects -->
        <section v-if="featuredProjects?.length" class="py-20 bg-muted/30">
            <div class="mx-auto max-w-6xl px-4">
                <div class="mb-10 flex items-end justify-between">
                    <div>
                        <p class="text-sm font-medium text-primary mb-1">{{ t('projects.featured_label') }}</p>
                        <h2 class="text-3xl font-bold text-foreground">{{ t('projects.featured_title') }}</h2>
                    </div>
                    <Link :href="route('projects.index')" class="text-sm text-muted-foreground hover:text-foreground transition-colors">
                        {{ t('projects.view_all') }} →
                    </Link>
                </div>

                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="project in featuredProjects"
                        :key="project.id"
                        :href="route('projects.show', project.slug)"
                        class="group rounded-2xl overflow-hidden border border-border bg-card hover:shadow-lg transition-shadow duration-300"
                    >
                        <!-- Thumbnail -->
                        <div class="relative h-48 overflow-hidden">
                            <img
                                v-if="project.cover_url"
                                :src="project.cover_url"
                                :alt="tr(project.title)"
                                class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
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
                            <h3 class="font-semibold text-foreground group-hover:text-primary transition-colors">
                                {{ tr(project.title) }}
                            </h3>
                            <p class="mt-1.5 text-sm text-muted-foreground line-clamp-2">
                                {{ tr(project.short_description) }}
                            </p>
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                <span
                                    v-for="tech in (project.tech_stack ?? []).slice(0, 4)"
                                    :key="tech"
                                    class="rounded-full bg-muted px-2.5 py-0.5 text-xs font-medium text-muted-foreground"
                                >{{ tech }}</span>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <HeartButton />
    </PublicLayout>
</template>

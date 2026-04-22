<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed }       from 'vue';
import PublicLayout            from '@/Layouts/PublicLayout.vue';
import HeartButton             from '@/Components/HeartButton.vue';
import { useTranslations }     from '@/composables/useTranslations';
import { useLocaleRoute }      from '@/composables/useLocaleRoute';

const props = defineProps({
    projects:   Array,
    activetech: String,
});

const { t, locale } = useTranslations();
const loc    = locale();
const lroute = useLocaleRoute();
function tr(obj) { return obj?.[loc] || obj?.en || ''; }

const allTech = computed(() => {
    const set = new Set();
    for (const p of props.projects ?? []) {
        for (const tech of p.tech_stack ?? []) set.add(tech);
    }
    return [...set].sort();
});

function filterBy(tech) {
    router.get(lroute('projects.index', tech ? { tech } : {}), {}, { preserveScroll: true });
}

const gradientStyle = (p) => {
    const g = p.gradient_colors ?? {};
    const colorMap = {
        'violet-500': '#8b5cf6', 'purple-500': '#a855f7', 'indigo-600': '#4f46e5',
        'blue-500': '#3b82f6', 'cyan-500': '#06b6d4', 'emerald-500': '#10b981',
        'rose-500': '#f43f5e', 'orange-500': '#f97316', 'pink-500': '#ec4899',
    };
    return {
        background: `linear-gradient(135deg, ${colorMap[g.from] ?? '#8b5cf6'}, ${colorMap[g.to] ?? '#4f46e5'})`,
    };
};
</script>

<template>
    <Head :title="t('nav.projects')" />
    <PublicLayout>

        <!-- Header -->
        <section class="py-16 text-center">
            <div class="mx-auto max-w-2xl px-4">
                <p class="mb-3 text-sm font-medium text-primary">{{ t('projects.label') }}</p>
                <h1 class="text-4xl font-bold text-foreground">{{ t('projects.title') }}</h1>
                <p class="mt-4 text-muted-foreground">{{ t('projects.subtitle') }}</p>
            </div>
        </section>

        <!-- Tech filter -->
        <div v-if="allTech.length" class="mx-auto max-w-6xl px-4 pb-6">
            <div class="flex flex-wrap gap-2">
                <button
                    class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors"
                    :class="!activetech ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground hover:text-foreground'"
                    @click="filterBy(null)"
                >{{ t('projects.all') }}</button>
                <button
                    v-for="tech in allTech"
                    :key="tech"
                    class="rounded-full px-4 py-1.5 text-sm font-medium transition-colors"
                    :class="activetech === tech ? 'bg-primary text-primary-foreground' : 'bg-muted text-muted-foreground hover:text-foreground'"
                    @click="filterBy(tech)"
                >{{ tech }}</button>
            </div>
        </div>

        <!-- Grid -->
        <section class="pb-24">
            <div class="mx-auto max-w-6xl px-4">
                <div v-if="projects?.length" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <Link
                        v-for="project in projects"
                        :key="project.id"
                        :href="lroute('projects.show', { slug: project.slug })"
                        class="group rounded-2xl overflow-hidden border border-border bg-card hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                        v-motion
                        :initial="{ opacity: 0, y: 30 }"
                        :visible="{ opacity: 1, y: 0, transition: { duration: 400 } }"
                    >
                        <!-- Thumbnail -->
                        <div class="relative h-52 overflow-hidden">
                            <img
                                v-if="project.cover_url"
                                :src="project.cover_url"
                                :alt="tr(project.title)"
                                class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500"
                            />
                            <div v-else class="h-full w-full flex items-center justify-center" :style="gradientStyle(project)">
                                <span class="text-5xl font-bold text-white/80">
                                    {{ tr(project.title)?.slice(0, 2).toUpperCase() }}
                                </span>
                            </div>
                            <!-- Links overlay -->
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100">
                                <span v-if="project.live_url" class="rounded-full bg-white/90 px-3 py-1 text-xs font-medium text-gray-900">Live ↗</span>
                                <span v-if="project.github_url" class="rounded-full bg-white/90 px-3 py-1 text-xs font-medium text-gray-900">GitHub ↗</span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-5">
                            <h2 class="font-semibold text-foreground group-hover:text-primary transition-colors">
                                {{ tr(project.title) }}
                            </h2>
                            <p class="mt-1.5 text-sm text-muted-foreground line-clamp-2">
                                {{ tr(project.short_description) }}
                            </p>
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                <span
                                    v-for="tech in (project.tech_stack ?? []).slice(0, 5)"
                                    :key="tech"
                                    class="rounded-full bg-muted px-2.5 py-0.5 text-xs font-medium text-muted-foreground"
                                >{{ tech }}</span>
                            </div>
                        </div>
                    </Link>
                </div>

                <div v-else class="py-20 text-center text-muted-foreground">
                    {{ t('projects.empty') }}
                </div>
            </div>
        </section>

        <HeartButton />
    </PublicLayout>
</template>

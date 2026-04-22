<script setup>
import { Head, Link }      from '@inertiajs/vue3';
import { ref }              from 'vue';
import PublicLayout         from '@/Layouts/PublicLayout.vue';
import HeartButton          from '@/Components/HeartButton.vue';
import { useTranslations }  from '@/composables/useTranslations';
import { useLocaleRoute }   from '@/composables/useLocaleRoute';

const props = defineProps({
    project:     Object,
    nextProject: Object,
});

const { t, locale } = useTranslations();
const loc    = locale();
const lroute = useLocaleRoute();
function tr(obj) { return obj?.[loc] || obj?.en || ''; }

const lightboxSrc = ref(null);

const gradientStyle = (p) => {
    const g = p?.gradient_colors ?? {};
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
    <Head :title="tr(project.title)" />
    <PublicLayout>

        <!-- Hero -->
        <section class="relative h-64 md:h-80 overflow-hidden">
            <img
                v-if="project.cover_url"
                :src="project.cover_url"
                :alt="tr(project.title)"
                class="h-full w-full object-cover"
            />
            <div v-else class="h-full w-full" :style="gradientStyle(project)" />
            <div class="absolute inset-0 bg-linear-to-t from-background/80 to-transparent" />

            <div class="absolute bottom-0 inset-s-0 inset-e-0 mx-auto max-w-4xl px-4 pb-8">
                <Link :href="lroute('projects.index')" class="text-xs text-white/70 hover:text-white mb-3 inline-block">
                    ← {{ t('projects.back') }}
                </Link>
                <h1 class="text-3xl md:text-4xl font-bold text-white">{{ tr(project.title) }}</h1>
            </div>
        </section>

        <!-- Content -->
        <section class="py-12">
            <div class="mx-auto max-w-4xl px-4">
                <div class="grid gap-10 lg:grid-cols-3">

                    <!-- Main content -->
                    <div class="lg:col-span-2">
                        <p class="text-muted-foreground leading-relaxed whitespace-pre-line">
                            {{ tr(project.description) || tr(project.short_description) }}
                        </p>

                        <!-- Gallery -->
                        <div v-if="project.images?.length" class="mt-10">
                            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-muted-foreground">
                                {{ t('projects.gallery') }}
                            </h3>
                            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                                <button
                                    v-for="img in project.images"
                                    :key="img.id"
                                    class="rounded-xl overflow-hidden aspect-video group"
                                    @click="lightboxSrc = img.url"
                                >
                                    <img
                                        :src="img.url"
                                        :alt="tr(img.caption)"
                                        class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    />
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <aside class="space-y-6">
                        <!-- Links -->
                        <div class="rounded-xl border border-border bg-card p-5 space-y-3">
                            <h3 class="text-sm font-semibold uppercase tracking-wider text-muted-foreground">Links</h3>
                            <a
                                v-if="project.live_url"
                                :href="project.live_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center gap-2 text-sm text-primary hover:underline"
                            >🌐 {{ t('projects.live_demo') }}</a>
                            <a
                                v-if="project.github_url"
                                :href="project.github_url"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center gap-2 text-sm text-primary hover:underline"
                            >⌥ GitHub</a>
                        </div>

                        <!-- Tech stack -->
                        <div v-if="project.tech_stack?.length" class="rounded-xl border border-border bg-card p-5">
                            <h3 class="mb-3 text-sm font-semibold uppercase tracking-wider text-muted-foreground">
                                {{ t('projects.tech_stack') }}
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    v-for="tech in project.tech_stack"
                                    :key="tech"
                                    class="rounded-full bg-muted px-3 py-1 text-xs font-medium text-muted-foreground"
                                >{{ tech }}</span>
                            </div>
                        </div>
                    </aside>
                </div>

                <!-- Next project -->
                <div v-if="nextProject" class="mt-16 border-t border-border pt-10">
                    <p class="mb-3 text-sm text-muted-foreground">{{ t('projects.next') }}</p>
                    <Link
                        :href="lroute('projects.show', { slug: nextProject.slug })"
                        class="group flex items-center justify-between rounded-2xl border border-border bg-card p-5 hover:shadow-md transition-shadow"
                    >
                        <div>
                            <h3 class="font-semibold text-foreground group-hover:text-primary transition-colors">
                                {{ tr(nextProject.title) }}
                            </h3>
                            <p class="mt-1 text-sm text-muted-foreground line-clamp-1">{{ tr(nextProject.short_description) }}</p>
                        </div>
                        <span class="text-muted-foreground group-hover:translate-x-1 transition-transform">→</span>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Lightbox -->
        <Teleport to="body">
            <div
                v-if="lightboxSrc"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                @click.self="lightboxSrc = null"
            >
                <button
                    class="absolute top-4 inset-e-4 text-white/70 hover:text-white text-2xl"
                    @click="lightboxSrc = null"
                >✕</button>
                <img :src="lightboxSrc" class="max-h-[90vh] max-w-full rounded-xl shadow-2xl" />
            </div>
        </Teleport>

        <HeartButton />
    </PublicLayout>
</template>

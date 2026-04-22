<script setup>
import { computed, onMounted, ref } from 'vue';
import { useTranslations }          from '@/composables/useTranslations';
import { useLocaleRoute }           from '@/composables/useLocaleRoute';
import { useTypewriter }            from '@/composables/useTypewriter';
import AnimatedWaves                from '@/Components/Public/AnimatedWaves.vue';
import Mascot                       from '@/Components/Public/Mascot.vue';

const props = defineProps({
    personalInfo: Object,
    settings:     Object,
});

const { locale }   = useTranslations();
const loc          = locale();
const lroute       = useLocaleRoute();

function tr(obj) { return obj?.[loc] || obj?.en || ''; }

// ── Editable settings with fallbacks ────────────────────────────────────
const eyebrow         = computed(() => tr(props.settings?.hero_eyebrow)     || "Hi, I'm Omar 👋");
const titleTemplate   = computed(() => tr(props.settings?.hero_title_template) || "I'm a {role}  Developer");
const rotatingTitles  = computed(() => {
    const t = props.settings?.hero_rotating_titles;
    return (t?.[loc] ?? t?.en ?? ['Full-Stack', 'Backend', 'Frontend', 'Vue.js']);
});
const tagline         = computed(() => tr(props.settings?.hero_tagline) || '');

// Build the title parts: "I'm a " + [role] + " Developer"
const templateParts = computed(() => {
    const tpl = titleTemplate.value;
    const idx = tpl.indexOf('{role}');
    if (idx === -1) return { before: tpl, after: '' };
    return { before: tpl.slice(0, idx), after: tpl.slice(idx + 6) };
});

// ── Typewriter ───────────────────────────────────────────────────────────
const { displayed: rotatingWord } = useTypewriter(rotatingTitles.value, 80, 40, 2200);

// ── Images ───────────────────────────────────────────────────────────────
const heroImage    = computed(() => props.settings?.hero_image    ? `/${props.settings.hero_image}`    : null);
const heroImageAlt = computed(() => tr(props.settings?.hero_image_alt) || tr(props.personalInfo?.name));

// ── Social ───────────────────────────────────────────────────────────────
const github   = computed(() => props.personalInfo?.socials?.github);
const linkedin = computed(() => props.personalInfo?.socials?.linkedin);
const email    = computed(() => props.personalInfo?.email);

// ── Scroll to section ────────────────────────────────────────────────────
function scrollTo(id) {
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth' });
}

// ── Reduced motion ───────────────────────────────────────────────────────
const reducedMotion = ref(false);
onMounted(() => {
    reducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
});
</script>

<template>
    <!-- ─── Hero wrapper ───────────────────────────────────────────────────── -->
    <section
        id="hero"
        class="relative min-h-screen flex flex-col overflow-hidden"
        style="background: var(--color-background);"
    >
        <!-- Animated gradient mesh background -->
        <div class="absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
            <!-- Blob 1 -->
            <div
                class="absolute rounded-full blur-3xl opacity-20"
                :style="{
                    width: '600px', height: '600px',
                    top: '-100px', left: '-100px',
                    background: `radial-gradient(circle, var(--color-accent-primary), transparent 70%)`,
                    animation: reducedMotion ? 'none' : 'drift-1 18s ease-in-out infinite',
                }"
            />
            <!-- Blob 2 -->
            <div
                class="absolute rounded-full blur-3xl opacity-15"
                :style="{
                    width: '500px', height: '500px',
                    top: '30%', right: '-80px',
                    background: `radial-gradient(circle, var(--color-accent-secondary), transparent 70%)`,
                    animation: reducedMotion ? 'none' : 'drift-2 22s ease-in-out infinite',
                }"
            />
            <!-- Blob 3 -->
            <div
                class="absolute rounded-full blur-3xl opacity-10"
                :style="{
                    width: '400px', height: '400px',
                    bottom: '10%', left: '40%',
                    background: `radial-gradient(circle, var(--color-accent-glow), transparent 70%)`,
                    animation: reducedMotion ? 'none' : 'drift-3 26s ease-in-out infinite',
                }"
            />
            <!-- Noise texture overlay -->
            <div class="noise-overlay absolute inset-0 opacity-[0.03]" />
        </div>

        <!-- Content -->
        <div class="relative z-10 mx-auto flex flex-1 w-full max-w-6xl items-center px-4 py-24">
            <div class="grid w-full items-center gap-12 lg:grid-cols-[1fr_auto]">

                <!-- ── Left: text ──────────────────────────────────────────── -->
                <div
                    v-motion
                    :initial="{ opacity: 0, y: 50 }"
                    :enter="{ opacity: 1, y: 0, transition: { duration: 700 } }"
                    class="max-w-2xl"
                >
                    <!-- Eyebrow -->
                    <p class="eyebrow mb-4 text-sm">{{ eyebrow }}</p>

                    <!-- Rotating headline -->
                    <h1 class="text-4xl font-extrabold leading-tight text-foreground sm:text-5xl lg:text-6xl">
                        {{ templateParts.before }}<span
                            class="gradient-text inline-block min-w-[2ch]"
                        >{{ rotatingWord }}</span>
                        <br>
                        {{ templateParts.after }}
                    </h1>

                    <!-- Tagline -->
                    <p v-if="tagline" class="mt-5 max-w-xl text-base leading-relaxed text-muted-foreground sm:text-lg">
                        {{ tagline }}
                    </p>

                    <!-- CTAs -->
                    <div class="mt-8 flex flex-wrap gap-3">
                        <button
                            class="inline-flex items-center rounded-xl px-7 py-3 text-sm font-semibold text-white transition-all duration-200 glow-on-hover"
                            :style="{ background: 'var(--color-accent-primary)' }"
                            @click="scrollTo('projects')"
                        >View My Work</button>
                        <a
                            :href="lroute('cv.download')"
                            target="_blank"
                            class="inline-flex items-center rounded-xl border px-7 py-3 text-sm font-semibold text-foreground transition-all duration-200 hover:border-[color:var(--color-accent-primary)] hover:text-[color:var(--color-accent-primary)]"
                            style="border-color: rgba(255,255,255,0.15); background: rgba(255,255,255,0.04);"
                        >Download CV</a>
                    </div>

                    <!-- Social icons -->
                    <div class="mt-6 flex items-center gap-5">
                        <a
                            v-if="github"
                            :href="github"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-muted-foreground transition-colors hover:text-[color:var(--color-accent-primary)]"
                            title="GitHub"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.44 9.8 8.2 11.38.6.11.82-.26.82-.58v-2.04c-3.34.73-4.04-1.61-4.04-1.61-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.73.08-.73 1.2.08 1.84 1.24 1.84 1.24 1.07 1.83 2.8 1.3 3.49 1 .11-.78.42-1.3.76-1.6-2.67-.3-5.47-1.33-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.14-.3-.54-1.52.12-3.18 0 0 1.01-.32 3.3 1.23a11.5 11.5 0 0 1 3-.4c1.02 0 2.04.13 3 .4 2.28-1.55 3.3-1.23 3.3-1.23.66 1.66.24 2.88.12 3.18.77.84 1.23 1.91 1.23 3.22 0 4.61-2.8 5.63-5.48 5.92.43.37.81 1.1.81 2.22v3.29c0 .32.22.7.83.58C20.56 21.8 24 17.3 24 12c0-6.63-5.37-12-12-12z"/></svg>
                        </a>
                        <a
                            v-if="linkedin"
                            :href="linkedin"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-muted-foreground transition-colors hover:text-[color:var(--color-accent-primary)]"
                            title="LinkedIn"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.03-3.04-1.85-3.04-1.85 0-2.13 1.45-2.13 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.45v6.29zM5.34 7.43a2.07 2.07 0 1 1 0-4.14 2.07 2.07 0 0 1 0 4.14zm1.78 13.02H3.56V9h3.56v11.45zM22.23 0H1.77C.79 0 0 .77 0 1.72v20.56C0 23.23.79 24 1.77 24h20.46c.98 0 1.77-.77 1.77-1.72V1.72C24 .77 23.21 0 22.23 0z"/></svg>
                        </a>
                        <a
                            v-if="email"
                            :href="`mailto:${email}`"
                            class="text-muted-foreground transition-colors hover:text-[color:var(--color-accent-primary)]"
                            title="Email"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </a>
                    </div>
                </div>

                <!-- ── Right: photo ────────────────────────────────────────── -->
                <div
                    v-motion
                    :initial="{ opacity: 0, scale: 0.85 }"
                    :enter="{ opacity: 1, scale: 1, transition: { duration: 800, delay: 300 } }"
                    class="flex justify-center lg:justify-end"
                >
                    <div class="relative">
                        <!-- Glow ring behind image -->
                        <div
                            class="absolute -inset-4 rounded-3xl blur-2xl opacity-30 -z-10"
                            :style="{ background: `radial-gradient(circle, var(--color-accent-glow), transparent 70%)` }"
                        />

                        <!-- Photo -->
                        <div
                            class="relative h-72 w-72 overflow-hidden rounded-3xl shadow-2xl lg:h-80 lg:w-80"
                            :style="reducedMotion ? {} : { animation: 'float 4s ease-in-out infinite' }"
                        >
                            <img
                                v-if="heroImage"
                                :src="heroImage"
                                :alt="heroImageAlt"
                                class="h-full w-full object-cover"
                            />
                            <div
                                v-else
                                class="h-full w-full flex items-center justify-center"
                                :style="{ background: `linear-gradient(135deg, var(--color-accent-primary), var(--color-accent-secondary))` }"
                            >
                                <span class="text-6xl font-bold text-white">
                                    {{ tr(personalInfo?.name)?.charAt(0) ?? 'O' }}
                                </span>
                            </div>
                        </div>

                        <!-- Floating tech badge -->
                        <div
                            class="absolute -bottom-3 -start-6 glass-card px-3 py-2 shadow-lg"
                            :style="reducedMotion ? {} : { animation: 'float 5s ease-in-out infinite 1s' }"
                        >
                            <div class="flex items-center gap-2 text-xs font-semibold text-foreground">
                                <span style="color: var(--color-accent-primary);">⚡</span>
                                <span>Laravel · Vue.js</span>
                            </div>
                        </div>

                        <!-- Mascot slot -->
                        <Mascot
                            :size="120"
                            class="absolute -top-8 -end-8 drop-shadow-xl"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 text-muted-foreground" aria-hidden="true">
            <span class="text-xs">Scroll</span>
            <svg
                class="h-5 w-5"
                :style="reducedMotion ? {} : { animation: 'bounce-down 1.4s ease-in-out infinite' }"
                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>

        <!-- Bottom wave transition into next section -->
        <AnimatedWaves fill="var(--color-background)" />
    </section>
</template>

<style scoped>
.noise-overlay {
    background-image: url("data:image/svg+xml,<svg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'><filter id='n'><feTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/></filter><rect width='100%' height='100%' filter='url(%23n)' opacity='1'/></svg>");
    background-size: 200px;
}
</style>

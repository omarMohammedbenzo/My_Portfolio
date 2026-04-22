<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { useTranslations }                        from '@/composables/useTranslations';
import Mascot                                     from '@/Components/Public/Mascot.vue';

const props = defineProps({
    settings: Object,
});

const { locale } = useTranslations();
const loc        = locale();
function tr(obj) { return obj?.[loc] || obj?.en || ''; }

// ── Editable content ──────────────────────────────────────────────────────
const aboutBrief = computed(() => tr(props.settings?.about_brief) || '');
const aboutImage = computed(() => props.settings?.about_image_1 ? `/${props.settings.about_image_1}` : null);

// ── Stats with animated counters ─────────────────────────────────────────
const statKeys = ['stat_experience', 'stat_projects', 'stat_technologies', 'stat_languages'];
const stats    = computed(() => statKeys.map(k => ({
    value: props.settings?.[k]?.value ?? '',
    label: tr(props.settings?.[k]?.label) || k,
})));

// ── Typewriter for the about text — type once on first enter ─────────────
const displayed    = ref('');
const sectionRef   = ref(null);
const typed        = ref(false);
let   typingTimer  = null;
let   observer     = null;

function typeText(text) {
    if (typed.value) return;
    typed.value = true;
    let i = 0;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reducedMotion) { displayed.value = text; return; }

    function tick() {
        if (i < text.length) {
            displayed.value = text.slice(0, i + 1);
            i++;
            typingTimer = setTimeout(tick, 18);
        }
    }
    tick();
}

// ── Animated counter ─────────────────────────────────────────────────────
const displayedStats = ref(stats.value.map(s => ({ ...s, displayed: s.value })));
const countersDone   = ref(false);

function animateCounters() {
    if (countersDone.value) return;
    countersDone.value = true;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    stats.value.forEach((stat, idx) => {
        const numPart = parseFloat(stat.value);
        if (isNaN(numPart) || reducedMotion) return;
        const suffix = stat.value.replace(String(Math.round(numPart)), '');
        let current  = 0;
        const steps  = 40;
        const step   = numPart / steps;
        const delay  = idx * 120;
        setTimeout(() => {
            const id = setInterval(() => {
                current = Math.min(current + step, numPart);
                displayedStats.value[idx].displayed = Math.round(current) + suffix;
                if (current >= numPart) clearInterval(id);
            }, 25);
        }, delay);
    });
}

onMounted(() => {
    // Reset displayedStats from reactive stats
    displayedStats.value = stats.value.map(s => ({ ...s, displayed: s.value }));

    observer = new IntersectionObserver(
        ([entry]) => {
            if (entry.isIntersecting) {
                typeText(aboutBrief.value);
                animateCounters();
            }
        },
        { threshold: 0.2 }
    );
    if (sectionRef.value) observer.observe(sectionRef.value);
});

onUnmounted(() => {
    clearTimeout(typingTimer);
    observer?.disconnect();
});
</script>

<template>
    <section id="about" ref="sectionRef" class="relative py-24" style="background: var(--color-bg-elevated, #12121a);">
        <div class="mx-auto max-w-6xl px-4">

            <!-- Header -->
            <div class="mb-14 text-center">
                <p class="eyebrow mb-3">About Me</p>
                <h2 class="text-3xl font-bold text-foreground sm:text-4xl">A bit about who I am</h2>
            </div>

            <!-- Two-column layout -->
            <div class="grid items-center gap-12 lg:grid-cols-2">

                <!-- Image -->
                <div
                    v-motion
                    :initial="{ opacity: 0, x: -40 }"
                    :visibleOnce="{ opacity: 1, x: 0, transition: { duration: 700 } }"
                    class="relative mx-auto w-full max-w-sm lg:max-w-none"
                >
                    <!-- Glow ring -->
                    <div
                        class="absolute -inset-4 rounded-3xl blur-2xl opacity-20 -z-10"
                        :style="{ background: `radial-gradient(circle, var(--color-accent-glow), transparent 70%)` }"
                    />
                    <img
                        v-if="aboutImage"
                        :src="aboutImage"
                        alt="Omar coding"
                        class="w-full rounded-3xl object-cover shadow-2xl"
                        style="max-height: 420px;"
                    />
                    <div
                        v-else
                        class="w-full rounded-3xl bg-muted flex items-center justify-center"
                        style="min-height: 300px;"
                    >
                        <span class="text-muted-foreground text-sm">about-coding-1.jpg</span>
                    </div>

                    <!-- Mascot peeks out of card bottom-right -->
                    <Mascot :size="100" class="absolute -bottom-6 -end-6" />
                </div>

                <!-- Typed text + stats -->
                <div
                    v-motion
                    :initial="{ opacity: 0, x: 40 }"
                    :visibleOnce="{ opacity: 1, x: 0, transition: { duration: 700, delay: 150 } }"
                >
                    <!-- Typed paragraph -->
                    <div class="glass-card p-6 min-h-[160px]">
                        <p class="text-base leading-relaxed text-foreground whitespace-pre-wrap">{{ displayed }}<span
                            v-if="displayed.length < aboutBrief.length"
                            class="inline-block w-0.5 h-4 bg-[color:var(--color-accent-primary)] animate-pulse align-middle ml-0.5"
                        /></p>
                    </div>

                    <!-- Stats row -->
                    <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
                        <div
                            v-for="(stat, i) in displayedStats"
                            :key="i"
                            v-motion
                            :initial="{ opacity: 0, y: 20 }"
                            :visibleOnce="{ opacity: 1, y: 0, transition: { duration: 500, delay: i * 100 } }"
                            class="glass-card p-4 text-center glow-on-hover"
                        >
                            <p class="text-2xl font-extrabold gradient-text">{{ stat.displayed }}</p>
                            <p class="mt-1 text-xs text-muted-foreground">{{ stat.label }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

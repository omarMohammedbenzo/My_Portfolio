<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const progress      = ref(0);
const reducedMotion = ref(false);

function update() {
    const scrolled  = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    progress.value  = docHeight > 0 ? Math.min((scrolled / docHeight) * 100, 100) : 0;
}

onMounted(() => {
    reducedMotion.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!reducedMotion.value) {
        window.addEventListener('scroll', update, { passive: true });
        update();
    }
});

onUnmounted(() => window.removeEventListener('scroll', update));
</script>

<template>
    <div
        v-if="!reducedMotion"
        class="fixed top-0 start-0 z-[9999] h-0.5"
        aria-hidden="true"
        :style="{
            width: `${progress}%`,
            background: `linear-gradient(to right, var(--color-accent-primary), var(--color-accent-secondary))`,
            transition: 'width 0.1s linear',
        }"
    />
</template>

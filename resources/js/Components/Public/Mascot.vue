<script setup>
import { computed, onMounted, ref } from 'vue';
import { usePage }                  from '@inertiajs/vue3';
import { Vue3Lottie }               from 'vue3-lottie';

const props = defineProps({
    size: { type: Number, default: 140 },
    class: { type: String, default: '' },
});

const page         = usePage();
const mascotConfig = computed(() => page.props.mascot ?? {});
const enabled      = computed(() => mascotConfig.value.enabled !== false);
const animUrl      = computed(() => mascotConfig.value.animation_url ?? '/lottie/mascot.json');

const lottieSrc  = ref(null);
const hasError   = ref(false);
const prefersReduced = ref(false);

onMounted(async () => {
    prefersReduced.value = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    try {
        const res = await fetch(animUrl.value);
        lottieSrc.value = await res.json();
    } catch {
        hasError.value = true;
    }
});
</script>

<template>
    <div
        v-if="enabled && !hasError && lottieSrc"
        :class="['pointer-events-none select-none', props.class]"
        :style="{ width: `${size}px`, height: `${size}px` }"
    >
        <Vue3Lottie
            :animationData="lottieSrc"
            :autoPlay="!prefersReduced"
            :loop="!prefersReduced"
            :speed="1"
            style="width: 100%; height: 100%;"
        />
    </div>
</template>

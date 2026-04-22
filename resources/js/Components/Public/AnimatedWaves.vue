<script setup>
defineProps({
    fill: { type: String, default: 'var(--color-background)' },
});
</script>

<template>
    <!-- Two layered SVG waves moving at different speeds for depth -->
    <div class="relative w-full overflow-hidden leading-none" style="height: 80px;" aria-hidden="true">
        <!-- Back wave (slower) -->
        <svg
            class="absolute bottom-0 left-0 animate-wave-1"
            style="width: 200%; height: 100%; animation: wave-move-1 14s linear infinite; opacity: 0.4;"
            viewBox="0 0 1440 80" preserveAspectRatio="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path :fill="fill" d="M0,40 C240,80 480,0 720,40 C960,80 1200,0 1440,40 L1440,80 L0,80 Z" />
        </svg>
        <!-- Front wave (faster) -->
        <svg
            class="absolute bottom-0 left-0 animate-wave-2"
            style="width: 200%; height: 100%; animation: wave-move-2 9s linear infinite;"
            viewBox="0 0 1440 80" preserveAspectRatio="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path :fill="fill" d="M0,50 C360,10 720,80 1080,30 C1260,5 1380,60 1440,50 L1440,80 L0,80 Z" />
        </svg>
    </div>
</template>

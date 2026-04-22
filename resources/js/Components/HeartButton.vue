<script setup>
import { ref, onMounted }  from 'vue';
import { usePage }         from '@inertiajs/vue3';
import confetti            from 'canvas-confetti';
import { useLocaleRoute }  from '@/composables/useLocaleRoute';

const reacted  = ref(false);
const count    = ref(0);
const loading  = ref(false);
const lroute   = useLocaleRoute();

const storageKey = () => `heart:${window.location.pathname}`;

onMounted(() => {
    reacted.value = localStorage.getItem(storageKey()) === '1';
});

function burst() {
    confetti({
        particleCount: 80,
        spread: 70,
        origin: { y: 0.9, x: 0.97 },
        colors: ['#f43f5e', '#fb7185', '#fda4af', '#6366f1', '#a78bfa'],
        scalar: 0.9,
    });
}

async function react() {
    if (reacted.value || loading.value) return;
    loading.value = true;
    try {
        await fetch(lroute('reactions.store'), {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ page_url: window.location.pathname }),
        });
        reacted.value = true;
        count.value++;
        localStorage.setItem(storageKey(), '1');
        burst();
    } catch {
        // silent failure — never block the user
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <button
        class="fixed bottom-6 inset-e-6 z-50 flex h-14 w-14 items-center justify-center rounded-full shadow-lg transition-all duration-200 select-none"
        :class="[
            reacted
                ? 'bg-rose-500 scale-110'
                : 'bg-card border border-border hover:scale-110 hover:bg-rose-50 dark:hover:bg-rose-950',
            loading ? 'opacity-60 cursor-wait' : 'cursor-pointer',
        ]"
        :disabled="reacted || loading"
        :title="reacted ? 'Thanks! ❤️' : 'Send love'"
        @click="react"
    >
        <span
            class="text-2xl transition-transform duration-150"
            :class="{ 'animate-bounce': reacted }"
        >{{ reacted ? '❤️' : '🤍' }}</span>
    </button>
</template>

<script setup>
defineProps({
    label: String,
    value: [String, Number],
    sub:   { type: String, default: '' },
    icon:  { type: String, default: '' },
    color: { type: String, default: 'violet' },
});

const colorMap = {
    violet: 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400',
    blue:   'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
    emerald:'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
    rose:   'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400',
    amber:  'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
};
</script>

<template>
    <div class="rounded-xl border border-border bg-card p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-medium text-muted-foreground uppercase tracking-wide">{{ label }}</p>
                <p class="mt-1 text-2xl font-bold text-foreground">{{ value }}</p>
                <p v-if="sub" class="mt-0.5 text-xs text-muted-foreground">{{ sub }}</p>
            </div>
            <div v-if="icon" :class="['rounded-lg p-2 text-xl', colorMap[color] ?? colorMap.violet]">
                {{ icon }}
            </div>
        </div>
    </div>
</template>

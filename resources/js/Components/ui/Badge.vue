<script setup>
defineProps({
    variant: { type: String, default: 'default' },
});

const variants = {
    default:     'bg-primary/10 text-primary',
    secondary:   'bg-secondary text-secondary-foreground',
    success:     'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
    warning:     'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
    destructive: 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    outline:     'border border-border text-foreground bg-transparent',
};
</script>

<template>
    <span :class="['inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold transition-colors', variants[variant] ?? variants.default]">
        <slot />
    </span>
</template>

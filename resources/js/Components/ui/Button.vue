<script setup>
defineProps({
    variant: { type: String, default: 'default' },
    size:    { type: String, default: 'md' },
    disabled:{ type: Boolean, default: false },
    type:    { type: String, default: 'button' },
});

const variants = {
    default:     'bg-primary text-primary-foreground hover:opacity-90',
    secondary:   'bg-secondary text-secondary-foreground hover:bg-secondary/80',
    destructive: 'bg-destructive text-white hover:opacity-90',
    outline:     'border border-border bg-transparent hover:bg-muted text-foreground',
    ghost:       'bg-transparent hover:bg-muted text-foreground',
    link:        'underline-offset-4 hover:underline text-primary bg-transparent p-0',
};
const sizes = {
    sm: 'h-8 px-3 text-xs',
    md: 'h-9 px-4 text-sm',
    lg: 'h-10 px-6 text-base',
    icon:'h-9 w-9 p-0',
};
</script>

<template>
    <button
        :type="type"
        :disabled="disabled"
        :class="[
            'inline-flex items-center justify-center gap-2 rounded-md font-medium transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50',
            variants[variant] ?? variants.default,
            sizes[size] ?? sizes.md,
        ]"
    >
        <slot />
    </button>
</template>

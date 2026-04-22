<script setup>
defineProps({
    padding: { type: String, default: 'p-6' },
});
</script>

<template>
    <div :class="['rounded-xl border border-border bg-card text-card-foreground shadow-sm', padding]">
        <slot />
    </div>
</template>

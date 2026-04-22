<script setup>
defineProps({
    modelValue: { default: '' },
    type:       { type: String, default: 'text' },
    placeholder:{ type: String, default: '' },
    disabled:   { type: Boolean, default: false },
    error:      { type: String, default: '' },
});
defineEmits(['update:modelValue']);
</script>

<template>
    <div class="w-full">
        <input
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :disabled="disabled"
            :class="[
                'flex h-9 w-full rounded-md border bg-transparent px-3 py-1 text-sm shadow-sm transition-colors placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50',
                error ? 'border-destructive' : 'border-border',
            ]"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <p v-if="error" class="mt-1 text-xs text-destructive">{{ error }}</p>
    </div>
</template>

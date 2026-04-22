<script setup>
defineProps({
    modelValue: { default: '' },
    options:    { type: Array, default: () => [] },
    placeholder:{ type: String, default: 'Select...' },
    disabled:   { type: Boolean, default: false },
    error:      { type: String, default: '' },
});
defineEmits(['update:modelValue']);
</script>

<template>
    <div class="w-full">
        <select
            :value="modelValue"
            :disabled="disabled"
            :class="[
                'flex h-9 w-full rounded-md border bg-background px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50',
                error ? 'border-destructive' : 'border-border',
            ]"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option value="" disabled>{{ placeholder }}</option>
            <option v-for="opt in options" :key="opt.value ?? opt" :value="opt.value ?? opt">
                {{ opt.label ?? opt }}
            </option>
        </select>
        <p v-if="error" class="mt-1 text-xs text-destructive">{{ error }}</p>
    </div>
</template>

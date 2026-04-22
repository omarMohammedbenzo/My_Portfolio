<script setup>
defineProps({
    modelValue:  { default: '' },
    placeholder: { type: String, default: '' },
    rows:        { type: Number, default: 4 },
    disabled:    { type: Boolean, default: false },
    error:       { type: String, default: '' },
});
defineEmits(['update:modelValue']);
</script>

<template>
    <div class="w-full">
        <textarea
            :value="modelValue"
            :placeholder="placeholder"
            :rows="rows"
            :disabled="disabled"
            :class="[
                'flex w-full rounded-md border bg-transparent px-3 py-2 text-sm shadow-sm placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 resize-y',
                error ? 'border-destructive' : 'border-border',
            ]"
            @input="$emit('update:modelValue', $event.target.value)"
        />
        <p v-if="error" class="mt-1 text-xs text-destructive">{{ error }}</p>
    </div>
</template>

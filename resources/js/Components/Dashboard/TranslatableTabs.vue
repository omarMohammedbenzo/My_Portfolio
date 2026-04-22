<script setup>
import { ref } from 'vue';

defineProps({
    modelValue: { type: Object, default: () => ({ en: '', ar: '' }) },
    error:      { type: Object, default: () => ({}) },
    label:      { type: String, default: '' },
    required:   { type: Boolean, default: false },
    multiline:  { type: Boolean, default: false },
    rows:       { type: Number, default: 4 },
});
defineEmits(['update:modelValue']);

const activeTab = ref('en');
</script>

<template>
    <div>
        <label v-if="label" class="mb-1.5 block text-sm font-medium text-foreground">
            {{ label }} <span v-if="required" class="text-destructive">*</span>
        </label>

        <div class="rounded-lg border border-border overflow-hidden">
            <!-- Tabs -->
            <div class="flex border-b border-border bg-muted/40">
                <button
                    v-for="tab in ['en', 'ar']"
                    :key="tab"
                    type="button"
                    :class="[
                        'px-4 py-2 text-xs font-medium transition-colors',
                        activeTab === tab
                            ? 'bg-background text-primary border-b-2 border-primary -mb-px'
                            : 'text-muted-foreground hover:text-foreground',
                    ]"
                    @click="activeTab = tab"
                >
                    {{ tab === 'en' ? '🇬🇧 EN' : '🇸🇦 AR' }}
                </button>
            </div>

            <!-- Content -->
            <div class="p-3">
                <textarea
                    v-if="multiline"
                    :value="modelValue[activeTab]"
                    :rows="rows"
                    :dir="activeTab === 'ar' ? 'rtl' : 'ltr'"
                    :class="['w-full resize-y rounded-md bg-transparent text-sm outline-none', error[activeTab] ? 'text-destructive' : '']"
                    @input="$emit('update:modelValue', { ...modelValue, [activeTab]: $event.target.value })"
                />
                <input
                    v-else
                    :value="modelValue[activeTab]"
                    type="text"
                    :dir="activeTab === 'ar' ? 'rtl' : 'ltr'"
                    :class="['w-full rounded-md bg-transparent text-sm outline-none', error[activeTab] ? 'text-destructive' : '']"
                    @input="$emit('update:modelValue', { ...modelValue, [activeTab]: $event.target.value })"
                />
            </div>
        </div>
        <p v-if="error.en || error.ar" class="mt-1 text-xs text-destructive">
            {{ error.en || error.ar }}
        </p>
    </div>
</template>

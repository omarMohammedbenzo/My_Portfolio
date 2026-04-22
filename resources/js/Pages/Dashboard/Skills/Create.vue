<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { computed }            from 'vue';
import { Icon }                from '@iconify/vue';
import DashboardLayout         from '@/Layouts/DashboardLayout.vue';
import TranslatableTabs        from '@/Components/Dashboard/TranslatableTabs.vue';
import Button                  from '@/Components/ui/Button.vue';
import Input                   from '@/Components/ui/Input.vue';
import Select                  from '@/Components/ui/Select.vue';

const props = defineProps({ categories: Array });

const form = useForm({
    name:       { en: '', ar: '' },
    category:   'backend',
    level:      3,
    icon_set:   'simple-icons',
    icon_slug:  '',
    icon_color: '',
    years:      null,
    order:      0,
});

const iconSetOptions = [
    { value: 'simple-icons', label: 'Simple Icons (brand)' },
    { value: 'lucide',       label: 'Lucide (generic)' },
];

const previewIcon = computed(() => {
    if (!form.icon_slug) return null;
    return form.icon_set === 'simple-icons'
        ? `simple-icons:${form.icon_slug}`
        : `lucide:${form.icon_slug}`;
});

function submit() { form.post(route('dashboard.skills.store')); }
</script>

<template>
    <Head title="Add Skill" />
    <DashboardLayout>
        <template #title>Add Skill</template>
        <form @submit.prevent="submit" class="max-w-lg space-y-5">
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <TranslatableTabs v-model="form.name" label="Skill Name" required
                    :error="{ en: form.errors['name.en'], ar: form.errors['name.ar'] }" />

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Category *</label>
                        <Select v-model="form.category" :options="categories" :error="form.errors.category" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Level (1–5): {{ form.level }}</label>
                        <input v-model.number="form.level" type="range" min="1" max="5" class="w-full accent-primary" />
                    </div>
                </div>

                <!-- Icon fields -->
                <div class="space-y-3 rounded-lg border border-border p-3">
                    <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Icon</p>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium">Icon Set</label>
                            <Select v-model="form.icon_set" :options="iconSetOptions" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium">Icon Slug</label>
                            <div class="flex items-center gap-2">
                                <Input v-model="form.icon_slug"
                                    :placeholder="form.icon_set === 'simple-icons' ? 'e.g. laravel, php' : 'e.g. webhook, terminal'"
                                    class="flex-1" />
                                <!-- Live preview -->
                                <div v-if="previewIcon" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-border bg-muted">
                                    <Icon :icon="previewIcon"
                                        :style="{ color: form.icon_color || 'var(--color-primary)', fontSize: '20px' }" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium">Icon Color (hex)</label>
                            <div class="flex items-center gap-2">
                                <input type="color" :value="form.icon_color || '#8b5cf6'"
                                    @input="form.icon_color = $event.target.value"
                                    class="h-9 w-12 cursor-pointer rounded border border-border bg-transparent p-0.5" />
                                <Input v-model="form.icon_color" placeholder="#777BB4" class="flex-1 font-mono text-sm" />
                            </div>
                            <p class="mt-1 text-xs text-muted-foreground">Leave blank → brand default (simple-icons) or theme accent (lucide)</p>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium">Years of experience</label>
                            <Input v-model.number="form.years" type="number" min="0" max="99" placeholder="optional" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <Link :href="route('dashboard.skills.index')">
                    <Button variant="outline" type="button">Cancel</Button>
                </Link>
                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving…' : 'Save Skill' }}
                </Button>
            </div>
        </form>
    </DashboardLayout>
</template>

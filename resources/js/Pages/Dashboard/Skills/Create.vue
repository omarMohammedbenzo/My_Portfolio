<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import DashboardLayout  from '@/Layouts/DashboardLayout.vue';
import TranslatableTabs from '@/Components/Dashboard/TranslatableTabs.vue';
import Button           from '@/Components/ui/Button.vue';
import Input            from '@/Components/ui/Input.vue';
import Select           from '@/Components/ui/Select.vue';

const props = defineProps({ categories: Array });
const form  = useForm({ name: { en: '', ar: '' }, category: 'backend', level: 3, icon: '', order: 0 });
function submit() { form.post(route('dashboard.skills.store')); }
</script>

<template>
    <Head title="Add Skill" />
    <DashboardLayout>
        <template #title>Add Skill</template>
        <form @submit.prevent="submit" class="max-w-lg space-y-5">
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <TranslatableTabs v-model="form.name" label="Skill Name" required :error="{ en: form.errors['name.en'], ar: form.errors['name.ar'] }" />
                <div class="grid gap-4 sm:grid-cols-2">
                    <div><label class="mb-1.5 block text-sm font-medium">Category *</label><Select v-model="form.category" :options="categories" :error="form.errors.category" /></div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Level (1–5): {{ form.level }}</label>
                        <input v-model.number="form.level" type="range" min="1" max="5" class="w-full accent-primary" />
                    </div>
                </div>
                <div><label class="mb-1.5 block text-sm font-medium">Icon (Lucide name)</label><Input v-model="form.icon" placeholder="e.g. code, database, layers" /></div>
            </div>
            <div class="flex justify-end gap-3">
                <Link :href="route('dashboard.skills.index')"><Button variant="outline" type="button">Cancel</Button></Link>
                <Button type="submit" :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Save Skill' }}</Button>
            </div>
        </form>
    </DashboardLayout>
</template>

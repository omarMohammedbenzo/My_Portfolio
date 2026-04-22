<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import DashboardLayout  from '@/Layouts/DashboardLayout.vue';
import TranslatableTabs from '@/Components/Dashboard/TranslatableTabs.vue';
import Button           from '@/Components/ui/Button.vue';
import Input            from '@/Components/ui/Input.vue';

const form = useForm({ school: '', degree: { en: '', ar: '' }, field: { en: '', ar: '' }, location: { en: '', ar: '' }, description: { en: '', ar: '' }, start_date: '', end_date: '', order: 0 });
function submit() { form.post(route('dashboard.educations.store')); }
</script>

<template>
    <Head title="Add Education" />
    <DashboardLayout>
        <template #title>Add Education</template>
        <form @submit.prevent="submit" class="max-w-2xl space-y-5">
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <div><label class="mb-1.5 block text-sm font-medium">School / University *</label><Input v-model="form.school" :error="form.errors.school" /></div>
                <TranslatableTabs v-model="form.degree" label="Degree" required :error="{ en: form.errors['degree.en'], ar: form.errors['degree.ar'] }" />
                <TranslatableTabs v-model="form.field" label="Field of Study" required :error="{ en: form.errors['field.en'], ar: form.errors['field.ar'] }" />
                <TranslatableTabs v-model="form.location" label="Location" :error="{ en: form.errors['location.en'], ar: form.errors['location.ar'] }" />
                <TranslatableTabs v-model="form.description" label="Description" multiline :rows="3" :error="{ en: form.errors['description.en'], ar: form.errors['description.ar'] }" />
                <div class="grid gap-4 sm:grid-cols-2">
                    <div><label class="mb-1.5 block text-sm font-medium">Start Date *</label><Input v-model="form.start_date" type="date" :error="form.errors.start_date" /></div>
                    <div><label class="mb-1.5 block text-sm font-medium">End Date</label><Input v-model="form.end_date" type="date" :error="form.errors.end_date" /></div>
                </div>
            </div>
            <div class="flex justify-end gap-3">
                <Link :href="route('dashboard.educations.index')"><Button variant="outline" type="button">Cancel</Button></Link>
                <Button type="submit" :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Save' }}</Button>
            </div>
        </form>
    </DashboardLayout>
</template>

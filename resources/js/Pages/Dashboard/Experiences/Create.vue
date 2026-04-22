<script setup>
import { Head, useForm }  from '@inertiajs/vue3';
import { ref }             from 'vue';
import DashboardLayout    from '@/Layouts/DashboardLayout.vue';
import TranslatableTabs   from '@/Components/Dashboard/TranslatableTabs.vue';
import Button             from '@/Components/ui/Button.vue';
import Input              from '@/Components/ui/Input.vue';
import Select             from '@/Components/ui/Select.vue';

const props = defineProps({ employmentTypes: Array, locationTypes: Array });

const form = useForm({
    company:         '',
    role:            { en: '', ar: '' },
    location:        { en: '', ar: '' },
    description:     { en: '', ar: '' },
    tech_stack:      [],
    start_date:      '',
    end_date:        '',
    is_current:      false,
    employment_type: 'full-time',
    location_type:   'on-site',
    order:           0,
});

const techStackStr = ref('');
function syncTechStack() {
    form.tech_stack = techStackStr.value.split(',').map(s => s.trim()).filter(Boolean);
}

function submit() { form.post(route('dashboard.experiences.store')); }
</script>

<template>
    <Head title="Add Experience" />
    <DashboardLayout>
        <template #title>Add Experience</template>

        <form @submit.prevent="submit" class="max-w-2xl space-y-5">
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Company *</label>
                    <Input v-model="form.company" :error="form.errors.company" />
                </div>
                <TranslatableTabs v-model="form.role" label="Role / Job Title" required :error="{ en: form.errors['role.en'], ar: form.errors['role.ar'] }" />
                <TranslatableTabs v-model="form.location" label="Location" required :error="{ en: form.errors['location.en'], ar: form.errors['location.ar'] }" />
                <TranslatableTabs v-model="form.description" label="Description" required multiline :rows="6" :error="{ en: form.errors['description.en'], ar: form.errors['description.ar'] }" />
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Tech Stack (comma-separated)</label>
                    <Input v-model="techStackStr" @input="syncTechStack" placeholder="Laravel, Vue.js, MySQL" />
                    <p class="mt-1 text-xs text-muted-foreground">e.g. Laravel, Vue.js, MySQL</p>
                </div>
            </div>

            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Start Date *</label>
                        <Input v-model="form.start_date" type="date" :error="form.errors.start_date" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">End Date</label>
                        <Input v-model="form.end_date" type="date" :disabled="form.is_current" :error="form.errors.end_date" />
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <input id="is_current" v-model="form.is_current" type="checkbox" class="h-4 w-4 rounded border-border" />
                    <label for="is_current" class="text-sm">Currently working here</label>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Employment Type *</label>
                        <Select v-model="form.employment_type" :options="employmentTypes" :error="form.errors.employment_type" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Location Type *</label>
                        <Select v-model="form.location_type" :options="locationTypes" :error="form.errors.location_type" />
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <Link :href="route('dashboard.experiences.index')">
                    <Button variant="outline" type="button">Cancel</Button>
                </Link>
                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving…' : 'Save Experience' }}
                </Button>
            </div>
        </form>
    </DashboardLayout>
</template>

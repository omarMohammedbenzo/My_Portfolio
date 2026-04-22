<script setup>
import { Head, useForm }      from '@inertiajs/vue3';
import DashboardLayout        from '@/Layouts/DashboardLayout.vue';
import TranslatableTabs       from '@/Components/Dashboard/TranslatableTabs.vue';
import Button                 from '@/Components/ui/Button.vue';
import Input                  from '@/Components/ui/Input.vue';

const props = defineProps({ info: Object });

const form = useForm({
    name:     props.info.name     ?? { en: '', ar: '' },
    title:    props.info.title    ?? { en: '', ar: '' },
    summary:  props.info.summary  ?? { en: '', ar: '' },
    location: props.info.location ?? { en: '', ar: '' },
    email:    props.info.email    ?? '',
    phone:    props.info.phone    ?? '',
    socials:  props.info.socials  ?? { github: '', linkedin: '' },
    avatar:   null,
});

function submit() {
    form.post(route('dashboard.personal-info.update'), { forceFormData: true });
}
</script>

<template>
    <Head title="Personal Info" />

    <DashboardLayout>
        <template #title>Personal Info</template>

        <form @submit.prevent="submit" class="max-w-2xl space-y-6">

            <!-- Avatar preview -->
            <div class="rounded-xl border border-border bg-card p-5">
                <h3 class="mb-4 text-sm font-semibold text-foreground">Profile Photo</h3>
                <div class="flex items-center gap-4">
                    <img v-if="info.avatar" :src="info.avatar" class="h-16 w-16 rounded-full object-cover" alt="Avatar" />
                    <div v-else class="h-16 w-16 rounded-full bg-primary/20 flex items-center justify-center text-xl font-bold text-primary">O</div>
                    <div>
                        <input type="file" accept="image/*" class="text-sm" @change="form.avatar = $event.target.files[0]" />
                        <p class="mt-1 text-xs text-muted-foreground">Max 2MB. JPG, PNG, WebP.</p>
                    </div>
                </div>
            </div>

            <!-- Name & Title -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-foreground">Identity</h3>
                <TranslatableTabs v-model="form.name"  label="Full Name" required :error="{ en: form.errors['name.en'], ar: form.errors['name.ar'] }" />
                <TranslatableTabs v-model="form.title" label="Job Title" required :error="{ en: form.errors['title.en'], ar: form.errors['title.ar'] }" />
            </div>

            <!-- Summary -->
            <div class="rounded-xl border border-border bg-card p-5">
                <h3 class="mb-4 text-sm font-semibold text-foreground">Summary</h3>
                <TranslatableTabs v-model="form.summary" label="Career Summary" required multiline :rows="6" :error="{ en: form.errors['summary.en'], ar: form.errors['summary.ar'] }" />
            </div>

            <!-- Contact -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-foreground">Contact</h3>
                <TranslatableTabs v-model="form.location" label="Location" required :error="{ en: form.errors['location.en'], ar: form.errors['location.ar'] }" />
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Email *</label>
                        <Input v-model="form.email" type="email" :error="form.errors.email" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Phone</label>
                        <Input v-model="form.phone" :error="form.errors.phone" />
                    </div>
                </div>
            </div>

            <!-- Socials -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-foreground">Social Links</h3>
                <div v-for="key in ['github', 'linkedin', 'twitter', 'website']" :key="key">
                    <label class="mb-1.5 block text-sm font-medium capitalize">{{ key }}</label>
                    <Input v-model="form.socials[key]" :placeholder="`https://...`" />
                </div>
            </div>

            <div class="flex justify-end">
                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving…' : 'Save Changes' }}
                </Button>
            </div>
        </form>
    </DashboardLayout>
</template>

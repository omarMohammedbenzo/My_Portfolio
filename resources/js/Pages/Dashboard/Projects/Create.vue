<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref, computed }       from 'vue';
import DashboardLayout  from '@/Layouts/DashboardLayout.vue';
import TranslatableTabs from '@/Components/Dashboard/TranslatableTabs.vue';
import Button           from '@/Components/ui/Button.vue';
import Input            from '@/Components/ui/Input.vue';
import Select           from '@/Components/ui/Select.vue';

const statusOptions = [
    { value: 'draft',     label: 'Draft' },
    { value: 'published', label: 'Published' },
    { value: 'archived',  label: 'Archived' },
];

const form = useForm({
    title:             { en: '', ar: '' },
    description:       { en: '', ar: '' },
    short_description: { en: '', ar: '' },
    slug:              '',
    url:               '',
    github_url:        '',
    tech_stack:        [],
    status:            'draft',
    featured:          false,
    gradient_colors:   { from: 'violet-500', via: 'purple-500', to: 'indigo-600' },
    order:             0,
    cover_image:       null,
});

const techInput  = ref('');
const coverPreview = ref(null);

function addTech() {
    const val = techInput.value.trim();
    if (val && !form.tech_stack.includes(val)) form.tech_stack.push(val);
    techInput.value = '';
}
function removeTech(i) { form.tech_stack.splice(i, 1); }

function onCoverChange(e) {
    const file = e.target.files[0];
    if (!file) return;
    form.cover_image = file;
    coverPreview.value = URL.createObjectURL(file);
}

function submit() {
    form.post(route('dashboard.projects.store'), { forceFormData: true });
}
</script>

<template>
    <Head title="Add Project" />
    <DashboardLayout>
        <template #title>Add Project</template>

        <form @submit.prevent="submit" class="max-w-2xl space-y-5">
            <!-- Basic info -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Content</h3>

                <TranslatableTabs v-model="form.title" label="Project Title" required
                    :error="{ en: form.errors['title.en'], ar: form.errors['title.ar'] }" />
                <TranslatableTabs v-model="form.short_description" label="Short Description" multiline :rows="2"
                    :error="{ en: form.errors['short_description.en'], ar: form.errors['short_description.ar'] }" />
                <TranslatableTabs v-model="form.description" label="Full Description" multiline :rows="5"
                    :error="{ en: form.errors['description.en'], ar: form.errors['description.ar'] }" />
            </div>

            <!-- Meta -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Details</h3>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Slug *</label>
                        <Input v-model="form.slug" placeholder="my-project" :error="form.errors.slug" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Status</label>
                        <Select v-model="form.status" :options="statusOptions" :error="form.errors.status" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Live URL</label>
                        <Input v-model="form.url" type="url" placeholder="https://..." />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">GitHub URL</label>
                        <Input v-model="form.github_url" type="url" placeholder="https://github.com/..." />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input id="featured" v-model="form.featured" type="checkbox" class="accent-primary" />
                    <label for="featured" class="text-sm font-medium">Featured on homepage</label>
                </div>
            </div>

            <!-- Tech Stack -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-3">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Tech Stack</h3>
                <div class="flex gap-2">
                    <Input v-model="techInput" placeholder="e.g. Laravel" class="flex-1" @keydown.enter.prevent="addTech" />
                    <Button type="button" variant="outline" @click="addTech">Add</Button>
                </div>
                <div v-if="form.tech_stack.length" class="flex flex-wrap gap-2">
                    <span
                        v-for="(tech, i) in form.tech_stack"
                        :key="i"
                        class="inline-flex items-center gap-1 rounded-full bg-muted px-3 py-1 text-xs font-medium"
                    >
                        {{ tech }}
                        <button type="button" class="text-muted-foreground hover:text-foreground" @click="removeTech(i)">×</button>
                    </span>
                </div>
            </div>

            <!-- Gradient Colors -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Placeholder Gradient</h3>
                <p class="text-xs text-muted-foreground">Used when no cover image is set. Enter Tailwind color classes.</p>
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">From</label>
                        <Input v-model="form.gradient_colors.from" placeholder="violet-500" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">Via</label>
                        <Input v-model="form.gradient_colors.via" placeholder="purple-500" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium">To</label>
                        <Input v-model="form.gradient_colors.to" placeholder="indigo-600" />
                    </div>
                </div>
            </div>

            <!-- Cover Image -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-3">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Cover Image</h3>
                <div v-if="coverPreview" class="w-full max-w-xs rounded-lg overflow-hidden">
                    <img :src="coverPreview" alt="Preview" class="w-full object-cover" />
                </div>
                <input type="file" accept="image/*" class="text-sm" @change="onCoverChange" />
                <p v-if="form.errors.cover_image" class="text-xs text-destructive">{{ form.errors.cover_image }}</p>
            </div>

            <div class="flex justify-end gap-3">
                <Link :href="route('dashboard.projects.index')"><Button variant="outline" type="button">Cancel</Button></Link>
                <Button type="submit" :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Save Project' }}</Button>
            </div>
        </form>
    </DashboardLayout>
</template>

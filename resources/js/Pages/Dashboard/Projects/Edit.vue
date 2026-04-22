<script setup>
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { ref }                          from 'vue';
import DashboardLayout  from '@/Layouts/DashboardLayout.vue';
import TranslatableTabs from '@/Components/Dashboard/TranslatableTabs.vue';
import ConfirmDialog    from '@/Components/Dashboard/ConfirmDialog.vue';
import Button           from '@/Components/ui/Button.vue';
import Input            from '@/Components/ui/Input.vue';
import Select           from '@/Components/ui/Select.vue';

const props = defineProps({ project: Object });

const statusOptions = [
    { value: 'draft',     label: 'Draft' },
    { value: 'published', label: 'Published' },
    { value: 'archived',  label: 'Archived' },
];

const form = useForm({
    _method:           'PUT',
    title:             props.project.title             ?? { en: '', ar: '' },
    description:       props.project.description       ?? { en: '', ar: '' },
    short_description: props.project.short_description ?? { en: '', ar: '' },
    slug:              props.project.slug              ?? '',
    url:               props.project.url               ?? '',
    github_url:        props.project.github_url        ?? '',
    tech_stack:        props.project.tech_stack        ?? [],
    status:            props.project.status            ?? 'draft',
    featured:          props.project.featured          ?? false,
    gradient_colors:   props.project.gradient_colors   ?? { from: 'violet-500', via: 'purple-500', to: 'indigo-600' },
    order:             props.project.order             ?? 0,
    cover_image:       null,
});

const techInput    = ref('');
const coverPreview = ref(null);
const confirmImgRef = ref(null);
const toDeleteImgId = ref(null);

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

function confirmDeleteImg(id) { toDeleteImgId.value = id; confirmImgRef.value.show(); }
function doDeleteImg() {
    router.delete(route('dashboard.projects.images.destroy', [props.project.id, toDeleteImgId.value]), { preserveScroll: true });
}

function submit() {
    form.post(route('dashboard.projects.update', props.project.id), { forceFormData: true });
}
</script>

<template>
    <Head title="Edit Project" />
    <DashboardLayout>
        <template #title>Edit Project</template>

        <form @submit.prevent="submit" class="max-w-2xl space-y-5">
            <!-- Content -->
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
                        <Input v-model="form.slug" :error="form.errors.slug" />
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
                    <Input v-model="techInput" placeholder="e.g. Vue" class="flex-1" @keydown.enter.prevent="addTech" />
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

                <!-- Current cover -->
                <div v-if="project.cover_url && !coverPreview" class="w-full max-w-xs rounded-lg overflow-hidden">
                    <img :src="project.cover_url" alt="Current cover" class="w-full object-cover" />
                    <p class="mt-1 text-xs text-muted-foreground">Current cover</p>
                </div>

                <!-- New preview -->
                <div v-if="coverPreview" class="w-full max-w-xs rounded-lg overflow-hidden">
                    <img :src="coverPreview" alt="New cover preview" class="w-full object-cover" />
                    <p class="mt-1 text-xs text-muted-foreground">New cover (not saved yet)</p>
                </div>

                <input type="file" accept="image/*" class="text-sm" @change="onCoverChange" />
                <p v-if="form.errors.cover_image" class="text-xs text-destructive">{{ form.errors.cover_image }}</p>
            </div>

            <!-- Gallery Images -->
            <div v-if="project.images?.length" class="rounded-xl border border-border bg-card p-5 space-y-3">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Gallery</h3>
                <div class="grid grid-cols-3 gap-3">
                    <div
                        v-for="img in project.images"
                        :key="img.id"
                        class="relative rounded-lg overflow-hidden group"
                    >
                        <img :src="img.url" :alt="img.caption?.en" class="w-full h-28 object-cover" />
                        <button
                            type="button"
                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-medium"
                            @click="confirmDeleteImg(img.id)"
                        >Delete</button>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <Link :href="route('dashboard.projects.index')"><Button variant="outline" type="button">Cancel</Button></Link>
                <Button type="submit" :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Update Project' }}</Button>
            </div>
        </form>

        <ConfirmDialog ref="confirmImgRef" message="Delete this image?" @confirm="doDeleteImg" />
    </DashboardLayout>
</template>

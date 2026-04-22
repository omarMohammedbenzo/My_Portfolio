<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed }       from 'vue';
import DashboardLayout         from '@/Layouts/DashboardLayout.vue';
import ConfirmDialog           from '@/Components/Dashboard/ConfirmDialog.vue';
import Badge                   from '@/Components/ui/Badge.vue';
import Button                  from '@/Components/ui/Button.vue';

const props      = defineProps({ projects: Array });
const confirmRef = ref(null);
const toDeleteId = ref(null);

const statusVariant = { published: 'success', draft: 'secondary', archived: 'outline' };

function confirmDelete(id) { toDeleteId.value = id; confirmRef.value.show(); }
function doDelete()        { router.delete(route('dashboard.projects.destroy', toDeleteId.value), { preserveScroll: true }); }
function toggleFeatured(project) {
    router.patch(route('dashboard.projects.update', project.id), { featured: !project.featured }, { preserveScroll: true });
}

const gradientStyle = (p) => {
    const g = p.gradient_colors ?? {};
    return { background: `linear-gradient(135deg, var(--tw-${g.from ?? 'violet-500'}), var(--tw-${g.to ?? 'indigo-600'}))` };
};
</script>

<template>
    <Head title="Projects" />
    <DashboardLayout>
        <template #title>Projects</template>

        <div class="mb-5 flex items-center justify-between">
            <p class="text-sm text-muted-foreground">{{ projects.length }} projects</p>
            <Link :href="route('dashboard.projects.create')"><Button>+ Add Project</Button></Link>
        </div>

        <div class="space-y-3">
            <div
                v-for="project in projects"
                :key="project.id"
                class="rounded-lg border border-border bg-card p-4 flex items-center gap-4"
            >
                <!-- Thumbnail -->
                <div class="h-14 w-20 shrink-0 rounded-md overflow-hidden">
                    <img
                        v-if="project.cover_url"
                        :src="project.cover_url"
                        :alt="project.title?.en"
                        class="h-full w-full object-cover"
                    />
                    <div
                        v-else
                        class="h-full w-full flex items-center justify-center text-white text-xs font-bold"
                        :style="{ background: `linear-gradient(135deg, #6366f1, #8b5cf6)` }"
                    >
                        {{ (project.title?.en ?? 'P').slice(0, 2).toUpperCase() }}
                    </div>
                </div>

                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="text-sm font-medium text-foreground truncate">{{ project.title?.en }}</p>
                        <Badge :variant="statusVariant[project.status] ?? 'secondary'" class="capitalize">{{ project.status }}</Badge>
                        <Badge v-if="project.featured" variant="warning">Featured</Badge>
                    </div>
                    <p class="mt-0.5 text-xs text-muted-foreground truncate">{{ (project.tech_stack ?? []).join(', ') }}</p>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-1 shrink-0">
                    <Button
                        variant="ghost"
                        size="sm"
                        :title="project.featured ? 'Unfeature' : 'Feature'"
                        @click="toggleFeatured(project)"
                    >{{ project.featured ? '★' : '☆' }}</Button>
                    <Link :href="route('dashboard.projects.edit', project.id)">
                        <Button variant="outline" size="sm">Edit</Button>
                    </Link>
                    <Button variant="destructive" size="sm" @click="confirmDelete(project.id)">Del</Button>
                </div>
            </div>

            <p v-if="!projects.length" class="py-12 text-center text-sm text-muted-foreground">No projects yet.</p>
        </div>

        <ConfirmDialog ref="confirmRef" message="Delete this project? This cannot be undone." @confirm="doDelete" />
    </DashboardLayout>
</template>

<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref }                 from 'vue';
import DashboardLayout         from '@/Layouts/DashboardLayout.vue';
import ConfirmDialog           from '@/Components/Dashboard/ConfirmDialog.vue';
import Button                  from '@/Components/ui/Button.vue';

const props = defineProps({ educations: Array });
const confirmRef = ref(null);
const toDeleteId = ref(null);

function confirmDelete(id) { toDeleteId.value = id; confirmRef.value.show(); }
function doDelete() { router.delete(route('dashboard.educations.destroy', toDeleteId.value), { preserveScroll: true }); }
function fmt(d) { return d ? new Date(d).toLocaleDateString('en-GB', { month: 'short', year: 'numeric' }) : ''; }
</script>

<template>
    <Head title="Educations" />
    <DashboardLayout>
        <template #title>Educations</template>
        <div class="mb-5 flex items-center justify-between">
            <p class="text-sm text-muted-foreground">{{ educations.length }} entries</p>
            <Link :href="route('dashboard.educations.create')"><Button>+ Add Education</Button></Link>
        </div>
        <div class="space-y-3">
            <div v-for="edu in educations" :key="edu.id" class="rounded-xl border border-border bg-card p-4 flex items-start justify-between gap-4">
                <div>
                    <p class="font-semibold text-sm text-foreground">{{ edu.school }}</p>
                    <p class="text-xs text-muted-foreground">{{ edu.degree?.en }} in {{ edu.field?.en }}</p>
                    <p class="text-xs text-muted-foreground">{{ fmt(edu.start_date) }} — {{ fmt(edu.end_date) }}</p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <Link :href="route('dashboard.educations.edit', edu.id)"><Button variant="outline" size="sm">Edit</Button></Link>
                    <Button variant="destructive" size="sm" @click="confirmDelete(edu.id)">Del</Button>
                </div>
            </div>
        </div>
        <ConfirmDialog ref="confirmRef" message="Delete this education entry?" @confirm="doDelete" />
    </DashboardLayout>
</template>

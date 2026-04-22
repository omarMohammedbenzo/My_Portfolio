<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref }                 from 'vue';
import DashboardLayout         from '@/Layouts/DashboardLayout.vue';
import ConfirmDialog           from '@/Components/Dashboard/ConfirmDialog.vue';
import Badge                   from '@/Components/ui/Badge.vue';
import Button                  from '@/Components/ui/Button.vue';
import { usePage }             from '@inertiajs/vue3';

const props = defineProps({ experiences: Array, employmentTypes: Array, locationTypes: Array });
const page  = usePage();

const confirmRef    = ref(null);
const toDeleteId    = ref(null);

function confirmDelete(id) {
    toDeleteId.value = id;
    confirmRef.value.show();
}

function doDelete() {
    router.delete(route('dashboard.experiences.destroy', toDeleteId.value), {
        preserveScroll: true,
    });
}

function formatDate(d) {
    if (!d) return '';
    return new Date(d).toLocaleDateString('en-GB', { month: 'short', year: 'numeric' });
}
</script>

<template>
    <Head title="Experiences" />
    <DashboardLayout>
        <template #title>Experiences</template>

        <div class="mb-5 flex items-center justify-between">
            <p class="text-sm text-muted-foreground">{{ experiences.length }} entries</p>
            <Link :href="route('dashboard.experiences.create')">
                <Button>+ Add Experience</Button>
            </Link>
        </div>

        <div class="space-y-3">
            <div
                v-for="exp in experiences"
                :key="exp.id"
                class="rounded-xl border border-border bg-card p-4 flex items-start justify-between gap-4"
            >
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <span class="font-semibold text-sm text-foreground">{{ exp.company }}</span>
                        <Badge variant="default">{{ exp.role?.en }}</Badge>
                        <Badge v-if="exp.is_current" variant="success">Current</Badge>
                    </div>
                    <p class="text-xs text-muted-foreground">
                        {{ formatDate(exp.start_date) }} — {{ exp.is_current ? 'Present' : formatDate(exp.end_date) }}
                        · {{ exp.employment_type }} · {{ exp.location_type }}
                    </p>
                    <p class="text-xs text-muted-foreground mt-0.5">{{ exp.location?.en }}</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <Link :href="route('dashboard.experiences.edit', exp.id)">
                        <Button variant="outline" size="sm">Edit</Button>
                    </Link>
                    <Button variant="destructive" size="sm" @click="confirmDelete(exp.id)">Del</Button>
                </div>
            </div>
        </div>

        <ConfirmDialog ref="confirmRef" message="Delete this experience? This cannot be undone." @confirm="doDelete" />
    </DashboardLayout>
</template>

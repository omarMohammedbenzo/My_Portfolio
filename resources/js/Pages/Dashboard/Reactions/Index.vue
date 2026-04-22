<script setup>
import { Head, router }   from '@inertiajs/vue3';
import { computed }        from 'vue';
import { Bar }             from 'vue-chartjs';
import { Chart as ChartJS, BarElement, CategoryScale, LinearScale, Tooltip } from 'chart.js';
import DashboardLayout    from '@/Layouts/DashboardLayout.vue';

ChartJS.register(BarElement, CategoryScale, LinearScale, Tooltip);

const props = defineProps({ reactions: Object, byPage: Array, total: Number });

const chartData = computed(() => ({
    labels:   (props.byPage ?? []).map(r => r.page_url),
    datasets: [{
        label:           'Hearts',
        data:            (props.byPage ?? []).map(r => r.count),
        backgroundColor: '#6366f1',
        borderRadius:    4,
    }],
}));

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { ticks: { maxRotation: 45, font: { size: 11 } } },
        y: { beginAtZero: true, ticks: { precision: 0 } },
    },
};
</script>

<template>
    <Head title="Reactions" />
    <DashboardLayout>
        <template #title>Reactions</template>

        <!-- Summary -->
        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="rounded-xl border border-border bg-card p-5">
                <p class="text-xs uppercase tracking-wider text-muted-foreground">Total Hearts</p>
                <p class="mt-1 text-3xl font-bold text-foreground">{{ total ?? 0 }}</p>
            </div>
            <div class="rounded-xl border border-border bg-card p-5">
                <p class="text-xs uppercase tracking-wider text-muted-foreground">Pages Reacted</p>
                <p class="mt-1 text-3xl font-bold text-foreground">{{ (byPage ?? []).length }}</p>
            </div>
        </div>

        <!-- By-page chart -->
        <div v-if="byPage?.length" class="mb-6 rounded-xl border border-border bg-card p-5">
            <h3 class="mb-4 text-sm font-semibold text-muted-foreground uppercase tracking-wider">Hearts by Page</h3>
            <div class="h-56">
                <Bar :data="chartData" :options="chartOptions" />
            </div>
        </div>

        <!-- Feed -->
        <div class="rounded-xl border border-border bg-card">
            <div class="border-b border-border px-5 py-3">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Recent Reactions</h3>
            </div>
            <div class="divide-y divide-border">
                <div
                    v-for="reaction in reactions.data"
                    :key="reaction.id"
                    class="flex items-center gap-3 px-5 py-3"
                >
                    <span class="text-lg">❤️</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-foreground truncate">{{ reaction.page_url }}</p>
                        <p class="text-xs text-muted-foreground">{{ reaction.country ?? 'Unknown' }}</p>
                    </div>
                    <span class="text-xs text-muted-foreground shrink-0">
                        {{ new Date(reaction.created_at).toLocaleDateString() }}
                    </span>
                </div>
                <p v-if="!reactions.data?.length" class="py-10 text-center text-sm text-muted-foreground">
                    No reactions yet.
                </p>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="reactions.last_page > 1" class="mt-6 flex items-center justify-center gap-2">
            <Button
                v-for="page in reactions.last_page"
                :key="page"
                :variant="page === reactions.current_page ? 'default' : 'outline'"
                size="sm"
                @click="router.get(route('dashboard.reactions.index'), { page }, { preserveScroll: true })"
            >{{ page }}</Button>
        </div>
    </DashboardLayout>
</template>

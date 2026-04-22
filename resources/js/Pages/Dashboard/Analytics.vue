<script setup>
import { Head, router }   from '@inertiajs/vue3';
import { computed }        from 'vue';
import { Line, Bar, Doughnut } from 'vue-chartjs';
import {
    Chart as ChartJS,
    LineElement, BarElement, ArcElement,
    CategoryScale, LinearScale,
    PointElement, Tooltip, Legend, Filler,
} from 'chart.js';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import StatCard        from '@/Components/Dashboard/StatCard.vue';
import Button          from '@/Components/ui/Button.vue';

ChartJS.register(
    LineElement, BarElement, ArcElement,
    CategoryScale, LinearScale,
    PointElement, Tooltip, Legend, Filler,
);

const props = defineProps({
    stats:       Object,
    viewsByDay:  Array,
    topPages:    Array,
    topCountries: Array,
    days:        Number,
});

function setDays(d) {
    router.get(route('dashboard.analytics.index'), { days: d }, { preserveScroll: true });
}

// Views over time chart
const viewsChart = computed(() => ({
    labels: (props.viewsByDay ?? []).map(r => r.date),
    datasets: [{
        label:           'Page Views',
        data:            (props.viewsByDay ?? []).map(r => r.count),
        borderColor:     '#6366f1',
        backgroundColor: 'rgba(99,102,241,0.12)',
        tension:         0.4,
        fill:            true,
        pointRadius:     3,
    }],
}));

const lineOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        x: { ticks: { maxTicksLimit: 10, font: { size: 11 } } },
        y: { beginAtZero: true, ticks: { precision: 0 } },
    },
};

// Top pages chart
const pagesChart = computed(() => ({
    labels: (props.topPages ?? []).map(r => r.page_url),
    datasets: [{
        label:           'Views',
        data:            (props.topPages ?? []).map(r => r.count),
        backgroundColor: '#6366f1',
        borderRadius:    4,
    }],
}));

const barOptions = {
    responsive: true,
    maintainAspectRatio: false,
    indexAxis: 'y',
    plugins: { legend: { display: false } },
    scales: {
        x: { beginAtZero: true, ticks: { precision: 0 } },
        y: { ticks: { font: { size: 11 } } },
    },
};

// Countries chart
const countriesChart = computed(() => ({
    labels: (props.topCountries ?? []).map(r => r.country ?? 'Unknown'),
    datasets: [{
        data:            (props.topCountries ?? []).map(r => r.count),
        backgroundColor: [
            '#6366f1','#8b5cf6','#a78bfa','#c4b5fd','#ddd6fe',
            '#818cf8','#93c5fd','#6ee7b7','#fcd34d','#f87171',
        ],
    }],
}));

const doughnutOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { position: 'right', labels: { font: { size: 11 } } } },
};
</script>

<template>
    <Head title="Analytics" />
    <DashboardLayout>
        <template #title>Analytics</template>

        <!-- Day range toggle -->
        <div class="mb-6 flex items-center gap-2">
            <Button
                v-for="d in [7, 30, 90]"
                :key="d"
                :variant="days === d ? 'default' : 'outline'"
                size="sm"
                @click="setDays(d)"
            >{{ d }}d</Button>
        </div>

        <!-- Stat cards -->
        <div class="mb-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
            <StatCard label="Total Views"     :value="stats?.total_views ?? 0"     icon="👁"  color="indigo" />
            <StatCard label="Unique Visitors" :value="stats?.unique_visitors ?? 0" icon="👤"  color="violet" />
            <StatCard label="Countries"       :value="stats?.total_countries ?? 0" icon="🌍"  color="sky" />
            <StatCard label="Avg / Day"       :value="stats?.avg_per_day ?? 0"     icon="📈"  color="emerald" />
        </div>

        <!-- Views over time -->
        <div class="mb-6 rounded-xl border border-border bg-card p-5">
            <h3 class="mb-4 text-sm font-semibold text-muted-foreground uppercase tracking-wider">Views Over Time</h3>
            <div class="h-60">
                <Line :data="viewsChart" :options="lineOptions" />
            </div>
        </div>

        <!-- Bottom 2 charts -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Top pages -->
            <div class="rounded-xl border border-border bg-card p-5">
                <h3 class="mb-4 text-sm font-semibold text-muted-foreground uppercase tracking-wider">Top Pages</h3>
                <div class="h-56">
                    <Bar :data="pagesChart" :options="barOptions" />
                </div>
            </div>

            <!-- Top countries -->
            <div class="rounded-xl border border-border bg-card p-5">
                <h3 class="mb-4 text-sm font-semibold text-muted-foreground uppercase tracking-wider">Top Countries</h3>
                <div class="h-56">
                    <Doughnut :data="countriesChart" :options="doughnutOptions" />
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

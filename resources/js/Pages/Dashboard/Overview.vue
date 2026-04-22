<script setup>
import { Head }      from '@inertiajs/vue3';
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import StatCard        from '@/Components/Dashboard/StatCard.vue';
import { ref, onMounted } from 'vue';
import { Line, Bar }  from 'vue-chartjs';
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, BarElement, Tooltip, Legend } from 'chart.js';

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, BarElement, Tooltip, Legend);

const props = defineProps({
    stats:  Object,
    charts: Object,
});

const lineData = ref({
    labels:   Object.keys(props.charts?.views_per_day ?? {}),
    datasets: [{
        label: 'Page Views',
        data:  Object.values(props.charts?.views_per_day ?? {}),
        borderColor: '#6366f1',
        backgroundColor: 'rgba(99,102,241,0.1)',
        tension: 0.4,
        fill: true,
    }],
});

const barData = ref({
    labels:   Object.keys(props.charts?.top_pages ?? {}).map(p => '/' + p.replace(/^\//, '')).slice(0, 5),
    datasets: [{
        label: 'Views',
        data:  Object.values(props.charts?.top_pages ?? {}).slice(0, 5),
        backgroundColor: '#6366f1',
        borderRadius: 6,
    }],
});

const chartOptions = { responsive: true, plugins: { legend: { display: false } } };
</script>

<template>
    <Head title="Dashboard" />

    <DashboardLayout>
        <template #title>Overview</template>

        <!-- Stats grid -->
        <div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-3 xl:grid-cols-5">
            <StatCard label="Total Views"      :value="stats.total_views"      icon="👁️"  color="violet" />
            <StatCard label="Unique Visitors"  :value="stats.unique_visitors"  icon="👥"  color="blue" />
            <StatCard label="Hearts"           :value="stats.total_hearts"     icon="❤️"  color="rose" />
            <StatCard label="Messages"         :value="stats.total_messages"   icon="✉️"  color="emerald" :sub="stats.unread_messages + ' unread'" />
            <StatCard label="Conversion"       :value="stats.conversion_rate + '%'" icon="📈" color="amber" />
        </div>

        <!-- Charts -->
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 rounded-xl border border-border bg-card p-5">
                <h3 class="mb-4 text-sm font-semibold text-foreground">Page Views (Last 30 Days)</h3>
                <Line :data="lineData" :options="chartOptions" />
            </div>
            <div class="rounded-xl border border-border bg-card p-5">
                <h3 class="mb-4 text-sm font-semibold text-foreground">Top Pages</h3>
                <Bar :data="barData" :options="chartOptions" />
            </div>
        </div>

        <!-- Quick links -->
        <div class="mt-6 grid gap-4 sm:grid-cols-3">
            <Link :href="route('dashboard.messages.index')" class="rounded-xl border border-border bg-card p-4 hover:bg-muted transition-colors">
                <p class="text-2xl font-bold text-foreground">{{ stats.unread_messages }}</p>
                <p class="mt-1 text-sm text-muted-foreground">Unread messages</p>
            </Link>
            <Link :href="route('dashboard.projects.index')" class="rounded-xl border border-border bg-card p-4 hover:bg-muted transition-colors">
                <p class="text-2xl font-bold text-foreground">→</p>
                <p class="mt-1 text-sm text-muted-foreground">Manage projects</p>
            </Link>
            <Link :href="route('dashboard.analytics.index')" class="rounded-xl border border-border bg-card p-4 hover:bg-muted transition-colors">
                <p class="text-2xl font-bold text-foreground">→</p>
                <p class="mt-1 text-sm text-muted-foreground">Full analytics</p>
            </Link>
        </div>
    </DashboardLayout>
</template>

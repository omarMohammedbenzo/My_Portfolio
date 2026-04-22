<script setup>
import { computed } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import { useTranslations } from '@/composables/useTranslations';

const { t } = useTranslations();
const page  = usePage();

const currentRoute = computed(() => route().current());

const navGroups = [
    {
        label: 'Content',
        items: [
            { label: 'Overview',      icon: '⊞', route: 'dashboard.index' },
            { label: 'Personal Info', icon: '👤', route: 'dashboard.personal-info.edit' },
            { label: 'Experiences',   icon: '💼', route: 'dashboard.experiences.index' },
            { label: 'Educations',    icon: '🎓', route: 'dashboard.educations.index' },
            { label: 'Skills',        icon: '⚡', route: 'dashboard.skills.index' },
            { label: 'Projects',      icon: '🗂️', route: 'dashboard.projects.index' },
        ],
    },
    {
        label: 'Inbox',
        items: [
            { label: 'Messages',  icon: '✉️', route: 'dashboard.messages.index' },
            { label: 'Reactions', icon: '❤️', route: 'dashboard.reactions.index' },
        ],
    },
    {
        label: 'Insights',
        items: [
            { label: 'Analytics', icon: '📊', route: 'dashboard.analytics.index' },
            { label: 'Settings',  icon: '⚙️', route: 'dashboard.settings.edit' },
        ],
    },
];

function isActive(routeName) {
    return route().current(routeName) || route().current(routeName + '.*');
}

function logout() {
    router.post(route('logout'));
}
</script>

<template>
    <aside class="flex h-full w-60 flex-col border-e border-border bg-card">
        <!-- Brand -->
        <div class="flex h-14 items-center gap-2 border-b border-border px-4">
            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary text-xs font-bold text-primary-foreground">
                OM
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-foreground">Dashboard</p>
                <p class="truncate text-xs text-muted-foreground">Portfolio Admin</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-2 py-3">
            <div v-for="group in navGroups" :key="group.label" class="mb-4">
                <p class="mb-1 px-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                    {{ group.label }}
                </p>
                <ul class="space-y-0.5">
                    <li v-for="item in group.items" :key="item.route">
                        <Link
                            :href="route(item.route)"
                            :class="[
                                'flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm transition-colors',
                                isActive(item.route)
                                    ? 'bg-primary/10 text-primary font-medium'
                                    : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                            ]"
                        >
                            <span class="text-base leading-none">{{ item.icon }}</span>
                            {{ item.label }}
                        </Link>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Footer -->
        <div class="border-t border-border p-3">
            <div class="mb-2 flex items-center gap-2 px-2">
                <div class="h-7 w-7 rounded-full bg-primary/20 flex items-center justify-center text-xs font-bold text-primary">
                    O
                </div>
                <div class="min-w-0">
                    <p class="truncate text-xs font-medium text-foreground">Omar Sultan</p>
                    <p class="truncate text-xs text-muted-foreground">Admin</p>
                </div>
            </div>
            <button
                type="button"
                class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm text-muted-foreground hover:bg-muted hover:text-foreground transition-colors"
                @click="logout"
            >
                <span>🚪</span> Logout
            </button>
        </div>
    </aside>
</template>

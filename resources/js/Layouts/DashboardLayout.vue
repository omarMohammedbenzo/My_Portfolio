<script setup>
import { computed, onMounted } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import Sidebar from '@/Components/Dashboard/Sidebar.vue';
import Toast   from '@/Components/Dashboard/Toast.vue';
import { useDarkMode } from '@/composables/useDarkMode';

const { isDark, toggle, init } = useDarkMode();
const page = usePage();

const locale  = computed(() => page.props.locale);
const locales = computed(() => page.props.locales ?? ['en', 'ar']);

onMounted(() => init());
</script>

<template>
    <div class="flex h-screen overflow-hidden bg-background text-foreground">
        <Sidebar />

        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Top bar -->
            <header class="flex h-14 shrink-0 items-center justify-between border-b border-border bg-card px-6">
                <h1 class="text-sm font-semibold text-foreground">
                    <slot name="title">Dashboard</slot>
                </h1>

                <div class="flex items-center gap-3">
                    <!-- Language switcher -->
                    <div class="flex items-center gap-1 rounded-lg border border-border p-1">
                        <a
                            v-for="loc in locales"
                            :key="loc"
                            :href="route('set-locale', loc)"
                            :class="[
                                'rounded px-2 py-0.5 text-xs font-medium transition-colors',
                                locale === loc
                                    ? 'bg-primary text-primary-foreground'
                                    : 'text-muted-foreground hover:text-foreground',
                            ]"
                        >
                            {{ loc.toUpperCase() }}
                        </a>
                    </div>

                    <!-- Dark mode -->
                    <button
                        type="button"
                        class="rounded-lg p-2 text-muted-foreground hover:bg-muted hover:text-foreground transition-colors"
                        @click="toggle"
                    >
                        <span>{{ isDark ? '☀️' : '🌙' }}</span>
                    </button>

                    <!-- View site -->
                    <a
                        :href="route('home', locale)"
                        target="_blank"
                        class="rounded-lg p-2 text-muted-foreground hover:bg-muted hover:text-foreground transition-colors text-sm"
                    >
                        ↗ View Site
                    </a>
                </div>
            </header>

            <!-- Main content -->
            <main class="flex-1 overflow-y-auto p-6">
                <slot />
            </main>
        </div>

        <Toast />
    </div>
</template>

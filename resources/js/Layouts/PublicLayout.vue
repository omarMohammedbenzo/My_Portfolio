<script setup>
import { ref }              from 'vue';
import { Link }             from '@inertiajs/vue3';
import { useTranslations }  from '@/composables/useTranslations';
import { useDarkMode }      from '@/composables/useDarkMode';
import { useLocaleRoute }   from '@/composables/useLocaleRoute';

const { t, locale }  = useTranslations();
const { toggle, isDark } = useDarkMode();
const lroute         = useLocaleRoute();
const mobileOpen     = ref(false);

const navLinks = [
    { key: 'nav.home',     name: 'home' },
    { key: 'nav.about',    name: 'about' },
    { key: 'nav.projects', name: 'projects.index' },
    { key: 'nav.contact',  name: 'contact' },
];

function switchLocale(loc) {
    const current = window.location.pathname.replace(/^\/(en|ar)/, '');
    window.location.href = `/${loc}${current || '/'}`;
}
</script>

<template>
    <div class="min-h-screen bg-background text-foreground">
        <!-- Navbar -->
        <header class="sticky top-0 z-40 border-b border-border bg-background/80 backdrop-blur-sm">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
                <!-- Logo -->
                <Link :href="lroute('home')" class="text-lg font-bold text-foreground">
                    Omar.dev
                </Link>

                <!-- Desktop nav -->
                <nav class="hidden md:flex items-center gap-6">
                    <Link
                        v-for="link in navLinks"
                        :key="link.name"
                        :href="lroute(link.name)"
                        class="text-sm text-muted-foreground hover:text-foreground transition-colors"
                        :class="{ 'text-foreground font-medium': route().current(link.name + '*') }"
                    >{{ t(link.key) }}</Link>
                </nav>

                <!-- Right controls -->
                <div class="flex items-center gap-2">
                    <!-- Language switcher -->
                    <button
                        class="rounded-md px-2 py-1 text-xs font-medium text-muted-foreground hover:text-foreground hover:bg-muted transition-colors"
                        @click="switchLocale(locale() === 'en' ? 'ar' : 'en')"
                    >{{ locale() === 'en' ? 'عربي' : 'EN' }}</button>

                    <!-- Dark mode -->
                    <button
                        class="rounded-md p-1.5 text-muted-foreground hover:text-foreground hover:bg-muted transition-colors"
                        :title="isDark ? 'Light mode' : 'Dark mode'"
                        @click="toggle"
                    >{{ isDark ? '☀️' : '🌙' }}</button>

                    <!-- Mobile menu toggle -->
                    <button
                        class="md:hidden rounded-md p-1.5 text-muted-foreground hover:text-foreground hover:bg-muted"
                        @click="mobileOpen = !mobileOpen"
                    >☰</button>
                </div>
            </div>

            <!-- Mobile nav -->
            <div v-if="mobileOpen" class="md:hidden border-t border-border px-4 py-3 space-y-1">
                <Link
                    v-for="link in navLinks"
                    :key="link.name"
                    :href="lroute(link.name)"
                    class="block rounded-md px-3 py-2 text-sm text-muted-foreground hover:text-foreground hover:bg-muted"
                    @click="mobileOpen = false"
                >{{ t(link.key) }}</Link>
            </div>
        </header>

        <!-- Page content -->
        <main>
            <slot />
        </main>

        <!-- Footer -->
        <footer class="border-t border-border py-8">
            <div class="mx-auto max-w-6xl px-4 text-center text-sm text-muted-foreground">
                <p>© {{ new Date().getFullYear() }} Omar Mohammed. Built with Laravel &amp; Vue.</p>
            </div>
        </footer>
    </div>
</template>

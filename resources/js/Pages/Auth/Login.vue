<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { useDarkMode }    from '@/composables/useDarkMode';
import { onMounted }      from 'vue';

const { isDark, toggle, init } = useDarkMode();
onMounted(() => init());

const form = useForm({ email: '', password: '', remember: false });

function submit() {
    form.post(route('login'), { onFinish: () => form.reset('password') });
}
</script>

<template>
    <Head title="Login" />

    <div class="flex min-h-screen items-center justify-center bg-background px-4">
        <div class="w-full max-w-sm">
            <!-- Brand -->
            <div class="mb-8 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-primary text-lg font-bold text-primary-foreground">
                    OM
                </div>
                <h1 class="text-xl font-bold text-foreground">Portfolio Admin</h1>
                <p class="mt-1 text-sm text-muted-foreground">Sign in to your dashboard</p>
            </div>

            <form @submit.prevent="submit" class="rounded-xl border border-border bg-card p-6 shadow-sm space-y-4">
                <!-- Email -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-foreground">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        class="flex h-9 w-full rounded-md border border-border bg-transparent px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                        :class="form.errors.email ? 'border-destructive' : ''"
                        required
                    />
                    <p v-if="form.errors.email" class="mt-1 text-xs text-destructive">{{ form.errors.email }}</p>
                </div>

                <!-- Password -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-foreground">Password</label>
                    <input
                        v-model="form.password"
                        type="password"
                        autocomplete="current-password"
                        class="flex h-9 w-full rounded-md border border-border bg-transparent px-3 py-1 text-sm shadow-sm focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring"
                        required
                    />
                </div>

                <!-- Remember -->
                <div class="flex items-center gap-2">
                    <input id="remember" v-model="form.remember" type="checkbox" class="h-4 w-4 rounded border-border" />
                    <label for="remember" class="text-sm text-muted-foreground">Remember me</label>
                </div>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded-md bg-primary py-2 text-sm font-medium text-primary-foreground hover:opacity-90 disabled:opacity-50 transition-opacity"
                >
                    {{ form.processing ? 'Signing in…' : 'Sign In' }}
                </button>
            </form>

            <div class="mt-4 flex justify-center">
                <button type="button" @click="toggle" class="text-xs text-muted-foreground hover:text-foreground">
                    {{ isDark ? '☀️ Light mode' : '🌙 Dark mode' }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head }            from '@inertiajs/vue3';
import { useForm }         from '@inertiajs/vue3';
import PublicLayout        from '@/Layouts/PublicLayout.vue';
import { useLocaleRoute }  from '@/composables/useLocaleRoute';
import HeartButton         from '@/Components/HeartButton.vue';
import Input               from '@/Components/ui/Input.vue';
import { useTranslations } from '@/composables/useTranslations';

const props = defineProps({ personalInfo: Object });

const { t } = useTranslations();
const lroute = useLocaleRoute();

const form = useForm({
    name:    '',
    email:   '',
    subject: '',
    message: '',
});

function submit() {
    form.post(lroute('contact.store'), {
        onSuccess: () => form.reset(),
    });
}
</script>

<template>
    <Head :title="t('nav.contact')" />
    <PublicLayout>

        <!-- Header -->
        <section class="py-16 text-center">
            <div class="mx-auto max-w-2xl px-4">
                <p class="mb-3 text-sm font-medium text-primary">{{ t('contact.label') }}</p>
                <h1 class="text-4xl font-bold text-foreground">{{ t('contact.title') }}</h1>
                <p class="mt-4 text-muted-foreground">{{ t('contact.subtitle') }}</p>
            </div>
        </section>

        <!-- Content -->
        <section class="pb-24">
            <div class="mx-auto max-w-5xl px-4">
                <div class="grid gap-12 lg:grid-cols-5">

                    <!-- Info -->
                    <div class="lg:col-span-2 space-y-6"
                        v-motion
                        :initial="{ opacity: 0, x: -20 }"
                        :enter="{ opacity: 1, x: 0, transition: { duration: 500 } }"
                    >
                        <div>
                            <h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-muted-foreground">
                                {{ t('contact.info_title') }}
                            </h3>
                            <div class="space-y-3">
                                <a
                                    v-if="personalInfo?.email"
                                    :href="`mailto:${personalInfo.email}`"
                                    class="flex items-center gap-3 text-sm text-muted-foreground hover:text-foreground transition-colors"
                                >
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-muted text-base">✉️</span>
                                    {{ personalInfo.email }}
                                </a>
                                <a
                                    v-if="personalInfo?.socials?.github"
                                    :href="personalInfo.socials.github"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-3 text-sm text-muted-foreground hover:text-foreground transition-colors"
                                >
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-muted text-base">⌥</span>
                                    GitHub
                                </a>
                                <a
                                    v-if="personalInfo?.socials?.linkedin"
                                    :href="personalInfo.socials.linkedin"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center gap-3 text-sm text-muted-foreground hover:text-foreground transition-colors"
                                >
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-muted text-base">💼</span>
                                    LinkedIn
                                </a>
                            </div>
                        </div>

                        <div class="rounded-xl border border-border bg-card p-5">
                            <p class="text-sm text-muted-foreground leading-relaxed">{{ t('contact.response_note') }}</p>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="lg:col-span-3"
                        v-motion
                        :initial="{ opacity: 0, x: 20 }"
                        :enter="{ opacity: 1, x: 0, transition: { duration: 500, delay: 100 } }"
                    >
                        <!-- Success -->
                        <div
                            v-if="$page.props.flash?.success"
                            class="mb-6 rounded-xl border border-green-200 bg-green-50 dark:border-green-800 dark:bg-green-950 px-5 py-4 text-sm text-green-700 dark:text-green-300"
                        >
                            {{ $page.props.flash.success }}
                        </div>

                        <form @submit.prevent="submit" class="space-y-4">
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-foreground">{{ t('contact.name') }} *</label>
                                    <Input v-model="form.name" :error="form.errors.name" :placeholder="t('contact.name_placeholder')" />
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-foreground">{{ t('contact.email') }} *</label>
                                    <Input v-model="form.email" type="email" :error="form.errors.email" :placeholder="t('contact.email_placeholder')" />
                                </div>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-foreground">{{ t('contact.subject') }}</label>
                                <Input v-model="form.subject" :placeholder="t('contact.subject_placeholder')" />
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-foreground">{{ t('contact.message') }} *</label>
                                <textarea
                                    v-model="form.message"
                                    rows="6"
                                    :placeholder="t('contact.message_placeholder')"
                                    class="w-full rounded-lg border px-3 py-2.5 text-sm bg-background text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/50 resize-y transition-colors"
                                    :class="form.errors.message ? 'border-destructive' : 'border-border'"
                                />
                                <p v-if="form.errors.message" class="mt-1 text-xs text-destructive">{{ form.errors.message }}</p>
                            </div>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full rounded-lg bg-primary px-6 py-3 text-sm font-medium text-primary-foreground hover:opacity-90 transition-opacity disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                {{ form.processing ? t('contact.sending') : t('contact.send') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <HeartButton />
    </PublicLayout>
</template>

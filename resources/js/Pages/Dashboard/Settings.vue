<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import DashboardLayout   from '@/Layouts/DashboardLayout.vue';
import Button            from '@/Components/ui/Button.vue';
import Input             from '@/Components/ui/Input.vue';

const props = defineProps({ settings: Object });

const form = useForm({ ...props.settings });

function submit() {
    form.put(route('dashboard.settings.update'), { preserveScroll: true });
}
</script>

<template>
    <Head title="Settings" />
    <DashboardLayout>
        <template #title>Settings</template>

        <form @submit.prevent="submit" class="max-w-2xl space-y-6">
            <!-- Images -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Images</h3>

                <div>
                    <label class="mb-1.5 block text-sm font-medium">Hero Image Path</label>
                    <Input v-model="form.hero_image" placeholder="images/about/hero-cafe.jpg" />
                    <p class="mt-1 text-xs text-muted-foreground">Relative to /public/</p>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Hero Image Alt Text</label>
                    <Input v-model="form.hero_image_alt" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">About Image 1 Path</label>
                    <Input v-model="form.about_image_1" placeholder="images/about/about-coding-1.jpg" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">About Image 1 Alt Text</label>
                    <Input v-model="form.about_image_1_alt" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">About Image 2 Path</label>
                    <Input v-model="form.about_image_2" placeholder="images/about/about-coding-2.jpg" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">About Image 2 Alt Text</label>
                    <Input v-model="form.about_image_2_alt" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">OG Image URL (absolute)</label>
                    <Input v-model="form.og_image" type="url" placeholder="https://yourdomain.com/images/og.jpg" />
                    <p class="mt-1 text-xs text-muted-foreground">Must be an absolute URL for social media scrapers.</p>
                </div>
            </div>

            <!-- SEO -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">SEO</h3>

                <div>
                    <label class="mb-1.5 block text-sm font-medium">Site Name</label>
                    <Input v-model="form.site_name" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Meta Description (EN)</label>
                    <Input v-model="form.meta_description_en" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Meta Description (AR)</label>
                    <Input v-model="form.meta_description_ar" dir="rtl" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Twitter Handle</label>
                    <Input v-model="form.twitter_handle" placeholder="@yourhandle" />
                </div>
            </div>

            <!-- Telegram -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Telegram Notifications</h3>
                <p class="text-xs text-muted-foreground">Configure in <code class="font-mono bg-muted px-1 rounded">.env</code> for security. Values here are display-only overrides stored in DB.</p>

                <div>
                    <label class="mb-1.5 block text-sm font-medium">Bot Token</label>
                    <Input v-model="form.telegram_bot_token" placeholder="Leave blank to use .env value" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Chat ID</label>
                    <Input v-model="form.telegram_chat_id" placeholder="Leave blank to use .env value" />
                </div>
                <div class="flex items-center gap-2">
                    <input id="tg_enabled" v-model="form.telegram_enabled" type="checkbox" class="accent-primary" />
                    <label for="tg_enabled" class="text-sm font-medium">Enable Telegram notifications</label>
                </div>
            </div>

            <!-- General -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">General</h3>

                <div>
                    <label class="mb-1.5 block text-sm font-medium">CV File (EN) Path</label>
                    <Input v-model="form.cv_path_en" placeholder="cv/omar-en.pdf" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">CV File (AR) Path</label>
                    <Input v-model="form.cv_path_ar" placeholder="cv/omar-ar.pdf" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Contact Email</label>
                    <Input v-model="form.contact_email" type="email" />
                </div>
            </div>

            <div class="flex justify-end">
                <Button type="submit" :disabled="form.processing">{{ form.processing ? 'Saving…' : 'Save Settings' }}</Button>
            </div>
        </form>
    </DashboardLayout>
</template>

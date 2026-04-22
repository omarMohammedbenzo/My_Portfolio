<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref }          from 'vue';
import { Icon }                   from '@iconify/vue';
import DashboardLayout            from '@/Layouts/DashboardLayout.vue';
import Button                     from '@/Components/ui/Button.vue';
import Input                      from '@/Components/ui/Input.vue';

const props = defineProps({ settings: Object, themes: Object });

// Flatten all settings into one form — controller accepts flat keys
const form = useForm({ ...props.settings });

function submit() {
    form.put(route('dashboard.settings.update'), { preserveScroll: true });
}

// ── Theme picker ──────────────────────────────────────────────────────────
const themeList = computed(() =>
    Object.entries(props.themes ?? {}).map(([key, t]) => ({ key, ...t }))
);

// ── Stat JSON helpers ─────────────────────────────────────────────────────
// Stats are stored as { value, label: { en, ar } } — expose flat editable fields
function statVal(key)      { return form[key]?.value ?? ''; }
function statLabelEn(key)  { return form[key]?.label?.en ?? ''; }
function statLabelAr(key)  { return form[key]?.label?.ar ?? ''; }

function setStatVal(key, v)     { form[key] = { ...(form[key] ?? {}), value: v, label: form[key]?.label ?? {} }; }
function setStatLabelEn(key, v) { form[key] = { ...(form[key] ?? {}), label: { ...(form[key]?.label ?? {}), en: v } }; }
function setStatLabelAr(key, v) { form[key] = { ...(form[key] ?? {}), label: { ...(form[key]?.label ?? {}), ar: v } }; }

// ── Translatable JSON helpers ─────────────────────────────────────────────
function transEn(key)     { return form[key]?.en ?? ''; }
function transAr(key)     { return form[key]?.ar ?? ''; }
function setTransEn(key, v) { form[key] = { ...(form[key] ?? {}), en: v }; }
function setTransAr(key, v) { form[key] = { ...(form[key] ?? {}), ar: v }; }

// ── Rotating titles JSON array helpers ───────────────────────────────────
function rotatingEn() { return (form.hero_rotating_titles?.en ?? []).join('\n'); }
function rotatingAr() { return (form.hero_rotating_titles?.ar ?? []).join('\n'); }
function setRotatingEn(v) {
    form.hero_rotating_titles = { ...(form.hero_rotating_titles ?? {}), en: v.split('\n').map(s => s.trim()).filter(Boolean) };
}
function setRotatingAr(v) {
    form.hero_rotating_titles = { ...(form.hero_rotating_titles ?? {}), ar: v.split('\n').map(s => s.trim()).filter(Boolean) };
}
</script>

<template>
    <Head title="Settings" />
    <DashboardLayout>
        <template #title>Settings</template>

        <form @submit.prevent="submit" class="max-w-2xl space-y-6">

            <!-- ── Appearance ──────────────────────────────────────────────── -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-5">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Appearance</h3>

                <!-- Theme picker -->
                <div>
                    <label class="mb-3 block text-sm font-medium">Active Theme</label>
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                        <button
                            v-for="theme in themeList"
                            :key="theme.key"
                            type="button"
                            class="rounded-xl border-2 p-3 text-center transition-all duration-150"
                            :class="form.active_theme === theme.key
                                ? 'border-primary ring-2 ring-primary/30'
                                : 'border-border hover:border-muted-foreground'"
                            @click="form.active_theme = theme.key"
                        >
                            <!-- Gradient swatch -->
                            <div
                                class="mx-auto mb-2 h-8 w-full rounded-lg"
                                :style="{ background: `linear-gradient(135deg, ${theme.primary}, ${theme.secondary})` }"
                            />
                            <span class="text-xs font-semibold text-foreground">{{ theme.name }}</span>
                        </button>
                    </div>
                </div>

                <!-- Mascot -->
                <div class="flex items-center gap-3">
                    <input id="mascot_enabled" v-model="form.mascot_enabled" type="checkbox" class="h-4 w-4 accent-primary" />
                    <label for="mascot_enabled" class="text-sm font-medium">Show mascot animation</label>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Mascot Lottie URL</label>
                    <Input v-model="form.mascot_animation_url" placeholder="/lottie/mascot.json" />
                    <p class="mt-1 text-xs text-muted-foreground">Path relative to /public/ or a full URL to a Lottie JSON file.</p>
                </div>
            </div>

            <!-- ── Hero & Home Page ────────────────────────────────────────── -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-5">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Hero &amp; Home Page</h3>

                <!-- Eyebrow -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Eyebrow Text (EN)</label>
                    <Input :value="transEn('hero_eyebrow')" @input="setTransEn('hero_eyebrow', $event.target.value)" placeholder="Hi, I'm Omar 👋" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Eyebrow Text (AR)</label>
                    <Input :value="transAr('hero_eyebrow')" @input="setTransAr('hero_eyebrow', $event.target.value)" dir="rtl" />
                </div>

                <!-- Title template -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Title Template (EN) — use {role} placeholder</label>
                    <Input :value="transEn('hero_title_template')" @input="setTransEn('hero_title_template', $event.target.value)" placeholder="I'm a {role} Developer" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Title Template (AR)</label>
                    <Input :value="transAr('hero_title_template')" @input="setTransAr('hero_title_template', $event.target.value)" dir="rtl" />
                </div>

                <!-- Rotating titles -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Rotating Words (EN) — one per line</label>
                    <textarea
                        class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm font-mono text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                        rows="4"
                        :value="rotatingEn()"
                        @input="setRotatingEn($event.target.value)"
                        placeholder="Full-Stack&#10;Backend&#10;Frontend"
                    />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Rotating Words (AR) — one per line</label>
                    <textarea
                        class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm font-mono text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                        rows="4"
                        dir="rtl"
                        :value="rotatingAr()"
                        @input="setRotatingAr($event.target.value)"
                    />
                </div>

                <!-- Tagline -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Hero Tagline (EN)</label>
                    <Input :value="transEn('hero_tagline')" @input="setTransEn('hero_tagline', $event.target.value)" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Hero Tagline (AR)</label>
                    <Input :value="transAr('hero_tagline')" @input="setTransAr('hero_tagline', $event.target.value)" dir="rtl" />
                </div>

                <!-- About brief -->
                <div>
                    <label class="mb-1.5 block text-sm font-medium">About Brief (EN)</label>
                    <textarea
                        class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                        rows="5"
                        :value="transEn('about_brief')"
                        @input="setTransEn('about_brief', $event.target.value)"
                    />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">About Brief (AR)</label>
                    <textarea
                        class="w-full rounded-md border border-border bg-background px-3 py-2 text-sm text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                        rows="5"
                        dir="rtl"
                        :value="transAr('about_brief')"
                        @input="setTransAr('about_brief', $event.target.value)"
                    />
                </div>

                <!-- Stats -->
                <div class="grid gap-4 sm:grid-cols-2">
                    <div v-for="statKey in ['stat_experience', 'stat_projects', 'stat_technologies', 'stat_languages']" :key="statKey"
                        class="rounded-lg border border-border p-3 space-y-2">
                        <p class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ statKey.replace('stat_', '') }}</p>
                        <div>
                            <label class="mb-1 block text-xs text-muted-foreground">Value</label>
                            <Input :value="statVal(statKey)" @input="setStatVal(statKey, $event.target.value)" placeholder="4+" class="text-sm" />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs text-muted-foreground">Label (EN)</label>
                            <Input :value="statLabelEn(statKey)" @input="setStatLabelEn(statKey, $event.target.value)" class="text-sm" />
                        </div>
                        <div>
                            <label class="mb-1 block text-xs text-muted-foreground">Label (AR)</label>
                            <Input :value="statLabelAr(statKey)" @input="setStatLabelAr(statKey, $event.target.value)" dir="rtl" class="text-sm" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Images ──────────────────────────────────────────────────── -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Images</h3>

                <div>
                    <label class="mb-1.5 block text-sm font-medium">Hero Image Path</label>
                    <Input v-model="form.hero_image" placeholder="images/about/hero-cafe.jpg" />
                    <p class="mt-1 text-xs text-muted-foreground">Relative to /public/</p>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">About Image 1 Path</label>
                    <Input v-model="form.about_image_1" placeholder="images/about/about-coding-1.jpg" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">About Image 2 Path</label>
                    <Input v-model="form.about_image_2" placeholder="images/about/about-coding-2.jpg" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">OG Image (absolute URL)</label>
                    <Input v-model="form.og_image" placeholder="https://yourdomain.com/images/og.jpg" />
                </div>
            </div>

            <!-- ── SEO ─────────────────────────────────────────────────────── -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">SEO</h3>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Meta Description (EN)</label>
                    <Input :value="transEn('seo_default_desc')" @input="setTransEn('seo_default_desc', $event.target.value)" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Meta Description (AR)</label>
                    <Input :value="transAr('seo_default_desc')" @input="setTransAr('seo_default_desc', $event.target.value)" dir="rtl" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">SEO Keywords</label>
                    <Input v-model="form.seo_keywords" />
                </div>
            </div>

            <!-- ── Telegram ────────────────────────────────────────────────── -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">Telegram Notifications</h3>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Bot Token</label>
                    <Input v-model="form.telegram_bot_token" placeholder="Leave blank to use .env value" />
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Chat ID</label>
                    <Input v-model="form.telegram_chat_id" />
                </div>
                <div class="flex items-center gap-2">
                    <input id="tg_enabled" v-model="form.telegram_enabled" type="checkbox" class="accent-primary" />
                    <label for="tg_enabled" class="text-sm font-medium">Enable Telegram notifications</label>
                </div>
            </div>

            <!-- ── General ─────────────────────────────────────────────────── -->
            <div class="rounded-xl border border-border bg-card p-5 space-y-4">
                <h3 class="text-sm font-semibold text-muted-foreground uppercase tracking-wider">General</h3>
                <div>
                    <label class="mb-1.5 block text-sm font-medium">Contact Email</label>
                    <Input v-model="form.contact_email" type="email" />
                </div>
                <div class="flex items-center gap-2">
                    <input id="cv_active" v-model="form.cv_active" type="checkbox" class="accent-primary" />
                    <label for="cv_active" class="text-sm font-medium">CV download enabled</label>
                </div>
            </div>

            <div class="flex justify-end">
                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Saving…' : 'Save All Settings' }}
                </Button>
            </div>
        </form>
    </DashboardLayout>
</template>

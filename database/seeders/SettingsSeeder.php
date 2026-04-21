<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [

            // ── Images ───────────────────────────────────────────────────────
            ['key' => 'hero_image',        'group' => 'images', 'value' => 'images/about/hero-cafe.jpg'],
            ['key' => 'hero_image_webp',   'group' => 'images', 'value' => 'images/about/hero-cafe.webp'],
            ['key' => 'hero_image_alt',    'group' => 'images', 'value' => ['en' => 'Omar Mohammed Sultan — Full-Stack Developer', 'ar' => 'عمر محمد سلطان — مطور ويب متكامل']],

            ['key' => 'about_image_1',     'group' => 'images', 'value' => 'images/about/about-coding-1.jpg'],
            ['key' => 'about_image_1_webp','group' => 'images', 'value' => 'images/about/about-coding-1.webp'],
            ['key' => 'about_image_1_alt', 'group' => 'images', 'value' => ['en' => 'Omar coding at work', 'ar' => 'عمر يبرمج في العمل']],

            ['key' => 'about_image_2',     'group' => 'images', 'value' => 'images/about/about-coding-2.jpg'],
            ['key' => 'about_image_2_webp','group' => 'images', 'value' => 'images/about/about-coding-2.webp'],
            ['key' => 'about_image_2_alt', 'group' => 'images', 'value' => ['en' => 'Omar at the office', 'ar' => 'عمر في المكتب']],

            // og:image must be an absolute URL — placeholder until APP_URL is set on production
            ['key' => 'og_image', 'group' => 'images', 'value' => 'images/about/about-coding-2.jpg'],

            // ── SEO ──────────────────────────────────────────────────────────
            ['key' => 'seo_site_name',        'group' => 'seo', 'value' => ['en' => 'Omar Mohammed Sultan', 'ar' => 'عمر محمد سلطان']],
            ['key' => 'seo_default_title',    'group' => 'seo', 'value' => ['en' => 'Omar Mohammed Sultan — Full-Stack Web Developer', 'ar' => 'عمر محمد سلطان — مطور ويب متكامل']],
            ['key' => 'seo_default_desc',     'group' => 'seo', 'value' => ['en' => 'Full-Stack Web Developer specializing in Laravel & Vue.js. 4 years building scalable web applications, CRMs, and integrations.', 'ar' => 'مطور ويب متكامل متخصص في Laravel وVue.js. 4 سنوات في بناء تطبيقات ويب قابلة للتوسع وأنظمة CRM والتكاملات.']],
            ['key' => 'seo_keywords',         'group' => 'seo', 'value' => 'Full-Stack Developer, Laravel Developer, Vue.js, PHP, Web Developer Cairo, Software Engineer'],

            // ── CV PDF ───────────────────────────────────────────────────────
            ['key' => 'cv_active', 'group' => 'general', 'value' => true],

            // ── Telegram ─────────────────────────────────────────────────────
            ['key' => 'telegram_enabled',  'group' => 'telegram', 'value' => false],
            ['key' => 'telegram_bot_token','group' => 'telegram', 'value' => null],
            ['key' => 'telegram_chat_id',  'group' => 'telegram', 'value' => null],

            // ── General ──────────────────────────────────────────────────────
            ['key' => 'site_active',       'group' => 'general', 'value' => true],
            ['key' => 'contact_email',     'group' => 'general', 'value' => 'umar27.11.2001@gmail.com'],
            ['key' => 'google_analytics',  'group' => 'general', 'value' => null],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(
                ['key' => $s['key']],
                ['value' => $s['value'], 'group' => $s['group']]
            );
        }

        $this->command->info('Settings seeded: ' . count($settings));
    }
}

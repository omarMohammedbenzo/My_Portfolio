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

            // ── Appearance ───────────────────────────────────────────────────
            ['key' => 'active_theme',          'group' => 'appearance', 'value' => 'violet'],
            ['key' => 'mascot_enabled',        'group' => 'appearance', 'value' => true],
            ['key' => 'mascot_animation_url',  'group' => 'appearance', 'value' => '/lottie/mascot.json'],

            // ── Hero & Home Page ──────────────────────────────────────────────
            ['key' => 'hero_eyebrow', 'group' => 'home', 'value' => [
                'en' => "Hi, I'm Omar 👋",
                'ar' => 'مرحباً، أنا عمر 👋',
            ]],
            ['key' => 'hero_title_template', 'group' => 'home', 'value' => [
                'en' => "I'm a {role} Developer",
                'ar' => 'أنا {role}',
            ]],
            ['key' => 'hero_rotating_titles', 'group' => 'home', 'value' => [
                'en' => ['Full-Stack', 'Backend', 'Frontend', 'Software Engineer', 'Laravel', 'Vue.js'],
                'ar' => ['متكامل', 'خلفي', 'أمامي', 'مهندس برمجيات', 'Laravel', 'Vue.js'],
            ]],
            ['key' => 'hero_tagline', 'group' => 'home', 'value' => [
                'en' => 'Building clean, scalable web applications — from backend architecture to pixel-perfect frontends.',
                'ar' => 'أبني تطبيقات ويب نظيفة وقابلة للتوسع — من البنية الخلفية إلى الواجهات الدقيقة.',
            ]],
            ['key' => 'about_brief', 'group' => 'home', 'value' => [
                'en' => "I'm a Full-Stack Web Developer with 4 years of hands-on experience building scalable web applications using Laravel and Vue.js. I thrive at the intersection of clean backend architecture and polished frontend interfaces — whether that's a complex CRM, a payment-integrated platform, or a performant API powering mobile apps. Based in Cairo, currently building at BusinessBuilding.sa.",
                'ar' => 'أنا مطور ويب متكامل بخبرة عملية تمتد لـ 4 سنوات في بناء تطبيقات ويب قابلة للتوسع باستخدام Laravel وVue.js. أجمع بين البنية الخلفية النظيفة والواجهات الأمامية المصقولة — سواء كان ذلك نظام CRM معقدًا أو منصة مدفوعات متكاملة أو API يشغّل تطبيقات الجوال. مقيم في القاهرة، أعمل حاليًا في BusinessBuilding.sa.',
            ]],
            ['key' => 'stat_experience', 'group' => 'home', 'value' => [
                'value' => '4+',
                'label' => ['en' => 'Years Experience', 'ar' => 'سنوات خبرة'],
            ]],
            ['key' => 'stat_projects', 'group' => 'home', 'value' => [
                'value' => '20+',
                'label' => ['en' => 'Projects Delivered', 'ar' => 'مشروع منجز'],
            ]],
            ['key' => 'stat_technologies', 'group' => 'home', 'value' => [
                'value' => '10+',
                'label' => ['en' => 'Technologies', 'ar' => 'تقنية'],
            ]],
            ['key' => 'stat_languages', 'group' => 'home', 'value' => [
                'value' => '2',
                'label' => ['en' => 'Languages', 'ar' => 'لغة'],
            ]],
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

<?php

namespace Database\Seeders;

use App\Enums\EmploymentType;
use App\Enums\LocationType;
use App\Enums\ProjectStatus;
use App\Enums\SkillCategory;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PersonalInfo;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CvSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedPersonalInfo();
        $this->seedExperiences();
        $this->seedEducations();
        $this->seedSkills();
        $this->seedProjects();
    }

    // ─────────────────────────────────────────────────────────────────────────
    private function seedPersonalInfo(): void
    {
        PersonalInfo::updateOrCreate(
            ['type' => 'main'],
            [
                'name' => [
                    'en' => 'Omar Mohammed Sultan',
                    'ar' => 'عمر محمد سلطان',
                ],
                'title' => [
                    'en' => 'Full-Stack Web Developer / Software Engineer',
                    'ar' => 'مطور ويب متكامل / مهندس برمجيات',
                ],
                'summary' => [
                    'en' => 'Full-Stack Web Developer with 4 years of hands-on experience in designing, developing, and deploying scalable web applications using Laravel and Vue.js. Skilled in building complete systems from backend architecture to responsive frontend interfaces. Proven track record in leading backend teams, developing CRMs, integrating third-party APIs, and optimizing databases for performance. Passionate about clean code, user-centered design, and continuous improvement. Experienced in collaborating with cross-functional teams and managing projects from concept to launch.',
                    'ar' => 'مطور ويب متكامل بخبرة عملية تمتد لـ 4 سنوات في تصميم وتطوير ونشر تطبيقات ويب قابلة للتوسع باستخدام Laravel وVue.js. أمتلك مهارة في بناء الأنظمة المتكاملة من البنية الخلفية إلى الواجهات الأمامية المتجاوبة. سجل حافل في قيادة فرق التطوير الخلفي، وتطوير أنظمة CRM، وتكامل واجهات API لجهات خارجية، وتحسين قواعد البيانات. شغوف بالكود النظيف والتصميم المحوري للمستخدم والتحسين المستمر. خبرة في التعاون مع الفرق متعددة الوظائف وإدارة المشاريع من الفكرة حتى الإطلاق.',
                ],
                'email'  => 'umar27.11.2001@gmail.com',
                'phone'  => '+201050456069',
                'location' => [
                    'en' => 'Cairo, Egypt',
                    'ar' => 'القاهرة، مصر',
                ],
                'socials' => [
                    'github'   => 'https://github.com/omarMohammedbenzo',
                    'linkedin' => 'https://www.linkedin.com/in/omar-m-227b10253/',
                ],
                'meta' => [
                    'seo_title_en'       => 'Omar Mohammed Sultan — Full-Stack Developer',
                    'seo_title_ar'       => 'عمر محمد سلطان — مطور ويب متكامل',
                    'seo_description_en' => 'Full-Stack Web Developer specializing in Laravel & Vue.js with 4 years of experience building scalable web applications.',
                    'seo_description_ar' => 'مطور ويب متكامل متخصص في Laravel وVue.js بخبرة 4 سنوات في بناء تطبيقات ويب قابلة للتوسع.',
                ],
            ]
        );

        $this->command->info('Personal info seeded.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    private function seedExperiences(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Experience::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $experiences = [
            [
                'order'           => 1,
                'company'         => 'BusinessBuilding.sa',
                'role'            => ['en' => 'Backend Developer', 'ar' => 'مطور خلفي'],
                'location'        => ['en' => 'Cairo, Egypt', 'ar' => 'القاهرة، مصر'],
                'employment_type' => EmploymentType::FullTime,
                'location_type'   => LocationType::OnSite,
                'start_date'      => '2025-10-01',
                'end_date'        => null,
                'is_current'      => true,
                'description'     => [
                    'en' => "<ul><li>Developed scalable solutions as a Backend Developer specializing in Laravel and Vue.js.</li><li>Architected complex integrations, including payment gateways (Moyasar, StcPay) and SMS services for rental.sa.</li><li>Collaborated in Agile (Scrum) environments, utilizing Jira.</li></ul>",
                    'ar' => "<ul><li>طوّرت حلولاً قابلة للتوسع بوصفي مطوراً خلفياً متخصصاً في Laravel وVue.js.</li><li>صمّمت تكاملات معقدة تشمل بوابات الدفع (Moyasar وStcPay) وخدمات الرسائل القصيرة لـ rental.sa.</li><li>عملت في بيئات Agile (Scrum) باستخدام Jira.</li></ul>",
                ],
            ],
            [
                'order'           => 2,
                'company'         => 'Al Azhar University - Gaza',
                'role'            => ['en' => 'Server Administrator', 'ar' => 'مدير خوادم'],
                'location'        => ['en' => 'Cairo, Egypt (Remote)', 'ar' => 'القاهرة، مصر (عن بُعد)'],
                'employment_type' => EmploymentType::PartTime,
                'location_type'   => LocationType::Remote,
                'start_date'      => '2025-07-01',
                'end_date'        => null,
                'is_current'      => true,
                'description'     => [
                    'en' => "<ul><li>Manage Moodle LMS Administration and Academic Content Supervision.</li></ul>",
                    'ar' => "<ul><li>إدارة نظام Moodle LMS والإشراف على المحتوى الأكاديمي.</li></ul>",
                ],
            ],
            [
                'order'           => 3,
                'company'         => 'Madmon.ai',
                'role'            => ['en' => 'Backend Developer', 'ar' => 'مطور خلفي'],
                'location'        => ['en' => 'Cairo, Egypt', 'ar' => 'القاهرة، مصر'],
                'employment_type' => EmploymentType::FullTime,
                'location_type'   => LocationType::OnSite,
                'start_date'      => '2024-12-01',
                'end_date'        => '2025-07-31',
                'is_current'      => false,
                'description'     => [
                    'en' => "<ul><li>Led the backend development for the platform's complete redesign with React frontend, delivering scalable RESTful APIs to power web and mobile applications.</li><li>Built a custom operational CRM API system supporting 14+ different roles and workflows.</li><li>Developed and integrated payment gateways (Fawry), OTP verification via WhatsApp (Meta) and SMS services, Firebase Cloud Messaging (FCM), and Telegram bots to automate notifications and system alerts.</li><li>Collaborated closely with frontend engineers and product teams.</li><li>Managed and mentored a backend team, providing code reviews, architectural guidance, and support.</li></ul>",
                    'ar' => "<ul><li>قدت تطوير الواجهة الخلفية لإعادة تصميم شاملة للمنصة مع واجهة React أمامية، وتسليم RESTful APIs قابلة للتوسع لتشغيل تطبيقات الويب والجوال.</li><li>بنيت نظام CRM تشغيلي مخصص يدعم أكثر من 14 دوراً وسير عمل مختلفة.</li><li>طوّرت وكاملت بوابات الدفع (Fawry)، والتحقق عبر OTP بواسطة WhatsApp وSMS، وFirebase Cloud Messaging، وروبوتات Telegram لأتمتة الإشعارات وتنبيهات النظام.</li><li>تعاونت عن كثب مع مهندسي الواجهة الأمامية وفرق المنتج.</li><li>أدرت وأرشدت فريق التطوير الخلفي وقدمت مراجعات الكود والتوجيه المعماري.</li></ul>",
                ],
            ],
            [
                'order'           => 4,
                'company'         => 'Madmon.ai',
                'role'            => ['en' => 'Full Stack Developer', 'ar' => 'مطور متكامل'],
                'location'        => ['en' => 'Cairo, Egypt', 'ar' => 'القاهرة، مصر'],
                'employment_type' => EmploymentType::FullTime,
                'location_type'   => LocationType::OnSite,
                'start_date'      => '2024-05-01',
                'end_date'        => '2024-11-30',
                'is_current'      => false,
                'description'     => [
                    'en' => "<ul><li>Developed the company's official website and internal CRM platform from scratch using Laravel (PHP) backend and Bootstrap/jQuery frontend.</li><li>Integrated tracking and analytics tools including GA4, Microsoft Clarity, Meta Pixel, and GTM to enable SEO and marketing insights.</li><li>Acted as Point of Contact (POC) with cross-functional teams.</li></ul>",
                    'ar' => "<ul><li>طوّرت الموقع الرسمي للشركة ومنصة CRM الداخلية من الصفر باستخدام Laravel (PHP) في الخلفية وBootstrap/jQuery في الواجهة.</li><li>كاملت أدوات التتبع والتحليلات بما فيها GA4 وMicrosoft Clarity وMeta Pixel وGTM لتمكين رؤى SEO والتسويق.</li><li>عملت بوصفي نقطة اتصال (POC) مع الفرق متعددة الوظائف.</li></ul>",
                ],
            ],
            [
                'order'           => 5,
                'company'         => 'iltiqaa Real Estate',
                'role'            => ['en' => 'Front-End Developer', 'ar' => 'مطور واجهة أمامية'],
                'location'        => ['en' => 'Cairo, Egypt', 'ar' => 'القاهرة، مصر'],
                'employment_type' => EmploymentType::PartTime,
                'location_type'   => LocationType::Hybrid,
                'start_date'      => '2024-05-01',
                'end_date'        => '2024-08-31',
                'is_current'      => false,
                'description'     => [
                    'en' => "<ul><li>Developed the company's official website from scratch using Bootstrap/jQuery frontend.</li><li>Performed requirements analysis and implementation to build the company's website and link it with Firebase.</li></ul>",
                    'ar' => "<ul><li>طوّرت الموقع الرسمي للشركة من الصفر باستخدام Bootstrap/jQuery في الواجهة الأمامية.</li><li>أجريت تحليل المتطلبات وتنفيذها لبناء موقع الشركة وربطه بـ Firebase.</li></ul>",
                ],
            ],
            [
                'order'           => 6,
                'company'         => 'AccessLine Co',
                'role'            => ['en' => 'Back-End Developer', 'ar' => 'مطور خلفي'],
                'location'        => ['en' => 'Gaza, Palestine', 'ar' => 'غزة، فلسطين'],
                'employment_type' => EmploymentType::FullTime,
                'location_type'   => LocationType::OnSite,
                'start_date'      => '2021-07-01',
                'end_date'        => '2023-10-31',
                'is_current'      => false,
                'description'     => [
                    'en' => "<ul><li><strong>NIET Project:</strong> Developed official website and internal CRM platform from scratch using Laravel (PHP) backend. Used Tailwind CSS and MySQL. Implemented login via Microsoft account.</li><li><strong>STEM Project:</strong> Was one of the members of the Laravel team, specialized in programming the entire website with its MySQL database. (Palestine Ministry of Education educational platform for ages 6–12.)</li></ul>",
                    'ar' => "<ul><li><strong>مشروع NIET:</strong> طوّرت الموقع الرسمي ومنصة CRM الداخلية من الصفر باستخدام Laravel (PHP) وTailwind CSS وMySQL، مع تطبيق تسجيل الدخول عبر حساب Microsoft.</li><li><strong>مشروع STEM:</strong> كنت أحد أعضاء فريق Laravel المتخصص في برمجة الموقع بأكمله مع قاعدة بيانات MySQL. (منصة تعليمية تابعة لوزارة التربية والتعليم الفلسطينية للفئة العمرية 6–12 سنة.)</li></ul>",
                ],
            ],
        ];

        foreach ($experiences as $data) {
            Experience::create($data);
        }

        $this->command->info('Experiences seeded: ' . count($experiences));
    }

    // ─────────────────────────────────────────────────────────────────────────
    private function seedEducations(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Education::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Education::create([
            'school'     => 'Al Azhar University',
            'degree'     => [
                'en' => "Bachelor's Degree",
                'ar' => 'بكالوريوس',
            ],
            'field'      => [
                'en' => 'Information Technology & Software Engineering',
                'ar' => 'تقنية المعلومات وهندسة البرمجيات',
            ],
            'location'   => [
                'en' => 'Palestine (Gaza)',
                'ar' => 'فلسطين (غزة)',
            ],
            'description' => [
                'en' => 'Faculty of Engineering — Bachelor\'s in Information Technology & Software Engineering.',
                'ar' => 'كلية الهندسة — بكالوريوس في تقنية المعلومات وهندسة البرمجيات.',
            ],
            'start_date' => '2019-09-01',
            'end_date'   => '2024-06-30',
            'order'      => 1,
        ]);

        $this->command->info('Educations seeded.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    private function seedSkills(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Skill::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $skills = [
            // Backend
            ['name' => ['en' => 'PHP', 'ar' => 'PHP'], 'category' => SkillCategory::Backend, 'level' => 5, 'icon' => 'code', 'order' => 1],
            ['name' => ['en' => 'Laravel', 'ar' => 'Laravel'], 'category' => SkillCategory::Backend, 'level' => 5, 'icon' => 'layers', 'order' => 2],
            ['name' => ['en' => 'MySQL', 'ar' => 'MySQL'], 'category' => SkillCategory::Backend, 'level' => 5, 'icon' => 'database', 'order' => 3],
            ['name' => ['en' => 'RESTful API', 'ar' => 'RESTful API'], 'category' => SkillCategory::Backend, 'level' => 5, 'icon' => 'network', 'order' => 4],
            ['name' => ['en' => 'Firebase', 'ar' => 'Firebase'], 'category' => SkillCategory::Backend, 'level' => 4, 'icon' => 'flame', 'order' => 5],

            // Frontend
            ['name' => ['en' => 'HTML & CSS', 'ar' => 'HTML وCSS'], 'category' => SkillCategory::Frontend, 'level' => 5, 'icon' => 'layout', 'order' => 1],
            ['name' => ['en' => 'SASS', 'ar' => 'SASS'], 'category' => SkillCategory::Frontend, 'level' => 4, 'icon' => 'palette', 'order' => 2],
            ['name' => ['en' => 'JavaScript', 'ar' => 'JavaScript'], 'category' => SkillCategory::Frontend, 'level' => 4, 'icon' => 'braces', 'order' => 3],
            ['name' => ['en' => 'TypeScript', 'ar' => 'TypeScript'], 'category' => SkillCategory::Frontend, 'level' => 4, 'icon' => 'file-code', 'order' => 4],
            ['name' => ['en' => 'Vue.js', 'ar' => 'Vue.js'], 'category' => SkillCategory::Frontend, 'level' => 4, 'icon' => 'triangle', 'order' => 5],
            ['name' => ['en' => 'Tailwind CSS', 'ar' => 'Tailwind CSS'], 'category' => SkillCategory::Frontend, 'level' => 5, 'icon' => 'wind', 'order' => 6],
            ['name' => ['en' => 'Bootstrap', 'ar' => 'Bootstrap'], 'category' => SkillCategory::Frontend, 'level' => 5, 'icon' => 'layout-grid', 'order' => 7],
            ['name' => ['en' => 'jQuery & AJAX', 'ar' => 'jQuery وAJAX'], 'category' => SkillCategory::Frontend, 'level' => 4, 'icon' => 'zap', 'order' => 8],
            ['name' => ['en' => 'Inertia.js', 'ar' => 'Inertia.js'], 'category' => SkillCategory::Frontend, 'level' => 4, 'icon' => 'arrow-right-left', 'order' => 9],

            // Tools
            ['name' => ['en' => 'Git & GitHub', 'ar' => 'Git وGitHub'], 'category' => SkillCategory::Tools, 'level' => 5, 'icon' => 'git-branch', 'order' => 1],
            ['name' => ['en' => 'CI/CD Workflows', 'ar' => 'سير عمل CI/CD'], 'category' => SkillCategory::Tools, 'level' => 4, 'icon' => 'refresh-cw', 'order' => 2],
            ['name' => ['en' => 'Server Deployment (FTP, SSH)', 'ar' => 'نشر الخوادم (FTP، SSH)'], 'category' => SkillCategory::Tools, 'level' => 4, 'icon' => 'server', 'order' => 3],
            ['name' => ['en' => 'Linux Server Admin', 'ar' => 'إدارة خوادم Linux'], 'category' => SkillCategory::Tools, 'level' => 3, 'icon' => 'terminal', 'order' => 4],
            ['name' => ['en' => 'Jira & Agile / Scrum', 'ar' => 'Jira وأجايل / سكرم'], 'category' => SkillCategory::Tools, 'level' => 4, 'icon' => 'kanban', 'order' => 5],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        $this->command->info('Skills seeded: ' . count($skills));
    }

    // ─────────────────────────────────────────────────────────────────────────
    private function seedProjects(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ProjectImage::truncate();
        Project::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $projects = [
            [
                'title'       => ['en' => 'Madmon.ai Real Estate Platform', 'ar' => 'منصة مدمون للعقارات'],
                'slug'        => 'madmon-ai-platform',
                'status'      => ProjectStatus::Published,
                'featured'    => true,
                'year'        => 2024,
                'order'       => 1,
                'gradient_colors' => ['from' => 'from-violet-600', 'via' => 'via-purple-600', 'to' => 'to-indigo-700'],
                'tech_stack'  => ['Laravel', 'React', 'MySQL', 'Fawry', 'Firebase FCM', 'WhatsApp API', 'Telegram Bot', 'Tailwind CSS'],
                'description' => [
                    'en' => 'Real estate platform for listing resale and primary units across Egypt. Full backend redesign with scalable RESTful API powering web and mobile applications.',
                    'ar' => 'منصة عقارية لإدراج وحدات إعادة البيع والوحدات الأولية في جميع أنحاء مصر. إعادة تصميم شاملة للواجهة الخلفية مع API مرن يشغّل تطبيقات الويب والجوال.',
                ],
                'long_description' => [
                    'en' => "<p>A comprehensive real estate listing platform designed for the Egyptian market. The project involved two phases:</p><ul><li><strong>Phase 1 (Full Stack):</strong> Built the company website and internal CRM from scratch using Laravel backend and Bootstrap/jQuery frontend. Integrated GA4, Microsoft Clarity, Meta Pixel, and GTM for marketing analytics.</li><li><strong>Phase 2 (Backend Lead):</strong> Led complete platform redesign with React frontend, delivering scalable RESTful APIs. Built a custom CRM API supporting 14+ roles and workflows. Integrated Fawry payment gateway, WhatsApp OTP, Firebase Cloud Messaging, and Telegram notification bots.</li></ul>",
                    'ar' => "<p>منصة شاملة لإدراج العقارات مصممة للسوق المصري. تضمّن المشروع مرحلتين:</p><ul><li><strong>المرحلة الأولى (متكامل):</strong> بناء موقع الشركة وCRM الداخلي من الصفر باستخدام Laravel وBootstrap/jQuery. تكامل GA4 وMicrosoft Clarity وMeta Pixel وGTM.</li><li><strong>المرحلة الثانية (قائد خلفي):</strong> قيادة إعادة تصميم المنصة مع واجهة React. بناء CRM API مخصص يدعم 14+ دوراً. تكامل Fawry وWhatsApp OTP وFCM وروبوتات Telegram.</li></ul>",
                ],
                'live_url'    => 'https://madmon.ai',
                'github_url'  => null,
            ],
            [
                'title'       => ['en' => 'rental.sa — Rental Platform', 'ar' => 'rental.sa — منصة التأجير'],
                'slug'        => 'rental-sa',
                'status'      => ProjectStatus::Published,
                'featured'    => true,
                'year'        => 2025,
                'order'       => 2,
                'gradient_colors' => ['from' => 'from-blue-600', 'via' => 'via-cyan-500', 'to' => 'to-teal-600'],
                'tech_stack'  => ['Laravel', 'Vue.js', 'Moyasar', 'StcPay', 'SMS API', 'MySQL'],
                'description' => [
                    'en' => 'Saudi rental platform with complex payment gateway integrations (Moyasar, StcPay) and SMS notification services, built at BusinessBuilding.sa.',
                    'ar' => 'منصة تأجير سعودية مع تكاملات بوابات دفع معقدة (Moyasar وStcPay) وخدمات إشعارات SMS، مبنية في BusinessBuilding.sa.',
                ],
                'long_description' => [
                    'en' => "<p>A feature-rich rental platform built for the Saudi Arabian market. Key responsibilities included architecting complex payment gateway integrations with Moyasar and StcPay, implementing SMS notification services for rental confirmations and reminders, and developing scalable backend solutions using Laravel and Vue.js in an Agile/Scrum environment.</p>",
                    'ar' => "<p>منصة تأجير غنية بالميزات مبنية للسوق السعودي. تضمنت المسؤوليات الرئيسية تصميم تكاملات بوابات الدفع مع Moyasar وStcPay، وتطبيق خدمات إشعارات SMS، وتطوير حلول خلفية قابلة للتوسع باستخدام Laravel وVue.js في بيئة Agile/Scrum.</p>",
                ],
                'live_url'    => 'https://rental.sa',
                'github_url'  => null,
            ],
            [
                'title'       => ['en' => 'Shabiba Student Council Website', 'ar' => 'موقع مجلس طلاب شبيبة'],
                'slug'        => 'shabiba-student-council',
                'status'      => ProjectStatus::Published,
                'featured'    => true,
                'year'        => 2023,
                'order'       => 3,
                'gradient_colors' => ['from' => 'from-emerald-500', 'via' => 'via-green-500', 'to' => 'to-teal-600'],
                'tech_stack'  => ['Laravel', 'Tailwind CSS', 'AJAX', 'MySQL', 'GitHub Actions', 'CI/CD'],
                'description' => [
                    'en' => 'Multi-tenant student council website for Al Azhar University with 12 college-specific dashboards, deployed via GitHub CI/CD pipeline.',
                    'ar' => 'موقع مجلس طلاب متعدد المستأجرين لجامعة الأزهر مع 12 لوحة تحكم خاصة بكل كلية، منشور عبر pipeline CI/CD على GitHub.',
                ],
                'long_description' => [
                    'en' => "<p>Designed and developed a full-stack multi-tenant website for the Shabiba Student Council at the university. Each of the 12 colleges has its own isolated dashboard on the control panel, allowing college administrators to manage their services independently. Built with Laravel backend and Tailwind CSS frontend, with CI/CD deployment configured via GitHub Actions.</p>",
                    'ar' => "<p>صمّمت وطوّرت موقعاً متكاملاً متعدد المستأجرين لمجلس طلاب شبيبة في الجامعة. تمتلك كل من 12 كلية لوحة تحكم منفصلة تتيح لمسؤولي الكلية إدارة خدماتهم بشكل مستقل. مبني بـ Laravel وTailwind CSS مع CI/CD عبر GitHub Actions.</p>",
                ],
                'live_url'    => null,
                'github_url'  => null,
            ],
            [
                'title'       => ['en' => 'NIET Training Platform', 'ar' => 'منصة NIET التدريبية'],
                'slug'        => 'niet-platform',
                'status'      => ProjectStatus::Published,
                'featured'    => false,
                'year'        => 2022,
                'order'       => 4,
                'gradient_colors' => ['from' => 'from-orange-500', 'via' => 'via-amber-500', 'to' => 'to-yellow-500'],
                'tech_stack'  => ['Laravel', 'Tailwind CSS', 'MySQL', 'Microsoft SSO', 'CRM'],
                'description' => [
                    'en' => 'National Institute for Educational Training — an e-learning platform for STEM education with Microsoft SSO and a custom CRM, built at AccessLine Co.',
                    'ar' => 'المعهد الوطني للتدريب التربوي — منصة تعلم إلكتروني لتعليم STEM مع تسجيل دخول Microsoft وCRM مخصص، مبنية في AccessLine Co.',
                ],
                'long_description' => [
                    'en' => "<p>The National Institute for Educational Training is a training platform targeting the education sector, providing online STEM courses (Science, Technology, Engineering, Mathematics) from expert teachers. Developed the official website and internal CRM from scratch using a Laravel backend with Tailwind CSS. Implemented Microsoft account OAuth login for institutional users.</p>",
                    'ar' => "<p>المعهد الوطني للتدريب التربوي منصة تدريبية تستهدف قطاع التعليم، تقدم دورات STEM (العلوم والتكنولوجيا والهندسة والرياضيات) عبر الإنترنت من معلمين خبراء. طوّرت الموقع الرسمي وCRM الداخلي من الصفر باستخدام Laravel وTailwind CSS مع تسجيل دخول OAuth عبر Microsoft.</p>",
                ],
                'live_url'    => null,
                'github_url'  => null,
            ],
            [
                'title'       => ['en' => 'STEM Educational Platform', 'ar' => 'المنصة التعليمية STEM'],
                'slug'        => 'stem-platform',
                'status'      => ProjectStatus::Published,
                'featured'    => false,
                'year'        => 2022,
                'order'       => 5,
                'gradient_colors' => ['from' => 'from-rose-500', 'via' => 'via-pink-500', 'to' => 'to-fuchsia-600'],
                'tech_stack'  => ['Laravel', 'MySQL', 'PHP'],
                'description' => [
                    'en' => 'Palestine Ministry of Education\'s educational platform enriching content for children aged 6–12, built as part of the Laravel team at AccessLine Co.',
                    'ar' => 'منصة تعليمية تابعة لوزارة التربية والتعليم الفلسطينية لإثراء المحتوى للأطفال من 6 إلى 12 سنة، مبنية ضمن فريق Laravel في AccessLine Co.',
                ],
                'long_description' => [
                    'en' => "<p>The STEM website is a Palestinian educational platform affiliated with the Ministry of Education, aimed at enriching educational content for children aged 6 to 12. Worked as a member of the Laravel team, specializing in programming the complete website backend with its MySQL database.</p>",
                    'ar' => "<p>موقع STEM منصة تعليمية فلسطينية تابعة لوزارة التربية والتعليم، تهدف إلى إثراء المحتوى التعليمي للفئة العمرية من 6 إلى 12 سنة. عملت ضمن فريق Laravel متخصصاً في برمجة الواجهة الخلفية بأكملها مع قاعدة بيانات MySQL.</p>",
                ],
                'live_url'    => null,
                'github_url'  => null,
            ],
            [
                'title'       => ['en' => "Dan's Trucking System", 'ar' => 'نظام Dan للشاحنات'],
                'slug'        => 'dans-trucking-system',
                'status'      => ProjectStatus::Published,
                'featured'    => false,
                'year'        => 2023,
                'order'       => 6,
                'gradient_colors' => ['from' => 'from-slate-600', 'via' => 'via-gray-600', 'to' => 'to-zinc-700'],
                'tech_stack'  => ['Laravel', 'Bootstrap', 'jQuery', 'AJAX', 'MySQL', 'FileZilla'],
                'description' => [
                    'en' => 'Full-stack freelance project — trucking company website with custom admin dashboard, CRUD operations, and manual FTP deployment.',
                    'ar' => 'مشروع مستقل متكامل — موقع شركة شاحنات مع لوحة تحكم مخصصة وعمليات CRUD ونشر يدوي عبر FTP.',
                ],
                'long_description' => [
                    'en' => "<p>A freelance full-stack project for a trucking company. Designed and developed the website from scratch, handling both frontend (HTML, CSS, JS, Ajax, Bootstrap) and backend (Laravel/PHP). Built a custom admin dashboard for managing content, services, and CRUD operations. Deployed to the production server using FileZilla and manual configuration workflows.</p>",
                    'ar' => "<p>مشروع مستقل متكامل لشركة شاحنات. صمّمت وطوّرت الموقع من الصفر، متولياً الواجهة الأمامية (HTML وCSS وJS وAjax وBootstrap) والخلفية (Laravel/PHP). بنيت لوحة تحكم مخصصة لإدارة المحتوى والخدمات وعمليات CRUD. نشر على خادم الإنتاج باستخدام FileZilla.</p>",
                ],
                'live_url'    => null,
                'github_url'  => null,
            ],
            [
                'title'       => ['en' => 'iltiqaa Real Estate Website', 'ar' => 'موقع إلتقاء العقارية'],
                'slug'        => 'iltiqaa-real-estate',
                'status'      => ProjectStatus::Published,
                'featured'    => false,
                'year'        => 2024,
                'order'       => 7,
                'gradient_colors' => ['from' => 'from-cyan-500', 'via' => 'via-sky-500', 'to' => 'to-blue-600'],
                'tech_stack'  => ['Bootstrap', 'jQuery', 'Firebase', 'JavaScript'],
                'description' => [
                    'en' => 'Official website for iltiqaa Real Estate built with Bootstrap/jQuery frontend, integrated with Firebase backend.',
                    'ar' => 'الموقع الرسمي لشركة إلتقاء العقارية مبني بـ Bootstrap/jQuery مع Firebase.',
                ],
                'long_description' => [
                    'en' => "<p>Developed the company's official website from scratch using Bootstrap/jQuery frontend. Performed requirements analysis and implementation to build the company's website and link it with Firebase for data storage and real-time features.</p>",
                    'ar' => "<p>طوّرت الموقع الرسمي للشركة من الصفر باستخدام Bootstrap/jQuery. أجريت تحليل المتطلبات وتنفيذها لبناء الموقع وربطه بـ Firebase لتخزين البيانات والميزات الفورية.</p>",
                ],
                'live_url'    => null,
                'github_url'  => null,
            ],
        ];

        foreach ($projects as $data) {
            Project::create($data);
        }

        $this->command->info('Projects seeded: ' . count($projects));
    }
}

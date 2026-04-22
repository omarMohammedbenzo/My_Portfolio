<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{ $info->name }} — CV</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: {{ $lang === 'ar' ? "'DejaVu Sans', sans-serif" : "'DejaVu Sans', Helvetica, Arial, sans-serif" }};
        font-size: 9.5pt;
        color: #1a1a2e;
        background: #ffffff;
        direction: {{ $lang === 'ar' ? 'rtl' : 'ltr' }};
    }

    /* ─── Header ─── */
    .header {
        background: #4f46e5;
        color: #ffffff;
        padding: 24pt 28pt;
    }
    .header-name {
        font-size: 22pt;
        font-weight: bold;
        letter-spacing: 0.5pt;
    }
    .header-title {
        font-size: 11pt;
        color: #c7d2fe;
        margin-top: 3pt;
    }
    .header-meta {
        margin-top: 10pt;
        font-size: 8.5pt;
        color: #e0e7ff;
    }
    .header-meta span {
        margin-{{ $lang === 'ar' ? 'left' : 'right' }}: 16pt;
    }

    /* ─── Body layout ─── */
    .body-wrap {
        width: 100%;
    }
    .sidebar {
        width: 30%;
        vertical-align: top;
        padding: 20pt 18pt;
        background: #f8f7ff;
        border-{{ $lang === 'ar' ? 'left' : 'right' }}: 1.5pt solid #e0e7ff;
    }
    .main {
        width: 70%;
        vertical-align: top;
        padding: 20pt 22pt;
    }

    /* ─── Sections ─── */
    .section-title {
        font-size: 8pt;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1pt;
        color: #4f46e5;
        border-bottom: 1pt solid #c7d2fe;
        padding-bottom: 4pt;
        margin-bottom: 10pt;
        margin-top: 16pt;
    }
    .section-title:first-child { margin-top: 0; }

    /* ─── Summary ─── */
    .summary {
        font-size: 9pt;
        color: #444;
        line-height: 1.6;
        margin-bottom: 4pt;
    }

    /* ─── Experience ─── */
    .exp-item { margin-bottom: 14pt; }
    .exp-position {
        font-size: 10pt;
        font-weight: bold;
        color: #1a1a2e;
    }
    .exp-company {
        font-size: 9pt;
        color: #4f46e5;
        font-weight: bold;
        margin-top: 1pt;
    }
    .exp-meta {
        font-size: 8pt;
        color: #777;
        margin-top: 2pt;
    }
    .exp-desc {
        font-size: 8.5pt;
        color: #444;
        line-height: 1.55;
        margin-top: 5pt;
    }
    .badge {
        display: inline-block;
        background: #e0e7ff;
        color: #4f46e5;
        font-size: 7pt;
        padding: 1pt 5pt;
        border-radius: 3pt;
        margin-{{ $lang === 'ar' ? 'left' : 'right' }}: 3pt;
    }

    /* ─── Education ─── */
    .edu-item { margin-bottom: 12pt; }
    .edu-degree { font-size: 9.5pt; font-weight: bold; color: #1a1a2e; }
    .edu-school { font-size: 9pt; color: #4f46e5; margin-top: 1pt; }
    .edu-field  { font-size: 8.5pt; color: #555; margin-top: 1pt; }
    .edu-dates  { font-size: 8pt; color: #777; margin-top: 2pt; }

    /* ─── Skills ─── */
    .skill-category { margin-bottom: 10pt; }
    .skill-cat-label {
        font-size: 8pt;
        font-weight: bold;
        color: #555;
        text-transform: uppercase;
        letter-spacing: 0.5pt;
        margin-bottom: 5pt;
    }
    .skill-item {
        margin-bottom: 5pt;
    }
    .skill-name {
        font-size: 8.5pt;
        color: #1a1a2e;
        margin-bottom: 2pt;
    }
    .skill-bar-bg {
        background: #e0e7ff;
        height: 4pt;
        border-radius: 2pt;
        width: 100%;
    }
    .skill-bar-fill {
        background: #4f46e5;
        height: 4pt;
        border-radius: 2pt;
    }

    /* ─── Contact block in sidebar ─── */
    .contact-item {
        font-size: 8pt;
        color: #444;
        margin-bottom: 5pt;
        word-break: break-all;
    }
    .contact-label {
        font-size: 7.5pt;
        color: #4f46e5;
        font-weight: bold;
        display: block;
        margin-bottom: 1pt;
    }

    /* ─── Divider ─── */
    hr { border: none; border-top: 1pt solid #e5e7eb; margin: 10pt 0; }

    /* ─── Page break ─── */
    .page-break { page-break-after: always; }
</style>
</head>
<body>

{{-- ═══ HEADER ═══ --}}
<div class="header">
    <div class="header-name">{{ $info->name }}</div>
    <div class="header-title">{{ $info->title }}</div>
    <div class="header-meta">
        @if($info->location)
            <span>📍 {{ $info->location }}</span>
        @endif
        @if($info->email)
            <span>✉ {{ $info->email }}</span>
        @endif
        @if(!empty($info->phone))
            <span>{{ $info->phone }}</span>
        @endif
        @if(!empty($info->socials['github'] ?? null))
            <span>{{ $info->socials['github'] }}</span>
        @endif
        @if(!empty($info->socials['linkedin'] ?? null))
            <span>{{ $info->socials['linkedin'] }}</span>
        @endif
    </div>
</div>

{{-- ═══ BODY: sidebar + main ═══ --}}
<table class="body-wrap" cellpadding="0" cellspacing="0" width="100%">
<tr>

{{-- ─── SIDEBAR ─── --}}
<td class="sidebar" @if($lang === 'ar') style="border-left: 1.5pt solid #e0e7ff; border-right: none;" @endif>

    {{-- Contact --}}
    <div class="section-title">{{ $lang === 'ar' ? 'التواصل' : 'Contact' }}</div>

    @if($info->email)
    <div class="contact-item">
        <span class="contact-label">{{ $lang === 'ar' ? 'البريد الإلكتروني' : 'Email' }}</span>
        {{ $info->email }}
    </div>
    @endif

    @if(!empty($info->socials['github'] ?? null))
    <div class="contact-item">
        <span class="contact-label">GitHub</span>
        {{ $info->socials['github'] }}
    </div>
    @endif

    @if(!empty($info->socials['linkedin'] ?? null))
    <div class="contact-item">
        <span class="contact-label">LinkedIn</span>
        {{ $info->socials['linkedin'] }}
    </div>
    @endif

    @if($info->location)
    <div class="contact-item">
        <span class="contact-label">{{ $lang === 'ar' ? 'الموقع' : 'Location' }}</span>
        {{ $info->location }}
    </div>
    @endif

    {{-- Skills --}}
    @foreach($skills as $category => $group)
    @php
        $catLabels = [
            'en' => ['backend' => 'Backend', 'frontend' => 'Frontend', 'tools' => 'Tools', 'other' => 'Other'],
            'ar' => ['backend' => 'الخلفية', 'frontend' => 'الواجهة', 'tools' => 'الأدوات', 'other' => 'أخرى'],
        ];
        $catLabel = $catLabels[$lang][$category] ?? ucfirst($category);
    @endphp

    <div class="section-title">{{ $catLabel }}</div>
    <div class="skill-category">
        @foreach($group as $skill)
        <div class="skill-item">
            <div class="skill-name">{{ $skill->name }}</div>
            <div class="skill-bar-bg">
                <div class="skill-bar-fill" style="width: {{ ($skill->level / 5) * 100 }}%;"></div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach

    {{-- Education --}}
    <div class="section-title">{{ $lang === 'ar' ? 'التعليم' : 'Education' }}</div>
    @foreach($educations as $edu)
    <div class="edu-item">
        <div class="edu-degree">{{ $edu->degree }}</div>
        <div class="edu-school">{{ $edu->school }}</div>
        @if($edu->field)
        <div class="edu-field">{{ $edu->field }}</div>
        @endif
        <div class="edu-dates">
            {{ $edu->start_date ? \Carbon\Carbon::parse($edu->start_date)->format('Y') : '' }}
            –
            {{ $edu->end_date   ? \Carbon\Carbon::parse($edu->end_date)->format('Y')   : ($lang === 'ar' ? 'حتى الآن' : 'Present') }}
        </div>
    </div>
    @endforeach

</td>

{{-- ─── MAIN ─── --}}
<td class="main">

    {{-- Summary --}}
    @if($info->summary)
    <div class="section-title">{{ $lang === 'ar' ? 'نبذة مختصرة' : 'Summary' }}</div>
    <p class="summary">{{ $info->summary }}</p>
    @endif

    {{-- Experience --}}
    <div class="section-title">{{ $lang === 'ar' ? 'الخبرات المهنية' : 'Work Experience' }}</div>

    @foreach($experiences as $exp)
    <div class="exp-item">
        <div class="exp-position">{{ $exp->position }}</div>
        <div class="exp-company">{{ $exp->company }}</div>
        <div class="exp-meta">
            @php
                $start = $exp->start_date ? \Carbon\Carbon::parse($exp->start_date)->translatedFormat('M Y') : '';
                $end   = $exp->end_date   ? \Carbon\Carbon::parse($exp->end_date)->translatedFormat('M Y')   : ($lang === 'ar' ? 'حتى الآن' : 'Present');
            @endphp
            {{ $start }} – {{ $end }}
            @if($exp->location)
                &nbsp;·&nbsp; {{ $exp->location }}
            @endif
            @if($exp->employment_type)
                &nbsp;·&nbsp;
                <span class="badge">{{ ucfirst(str_replace('-', ' ', $exp->employment_type->value)) }}</span>
            @endif
        </div>
        @if($exp->description)
        <div class="exp-desc">{{ $exp->description }}</div>
        @endif
    </div>
    @endforeach

</td>

</tr>
</table>

</body>
</html>

<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\PersonalInfo;
use App\Models\Setting;
use App\Models\Skill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class CvController extends Controller
{
    public function download(Request $request, string $locale): Response
    {
        $lang = in_array($request->query('lang'), ['en', 'ar']) ? $request->query('lang') : $locale;
        App::setLocale($lang);

        $info        = PersonalInfo::main();
        $experiences = Experience::ordered()->get();
        $educations  = Education::ordered()->get();
        $skills      = Skill::ordered()->get()->groupBy(fn ($s) => $s->category->value);

        $pdf = Pdf::loadView('pdf.cv', compact('info', 'experiences', 'educations', 'skills', 'lang'))
            ->setPaper('a4')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isFontSubsettingEnabled', true)
            ->setOption('defaultFont', $lang === 'ar' ? 'dejavusans' : 'helvetica');

        $filename = "Omar_Mohammed_Sultan_CV_{$lang}.pdf";

        return $pdf->download($filename);
    }
}

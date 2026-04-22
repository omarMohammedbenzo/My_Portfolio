<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Root redirect: / → /{locale}
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $supported = ['en', 'ar'];
    $browser   = substr(request()->getPreferredLanguage($supported) ?? '', 0, 2);
    $locale    = in_array($browser, $supported) ? $browser : 'en';

    return redirect("/{$locale}");
})->name('root');

/*
|--------------------------------------------------------------------------
| Locale switcher
|--------------------------------------------------------------------------
*/
Route::get('/set-locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->where('locale', 'en|ar')->name('set-locale');

/*
|--------------------------------------------------------------------------
| Public routes (locale-prefixed)
|--------------------------------------------------------------------------
*/
Route::prefix('{locale}')
    ->where(['locale' => 'en|ar'])
    ->middleware(['setlocale', 'logpageview'])
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('home');
        Route::get('/about', [\App\Http\Controllers\Public\AboutController::class, 'index'])->name('about');
        Route::get('/projects', [\App\Http\Controllers\Public\ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{slug}', [\App\Http\Controllers\Public\ProjectController::class, 'show'])->name('projects.show');
        Route::get('/contact', [\App\Http\Controllers\Public\ContactController::class, 'index'])->name('contact');
        Route::post('/contact', [\App\Http\Controllers\Public\ContactController::class, 'store'])->name('contact.store')->withoutMiddleware(['logpageview'])->middleware('throttle:5,60');

        Route::get('/cv', [\App\Http\Controllers\Public\CvController::class, 'download'])->name('cv.download')->withoutMiddleware(['logpageview']);

        Route::post('/reactions', [\App\Http\Controllers\Public\ReactionController::class, 'store'])->name('reactions.store')->withoutMiddleware(['logpageview'])->middleware('throttle:10,1');
    });

/*
|--------------------------------------------------------------------------
| Dashboard routes (auth-protected)
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')
    ->middleware(['auth', 'setlocale'])
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');

        Route::get('/personal-info', [\App\Http\Controllers\Dashboard\PersonalInfoController::class, 'edit'])->name('personal-info.edit');
        Route::put('/personal-info', [\App\Http\Controllers\Dashboard\PersonalInfoController::class, 'update'])->name('personal-info.update');

        Route::put('experiences/reorder', [\App\Http\Controllers\Dashboard\ExperienceController::class, 'reorder'])->name('experiences.reorder');
        Route::resource('experiences', \App\Http\Controllers\Dashboard\ExperienceController::class)->except(['show']);

        Route::put('educations/reorder', [\App\Http\Controllers\Dashboard\EducationController::class, 'reorder'])->name('educations.reorder');
        Route::resource('educations', \App\Http\Controllers\Dashboard\EducationController::class)->except(['show']);

        Route::put('skills/reorder', [\App\Http\Controllers\Dashboard\SkillController::class, 'reorder'])->name('skills.reorder');
        Route::resource('skills', \App\Http\Controllers\Dashboard\SkillController::class)->except(['show']);

        Route::put('projects/reorder', [\App\Http\Controllers\Dashboard\ProjectController::class, 'reorder'])->name('projects.reorder');
        Route::post('projects/{project}/images', [\App\Http\Controllers\Dashboard\ProjectController::class, 'uploadImage'])->name('projects.images.store');
        Route::delete('projects/{project}/images/{image}', [\App\Http\Controllers\Dashboard\ProjectController::class, 'deleteImage'])->name('projects.images.destroy');
        Route::resource('projects', \App\Http\Controllers\Dashboard\ProjectController::class)->except(['show']);

        Route::get('/messages', [\App\Http\Controllers\Dashboard\MessageController::class, 'index'])->name('messages.index');
        Route::put('/messages/{message}/read', [\App\Http\Controllers\Dashboard\MessageController::class, 'markRead'])->name('messages.read');
        Route::delete('/messages/{message}', [\App\Http\Controllers\Dashboard\MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('/reactions', [\App\Http\Controllers\Dashboard\ReactionController::class, 'index'])->name('reactions.index');

        Route::get('/analytics', [\App\Http\Controllers\Dashboard\AnalyticsController::class, 'index'])->name('analytics.index');

        Route::get('/settings', [\App\Http\Controllers\Dashboard\SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [\App\Http\Controllers\Dashboard\SettingsController::class, 'update'])->name('settings.update');
    });

/*
|--------------------------------------------------------------------------
| Auth routes (Sanctum session)
|--------------------------------------------------------------------------
*/
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'show'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->middleware('throttle:5,1');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'destroy'])->middleware('auth')->name('logout');

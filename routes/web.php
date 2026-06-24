<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PolicyBriefController;
use App\Http\Controllers\TwoFactorChallengeController;
use App\Livewire\ExpertQuerySubmit;
use App\Livewire\MpOnboardingWizard;
use App\Livewire\ResearcherKanban;
use App\Livewire\SeniorReviewPane as SeniorReviewComponent;
use App\Models\ExpertQuery;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── Public ──────────────────────────────────────────────────────────────
Route::get('/', function () {
    $stats = [
        'active_users' => \App\Models\User::count(),
        'total_queries' => \App\Models\ExpertQuery::count(),
        'policy_briefs' => \App\Models\PolicyBrief::count(),
    ];
    return view('welcome', compact('stats'));
})->name('home');

// ── Public Pages ─────────────────────────────────────────────────────────
Route::view('/mp-profiles', 'public.mp-profiles')->name('mp-profiles');
Route::view('/gov-sites', 'public.gov-sites')->name('gov-sites');
Route::view('/our-team', 'public.our-team')->name('our-team');
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'show'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// ── Two-Factor Authentication (outside Fortify's default) ───────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/two-factor-challenge', function () {
        if (app(TwoFactorService::class)->sessionIsVerified()) {
            return redirect()->intended(route('dashboard'));
        }
        return view('auth.two-factor-challenge');
    })->name('two-factor.challenge');

    Route::post('/two-factor-challenge', [TwoFactorChallengeController::class, 'verify'])
        ->name('two-factor.verify');

    Route::post('/two-factor-challenge/resend', [TwoFactorChallengeController::class, 'resend'])
        ->name('two-factor.resend');
});

// ── Authenticated + 2FA Verified ────────────────────────────────────────
Route::middleware(['auth', 'two-factor'])->group(function () {
    // Onboarding wizard for new MPs
    Route::get('/onboarding', MpOnboardingWizard::class)
        ->name('onboarding');

    // Dashboard
    Route::get('/dashboard', DashboardController::class)
        ->name('dashboard');

    // Policy Brief Single View
    Route::get('/policy-briefs/{brief:slug}', [PolicyBriefController::class, 'show'])
        ->name('policy-briefs.show');

    // Legislative Tracker
    Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
    Route::get('/bills/{slug}', [BillController::class, 'show'])->name('bills.show');

    // ── Ask-An-Expert: MP Submission ──────────────────────────
    Route::get('/expert-query/submit', ExpertQuerySubmit::class)
        ->name('expert-query.submit');

    // ── Researcher Workspace (restricted to researchers) ───────
    Route::middleware(['role:senior_researcher,junior_researcher'])->group(function () {
        Route::get('/research/kanban', ResearcherKanban::class)
            ->name('researcher.kanban');

        Route::get('/research/review/{query}', SeniorReviewComponent::class)
            ->name('researcher.review');
    });

    // ── Admin: Page Content Management (restricted to admins) ──
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/page-contents', [\App\Http\Controllers\Admin\PageContentController::class, 'index'])
            ->name('page-contents.index');
        Route::get('/page-contents/{page}/{section}', [\App\Http\Controllers\Admin\PageContentController::class, 'edit'])
            ->name('page-contents.edit');
        Route::put('/page-contents/{page}/{section}', [\App\Http\Controllers\Admin\PageContentController::class, 'update'])
            ->name('page-contents.update');
    });
});

// ── Logout ──────────────────────────────────────────────────────────────
Route::post('/logout', LogoutController::class)
    ->middleware('auth')
    ->name('logout');

// ── Fortify Auth Routes ─────────────────────────────────────────────────

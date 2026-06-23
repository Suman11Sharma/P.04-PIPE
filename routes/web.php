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
    $features = [
        [
            'title' => 'Policy Briefs',
            'description' => 'Curated expert briefings across 10 policy sectors with rich markdown content, executive summaries, and an MP feedback engine.',
            'icon' => 'document',
            'color' => 'emerald',
        ],
        [
            'title' => 'Legislative Tracker',
            'description' => 'Real-time bill progress with multi-stage steppers, side-by-side amendment comparison with diff highlighting.',
            'icon' => 'scale',
            'color' => 'blue',
        ],
        [
            'title' => 'Ask-An-Expert',
            'description' => 'Submit research queries with tiered turnaround options: Standard, 48-Hour Deep Analysis, or 30-Minute Floor Support.',
            'icon' => 'chat',
            'color' => 'amber',
        ],
        [
            'title' => 'Personal Dashboard',
            'description' => 'Personalized MP workspace with intelligence feed, query tracking, upcoming legislation, and policy risk alerts.',
            'icon' => 'dashboard',
            'color' => 'purple',
        ],
        [
            'title' => 'Researcher Kanban',
            'description' => 'Internal workflow management with SLA monitoring, senior review workflows, and automated breach detection.',
            'icon' => 'kanban',
            'color' => 'rose',
        ],
        [
            'title' => 'Bill Comparison',
            'description' => 'Side-by-side amendment delta with color-coded diff highlighting, constitutional summaries, and voting ledger charts.',
            'icon' => 'compare',
            'color' => 'indigo',
        ],
    ];
    return view('welcome', compact('stats', 'features'));
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
});

// ── Logout ──────────────────────────────────────────────────────────────
Route::post('/logout', LogoutController::class)
    ->middleware('auth')
    ->name('logout');

// ── Fortify Auth Routes ─────────────────────────────────────────────────

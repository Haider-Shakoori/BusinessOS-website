<?php

use App\Models\CaseStudy;
use App\Models\Guide;
use App\Models\PageVisit;
use App\Models\SeoPage;
use App\Models\User;
use App\Services\IndexNowService;
use App\Services\ProductCatalog;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Validator;
use Throwable;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:create {email?}', function (?string $email = null) {
    $name = $this->ask('Admin name', 'BusinessOS Admin');
    $email = $email ?: $this->ask('Admin email');
    $password = $this->secret('Admin password (minimum 12 characters)');

    $validator = Validator::make([
        'name' => $name,
        'email' => $email,
        'password' => $password,
    ], [
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:190'],
        'password' => ['required', 'string', 'min:12'],
    ]);

    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            $this->error($error);
        }

        return 1;
    }

    $user = User::updateOrCreate(
        ['email' => strtolower($email)],
        [
            'name' => $name,
            'password' => $password,
            'is_admin' => true,
        ]
    );

    $this->info("Admin account ready for {$user->email}.");

    return 0;
})->purpose('Create or promote a BusinessOS CMS administrator');

Schedule::call(function (): void {
    PageVisit::query()
        ->where('occurred_at', '<', now()->subDays((int) config('analytics.retention_days', 400)))
        ->delete();
})
    ->dailyAt('03:20')
    ->name('prune-businessos-analytics')
    ->withoutOverlapping();


Artisan::command('search:indexnow', function (IndexNowService $indexNow, ProductCatalog $products) {
    $urls = collect([
        route('home'),
        route('services'),
        route('apps.index'),
        route('resources.index'),
        route('case-studies.index'),
    ])->merge(
        $products->all()->map(fn (array $app) => route('apps.show', $app['slug']))
    );

    try {
        $urls = $urls
            ->merge(SeoPage::published()->get()->map(fn (SeoPage $page) => route('seo-pages.show', $page)))
            ->merge(Guide::published()->get()->map(fn (Guide $guide) => route('resources.show', $guide)))
            ->merge(CaseStudy::published()->get()->map(fn (CaseStudy $caseStudy) => route('case-studies.show', $caseStudy)));
    } catch (Throwable) {
        // Migrations may not have run yet.
    }

    if (! $indexNow->submit($urls->unique()->values()->all())) {
        $this->warn('IndexNow is disabled, not configured, or did not accept the submission.');
        return 1;
    }

    $this->info('Submitted '.$urls->unique()->count().' public URLs to IndexNow.');
    return 0;
})->purpose('Submit the current public BusinessOS URL inventory to IndexNow');

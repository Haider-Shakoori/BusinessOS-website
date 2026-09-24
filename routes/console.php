<?php

use App\Models\PageVisit;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Validator;

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

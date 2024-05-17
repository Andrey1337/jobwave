<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Company;
use App\Models\Job;
use App\Models\Resume;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $companyCount = Company::count();
            $vacancyCount = Job::where('status', 'Активна')->count();
            $resumesCount = Resume::count();
            $view->with(compact('companyCount', 'vacancyCount', 'resumesCount'));
        });
    }
}

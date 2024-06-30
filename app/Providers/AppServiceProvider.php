<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\UploadedFile;

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
        UploadedFile::macro('sizeLimit', function () {
            return (int) env('FILE_UPLOAD_MAX_SIZE', 52428800); // Default 50 MB
        });
    }
}

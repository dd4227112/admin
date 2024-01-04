<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Paginator::useBootstrap();
        if (class_exists('Swift_Preferences')) {
            \Swift_Preferences::getInstance()->setTempDir('storage/tmp');
        } else {
            \Log::warning('Class Swift_Preferences does not exists');
        }
    }

}

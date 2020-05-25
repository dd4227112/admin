<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\schema;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use DB;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // schema::defaultStringLenght(191);
        Queue::before(function (JobProcessing $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });

        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });
    }

    public static function mailConfig() {
        $config = App\Email_config::find(1);
        if (count($config) > 0) {
            return (object) array(
                        'id' => $config->id,
                        'email' => $config->email,
                        'username' => $config->username,
                        'password' => $config->password,
                        'host' => $config->host
            );
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}

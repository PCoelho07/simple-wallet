<?php

namespace App\Providers;

use App\Modules\TransactionAuthorizer\Manager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Modules\TransactionAuthorizer\Contracts\AuthorizerInterface', function ($app) {
            return Manager::make($app['config']->get("transaction_authorizer.default"));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

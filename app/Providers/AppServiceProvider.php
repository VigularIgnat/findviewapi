<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;
use App\Services\HashService;
use App\Services\CheckService;

use App\Services\CurrencyService;

use App\Http\Controllers\Api\HashController;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('hash_service', function(){
            return new HashService();
        });
        $this->app->singleton('hash_controller', function(){
            return new HashController();
        });
        $this->app->singleton('currency_service', function(){
            return new CurrencyService();
        });
        $this->app->singleton('check_access', function(){
            return new CheckService();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('check_hash', function (Hash $hash) {
            $today_date = Carbon::today();
            return $today_date<= $hash->valid;
        });
    }
}

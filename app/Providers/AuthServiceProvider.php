<?php

namespace App\Providers;
use Laravel\Passport\Passport; 
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Passport::routes(); 
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return 'http://127.0.0.1:8000/reset-password?token='.$token;
        });
        // if (! $this->app->routesAreCached()) {
        //     Passport::routes();
        // }
    }
}

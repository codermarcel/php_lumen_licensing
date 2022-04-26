<?php

namespace App\Providers;

use App\Entity\Product;
use App\Entity\User;
use App\Policies\ProductPolicy;
use App\Policies\UserPolicy;
use App\Providers\PolicyProvider;
use App\Service\Jwt\JwtParser;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            return (new JwtParser)->userFromRequest($request);
        });

        $gate = app(GateContract::class);
        $provider = app(PolicyProvider::class);
        $provider->register($gate);
    }
}

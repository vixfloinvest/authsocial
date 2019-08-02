<?php

namespace Laservici\Authsocial;

use Illuminate\Support\ServiceProvider;

class AuthsocialServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Laservici\Authsocial\Contracts\Factory', function ($app) {
            return new AuthsocialManager($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Laservici\Authsocial\Contracts\Factory'];
    }
}

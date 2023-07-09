<?php

namespace NovaNavigaAdPreview;

use Illuminate\Support\Facades\Route;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Http\Middleware\Authenticate;
use Laravel\Nova\Nova;
use NovaNavigaAdPreview\Http\Middleware\Authorize;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-naviga-ad-preview');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function routes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        // Load admin dashboard routes
        Nova::router(
            ['nova', Authenticate::class, Authorize::class],
            'nova-naviga-ad-preview'
        )
            ->group(__DIR__.'/../routes/inertia.php');

        // Load api routes
        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-naviga-ad-preview')
            ->group(__DIR__.'/../routes/api.php');
    }
}

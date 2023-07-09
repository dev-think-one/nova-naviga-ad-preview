<?php

namespace NovaNavigaAdPreview\Tests\Fixtures;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use NovaNavigaAdPreview\NovaNavigaAdPreview;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return true;
        });
    }

    protected function dashboards()
    {
        return [
        ];
    }

    protected function resources()
    {
        Nova::resources([
        ]);
    }

    public function tools()
    {
        return [
            NovaNavigaAdPreview::make()
                // optionally:
                ->menuName('My custom name')
                ->menuIcon('photograph')
                ->canSee(fn ($request) => true /* add your check */),
        ];
    }
}

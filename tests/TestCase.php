<?php

namespace NovaNavigaAdPreview\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Nova\NovaCoreServiceProvider;
use NovaNavigaAdPreview\Tests\Fixtures\NovaServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            NovaCoreServiceProvider::class,
            NovaServiceProvider::class,
            \NavigaAdClient\ServiceProvider::class,
            \NovaNavigaAdPreview\ServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('naviga-ad.credentials', [
            'username' => 'test_user',
            'password' => 'test_secret',
        ]);
        $app['config']->set('naviga-ad.base_url', 'https://test.request');
    }
}

<?php
namespace Midnite81\Auditor;
use Illuminate\Support\ServiceProvider;
use Midnite81\Auditor\Services\Auditor;

class AuditorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    /**
     * Bootstrap the application events.
     *
     * @return void
     * @codeCoverageIgnore
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'auditor');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('midnite81.auditor', function ($app) {
            return new Auditor();
        });
        $this->app->alias('midnite81.auditor', 'Midnite81\Auditor\Contracts\Auditor');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['midnite81.auditor', 'Midnite81\Auditor\Contracts\Auditor'];
    }
}
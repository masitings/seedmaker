<?php

namespace Masitings\SeedMaker;

use Illuminate\Support\ServiceProvider;

class SeedMakerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        require base_path().'/vendor/autoload.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResources();

        $this->app->singleton('seedmaker', function($app) {
            return new SeedMaker;
        });

        $this->app->booting(function() {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('SeedMaker', 'Masitings\SeedMaker\Facades\SeedMaker');
        });

        $this->app->singleton('command.seedmaker', function($app) {
            return new SeedMakerCommand();
        });

        $this->commands('command.seedmaker');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('seedmaker');
    }

    /**
     * Register the package resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $userConfigFile    = app()->configPath().'/seed-maker.php';
        $packageConfigFile = __DIR__.'/../../config/config.php';
        $config            = $this->app['files']->getRequire($packageConfigFile);

        if (file_exists($userConfigFile)) {
            $userConfig = $this->app['files']->getRequire($userConfigFile);
            $config     = array_replace_recursive($config, $userConfig);
        }

        $this->app['config']->set('iseed::config', $config);
    }
}

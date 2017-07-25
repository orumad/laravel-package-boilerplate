<?php

namespace Me\MyPackage\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Me\MyPackage\Exceptions\InvalidConfiguration;
use Me\MyPackage\MyPackage;

class MyPackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/my-package.php' => config_path('my-package.php'),
        ], 'my-package');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/my-package.php', 'my-package');

        $config = config('my-package');

        $this->app->bind(MyPackage::class, function () use ($config) {
            // Checks if configuration is valid
            $this->guardAgainstInvalidConfiguration($config);

            return new MyPackage();
        });

        $this->app->alias(MyPackage::class, 'my-package');
    }

    /**
     * Checks if the config is valid
     * @param  array|null $config the package configuration
     * @return throws an InvalidConfiguration exception or null
     * @see  \Me\MyPackage\Exceptions\InvalidConfiguration
     */
    protected function guardAgainstInvalidConfiguration(array $config = null)
    {
        // Here you can add as many checks as your package config needed to
        // consider it valid.
        // @see \Me\MyPackage\Exceptions\InvalidConfiguration
        if (empty($config['version'])) {
            throw InvalidConfiguration::versionNotSpecified();
        }
    }
}

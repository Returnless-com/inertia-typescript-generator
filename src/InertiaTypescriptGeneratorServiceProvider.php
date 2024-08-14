<?php

declare(strict_types=1);

namespace Returnless\InertiaTypescriptGenerator;

use Illuminate\Support\ServiceProvider;

final class InertiaTypescriptGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/inertia-typescript-generator.php' => config_path('inertia-typescript-generator.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/inertia-typescript-generator.php',
            'inertia-typescript-generator',
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\GenerateTypescriptTypesCommand::class,
            ]);
        }
    }
}

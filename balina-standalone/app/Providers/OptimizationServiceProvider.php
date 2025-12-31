<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Optimization\Contracts\OptimizationInterface;
use App\Services\Optimization\WhaleOptimizationService;
use App\Services\Optimization\ParticleSwarmOptimizationService;

/**
 * Optimization Service Provider
 * 
 * Optimizasyon servislerini Laravel konteynerine kaydeder.
 */
class OptimizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // WOA servisini singleton olarak kaydet
        $this->app->singleton('optimization.woa', function ($app) {
            return new WhaleOptimizationService();
        });

        // PSO servisini singleton olarak kaydet
        $this->app->singleton('optimization.pso', function ($app) {
            return new ParticleSwarmOptimizationService();
        });

        // Alias binding'ler
        $this->app->alias('optimization.woa', WhaleOptimizationService::class);
        $this->app->alias('optimization.pso', ParticleSwarmOptimizationService::class);

        // Factory pattern için
        $this->app->bind('optimization.factory', function ($app) {
            return function (string $algorithm) use ($app) {
                return match (strtolower($algorithm)) {
                    'woa', 'whale' => $app->make('optimization.woa'),
                    'pso', 'particle' => $app->make('optimization.pso'),
                    default => throw new \InvalidArgumentException("Unknown optimization algorithm: {$algorithm}")
                };
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

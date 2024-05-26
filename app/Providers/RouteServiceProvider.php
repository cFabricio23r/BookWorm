<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    private const BASE = 'App\Http\Controllers';

    protected string $apiNamespace = self::BASE.'\API';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapApiRoutes();

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(config('app.api_per_minute'))->by($request->user()?->id ?: $request->ip());
        });
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(config('app.auth_per_minute'))->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapApiRoutes(): void
    {
        Route::middleware(['api', 'api_version:v1'])
            ->namespace("{$this->apiNamespace}\\v1")
            ->prefix('api/v1')
            ->group(base_path('routes/api_v1.php'));
    }
}

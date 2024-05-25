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
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            $this->mapApiRoutes();

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
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

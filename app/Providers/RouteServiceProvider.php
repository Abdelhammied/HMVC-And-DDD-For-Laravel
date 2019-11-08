<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * This namespace is applied to your admin controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $admin_namespace = 'App\Src\Admin\Http\Controllers';

    /**
     * This namespace is applied to your api controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $api_namespace = 'App\Src\Api\Http\Controllers';

    /**
     * This namespace is applied to your frontend controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $frontend_namespace = 'App\Src\Frontend\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        Route::domain(env('APP_URL', 'http://app.test'))
            ->as('frontend.')
            ->middleware(['web', 'auth'])
            ->namespace($this->frontend_namespace)
            ->group(app_path('Src/Frontend/routes/web.php'));

        Route::domain(env('APP_URL', 'http://app.test'))
            ->middleware('web')
            ->as('frontend.')
            ->namespace($this->frontend_namespace)
            ->group(app_path('Src/Frontend/routes/auth.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));

        Route::as('api.')
            ->domain(env('API_URL', 'http://api.app.test'))
            ->middleware(['auth:api'])
            ->namespace($this->api_namespace)
            ->group(app_path('Src/Api/routes/web.php'));

        Route::as('api.')
            ->domain(env('API_URL', 'http://api.app.test'))
            ->middleware('api')
            ->namespace($this->api_namespace)
            ->group(app_path('Src/Api/routes/auth.php'));
    }

    /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::as('admin.')
            ->domain(env('ADMIN_URL', 'http://admin.app.test'))
            ->middleware(['web', 'auth', 'admin'])
            ->namespace($this->admin_namespace)
            ->group(app_path('Src/Admin/routes/web.php'));

        Route::as('admin.')
            ->domain(env('ADMIN_URL', 'http://admin.app.test'))
            ->middleware(['web'])
            ->namespace($this->admin_namespace)
            ->group(app_path('Src/Admin/routes/auth.php'));
    }
}

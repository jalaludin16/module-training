<?php

namespace Module\Training\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleControllers = 'Module\Training\Http\Controllers';

    /**
     * $moduleNamespace variable
     *
     * @var string
     */
    protected $moduleNamespace = 'module';

    /**
     * $moduleName variable
     *
     * @var string
     */
    protected $moduleName = 'training';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
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
            ->prefix($this->moduleName)
            ->namespace($this->moduleControllers)
            ->group(module_path(
                $this->moduleNamespace,
                $this->moduleName,
                'routes/web.php'
            ));
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
        Route::prefix($this->moduleName . '/api')
            ->middleware(['api', 'auth:sanctum'])
            ->namespace($this->moduleControllers)
            ->group(module_path(
                $this->moduleNamespace,
                $this->moduleName,
                'routes/api.php'
            ));
    }
}

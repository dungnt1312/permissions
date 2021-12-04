<?php

namespace DNT\Permission;

use DNT\Permission\Middleware\HasPermission;
use DNT\Permission\Middleware\HasRoles;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBladeExtensions();
        //
    }

    protected function registerBladeExtensions()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {

            $bladeCompiler->directive('role', function ($arguments) {
                list($roles) = explode(',', $arguments.',');
                $roles = !empty($roles) ? explode(',', $roles) : [];
                return '<?php if(fn_has_roles($roles)): ?>';
            });

            $bladeCompiler->directive('endrole', function ($arguments) {
                return "<?php endif ?>";
            });

            $bladeCompiler->directive('permission', function ($arguments) {
                list($permission,$model) = explode(',', $arguments.',');
                return "<?php if(fn_has_permission($permission,$model)): ?>";
            });
            
            $bladeCompiler->directive('endpermission', function ($arguments) {
                return "<?php endif; ?>";
            });
            $bladeCompiler->directive('end', function ($arguments) {
                return "<?php endif; ?>";
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {

        $this->publishes([
            __DIR__ . '/Configs/permission.php' => config_path('permission.php'),
        ]);

        require_once(__DIR__ . '/Helpers/functions.php');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->registerMiddleware($router);

        $this->loadViewsFrom(__DIR__ . '/Views', 'auth');
        //
    }

    private function registerMiddleware(Router $router)
    {
        $router->aliasMiddleware('roles', HasRoles::class);
        $router->aliasMiddleware('permission', HasPermission::class);
    }
}

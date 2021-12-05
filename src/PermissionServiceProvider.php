<?php

namespace DNT\Permission;

use DNT\Permission\Commands\PermissionCommand;
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
        $this->registerFacades();

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        require_once(__DIR__ . '/Helpers/functions.php');

        $this->publishes([
            __DIR__ . '/Configs/permission.php' => config_path('permission.php'),
        ]);
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->registerMiddleware($router);

        $this->registerCommands();
    }

    protected function registerCommands()
    {

        $this->commands([
            PermissionCommand::class
        ]);
    }

    protected function registerMiddleware(Router $router)
    {
        $router->aliasMiddleware('roles', HasRoles::class);
        $router->aliasMiddleware('permission', HasPermission::class);
    }

    protected function registerFacades()
    {
    }

    protected function registerBladeExtensions()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {

            $bladeCompiler->directive('role', function ($arguments) {
                list($roles) = explode(',', $arguments . ',');
                $roles = !empty($roles) ? explode(',', $roles) : [];
                return '<?php if(fn_has_roles($roles)): ?>';
            });

            $bladeCompiler->directive('endrole', function ($arguments) {
                return "<?php endif ?>";
            });

            $bladeCompiler->directive('permission', function ($arguments) {
                list($permission, $model) = explode(',', $arguments . ',');
                return "<?php if(fn_has_permission($permission,$model)): ?>";
            });

            $bladeCompiler->directive('endpermission', function ($arguments) {
                return "<?php endif; ?>";
            });
            $bladeCompiler->directive('end', function ($arguments) {
                return '<?php endif; ?>';
            });
        });
    }
}

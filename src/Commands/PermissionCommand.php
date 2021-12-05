<?php

namespace DNT\Permission\Commands;

use Illuminate\Console\Command;

class PermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto generate role permission module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    protected $controllers = [
        'Controllers/PermissionController.stub' => 'PermissionController.php',
        'Controllers/RoleController.stub' => 'RoleController.php',
    ];

    protected $views = [
        'Views/permissions/create.stub' => 'permissions/create.blade.php',
        'Views/permissions/edit.stub' => 'permissions/edit.blade.php',
        'Views/permissions/form.stub' => 'permissions/form.blade.php',
        'Views/permissions/index.stub' => 'permissions/index.blade.php',
        'Views/roles/create.stub' => 'roles/create.blade.php',
        'Views/roles/edit.stub' => 'roles/edit.blade.php',
        'Views/roles/form.stub' => 'roles/form.blade.php',
        'Views/roles/index.stub' => 'roles/index.blade.php',
    ];

    protected $routes = [
        'routes.stub' => 'routes/web.php'
    ];

    public function handle()
    {
        $this->generateControllers();
        generate()->compileViews($this->views);
        generate()->compileControllers($this->controllers);
        generate()->appendRoutes($this->routes);
    }

    protected function generateControllers()
    {
    }

}

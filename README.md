## Laravel Roles permissions - DungNT Version

### Install
* Package require Auth::routes()
* Install package

```bash
composer require dungnt1312/dnt-permission
```

* Publish config

```bash
php artisan vendor:publish --provider="DNT\Permission\PermissionServiceProvider"
```

* Command auto generate module `Role` and `Permission`

```bash
  php artisan permission:module
```
* Model `App\Model\User` use Traits HasRoles;

```php
    use DNT\Permission\Traits\HasRoles;
    class User extends Authenticatable
    {
        use HasRoles;
        ...
    }
````


### Basic usage

* Blade

```php
    @permission('post-create')
    @endpermission
    
    // like @can of gate
    @permission('delete',$post)
    @endpermission
    
    @permission('delete',\App\Models\User::class)
    @endpermission
    
    @role('editor')
    @endrole
```

* Helpers

```php
    if (!function_exists('fn_auth')) {
        /**
         * @return User | null
         */
        function fn_auth()
        {
            return auth()->user();
        }
    }
   if (!function_exists('fn_has_roles')) {
        function fn_has_roles($roles)
        {
            return  fn_is_super_admin() ||fn_auth()->hasRoles($roles);
        }
    }

    if (!function_exists('fn_has_permission')) {
        function fn_has_permission($permission, $model = null)
        {
            return fn_auth()->hasPermission($permission, $model);
        }
    }

    if (!function_exists('fn_is_super_admin')) {
        function fn_is_super_admin()
        {
            return fn_auth()->isSuperAdmin;
        }
    }
```

* Middleware

```php
    Route::middleware('role:editor');
    Route::middleware('role:editor,guest');
    Route::middleware('permission:post-create');
```

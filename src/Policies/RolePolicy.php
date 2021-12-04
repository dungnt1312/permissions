<?php

namespace DNT\Permission\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update($model, $entity = null)
    {
        return fn_is_super_admin() && !empty($entity) && $entity->name !== config('permission.role_super_admin');
    }

    public function delete($model, $entity = null)
    {
        return fn_is_super_admin() && !empty($entity) && $entity->name !== config('permission.role_super_admin');
    }
}

<?php

namespace DNT\Permission\Traits;

use DNT\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

trait HasRoles
{
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class)->withDefault(function ($role) {
            $role->name = null;
        });
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name;
    }

    public function permissions()
    {
        return $this->roles->permissions;
    }
    public function hasRoles($roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];
        return !in_array($this->roleName, $roles);
    }

    public function getIsSuperAdminAttribute(){
        return $this->roleName === config('permission.role_super_admin', 'super_admin');
    }

    public function hasPermission($permissionName, $model = null): bool
    {

        if (class_exists($model) ||  $model instanceof Model) {
            return $this->can($permissionName, $model);
        }

        return $this->isSuperAdmin || $this->role->permissions->contains(function ($permission) use ($permissionName) {
            return $permission->name == $permissionName;
        });
    }

    public function syncRole($roleId)
    {
        try {
            $roleId = is_numeric($roleId) ? Role::findOrFail($roleId)->id : Role::where('name', $roleId)->firstOrFail()->id;
        } catch (\Throwable $th) {
            abort(404, 'Role not found');
        }
        return $this->update([
            'role_id' => $roleId
        ]);
    }
}

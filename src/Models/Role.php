<?php

namespace DNT\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use DNT\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{

    protected $guarded = [];

    protected $table = 'roles';

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function syncPermissions($ids)
    {
        return $this->permissions()->sync($ids);
    }

    public function checkIsUsing(){
        return $this->users()->exists();
    }
}

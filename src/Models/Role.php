<?php

namespace DNT\Permission\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use DNT\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{

    protected $guarded = [];

    protected $table = 'roles';

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}

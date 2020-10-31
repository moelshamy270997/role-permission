<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_has_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'role_has_permissions');
    }
}

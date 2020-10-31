<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_has_permissions');
    }
}

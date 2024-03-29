<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;


class Checklist extends Model
{

    protected $fillable = [
        'object_domain', 'object_id', 'due', 'urgency', 'description', 'task_id', 'is_completed'
    ];
}

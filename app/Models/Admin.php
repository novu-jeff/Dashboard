<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // The guard name for this model
    protected $guard = 'admins';

    // Fields that can be mass-assigned
    protected $fillable = [
        'name',
        'email',
        'user_type',       // optional: if you track different admin roles
        'zone_assigned',   // optional: if admins are assigned zones
        'password',
        'token',           // optional: for API or verification tokens
    ];

    // Fields hidden when serializing the model
    protected $hidden = [
        'password',
        'remember_token',
        'token', // hide token as well
    ];

    // No relations included, since you only care about authentication
}

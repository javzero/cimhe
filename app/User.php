<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guard = 'user';

    protected $fillable = [
        'name', 'username', 'email', 'password', 'role', 'group', 'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Search Scopes 
    public function scopeSearchName($query, $name)
    {
        $query->where('name', 'LIKE', "%$name%")
              ->orWhere('username', 'LIKE', "%$name%")
              ->orWhere('email', 'LIKE', "%$name%");
    }

    public function scopeSearchRole($query, $role)
    {
        $query->where('role', $role);
    }

    public function scopeSearchGroup($query, $group)
    {
        $query->where('group', $group);
    }

    public function scopeSearchRoleGroup($query, $role=null, $group=null)
    {
        if($role != null && $group != null)
        {
            return $query->where('role', $role)->where('group', $group);
        } 
        elseif($role != null)
        {
            return $query->where('role', $role);
        }
        elseif($group != null)
        {
            return $query->where('group', $group);
        }
    }

     /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}

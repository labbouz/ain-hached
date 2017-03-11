<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'nom', 'prnom', 'societe', 'structure_syndicale_id', 'phone_number','email2', 'avatar', 'logout'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roleuser()
    {
        return $this->hasOne('\App\Role_user');
    }

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function isAdmin()
    {
        if($this->getRole() == "administrator") {
            return true;
        } else {
            return false;
        }
    }

    public function isObservateurRegional()
    {
        if($this->getRole() == "observateur_regional") {
            return true;
        } else {
            return false;
        }
    }

    public function getRole()
    {
        return $this->roleuser->role->slug;
    }
}

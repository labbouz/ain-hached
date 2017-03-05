<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role_user extends Model
{
    protected $table = 'role_user';

    protected $fillable = ['gouvernorat_id', 'secteur_id'];

    public function user()
    {
        return $this->belongsTo('\App\User');

    }

    public function role()
    {
        return $this->belongsTo('\App\Role');

    }
}

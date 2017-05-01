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

    public function gouvernorat()
    {
        return $this->belongsTo('\App\Gouvernorat', 'gouvernorat_id');

    }

    public function secteur()
    {
        return $this->belongsTo('\App\Secteur', 'secteur_id');

    }
}

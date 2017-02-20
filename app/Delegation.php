<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    protected $table = 'delegations';

    protected $fillable = ['nom_delegation','gouvernorat_id'];

    public function gouvernorat()
    {
        return $this->belongsTo('\App\Gouvernorat');

    }
    /*
    public function societes()
    {
        return $this->hasMany('\App\Societe');
    }
    */
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plainte extends Model
{
    protected $table = 'plaintes';

    protected $fillable = ['nom_plainte'];

    /*
    public function dossiers()
    {
        return $this->belongsToMany('\App\Dossier');
    }
    */
}

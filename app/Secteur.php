<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{

    protected $table = 'secteurs';

    protected $fillable = ['nom_secteur'];

    public function conventions()
    {
        return $this->hasMany('\App\Convention')->orderBy('id', 'desc');
    }

    public function societes()
    {
        return $this->hasMany('\App\Societe');
    }




}

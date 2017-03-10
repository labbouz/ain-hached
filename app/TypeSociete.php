<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeSociete extends Model
{
    protected $table = 'types_societes';

    protected $fillable = ['nom_type_societe'];

    public function societes()
    {
        return $this->hasMany('\App\Societe');
    }
}

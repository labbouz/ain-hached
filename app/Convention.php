<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convention extends Model
{
    protected $table = 'conventions';

    protected $fillable = ['nom_convention','secteur_id'];

    public function secteur()
    {
        return $this->belongsTo('\App\Secteur');

    }
}

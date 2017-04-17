<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agresseur extends Model
{
    protected $table = 'agresseurs';

    protected $fillable = ['abus_id', 'nom', 'prenom', 'nationalite', 'responsabilite_1', 'responsabilite_2', 'responsabilite_3'];

    public function abus()
    {
        return $this->belongsTo('App\Abus');
    }
}

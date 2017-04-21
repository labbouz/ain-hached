<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endommage extends Model
{
    protected $table = 'endommages';

    protected $fillable = ['abus_id', 'structure_syndicale_id', 'nom', 'prenom', 'genre', 'age', 'etat_civile', 'nb_enfant', 'phone_number', 'email', 'type_contrat', 'anciennete'];


    public function abus()
    {
        return $this->belongsTo('App\Abus');
    }

    public function structure_syndicale()
    {
        return $this->belongsTo('App\StructureSyndicale');
    }
}

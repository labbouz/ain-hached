<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
    protected $table = 'societes';

    protected $fillable = ['nom_societe',
        'nom_marque',
        'date_cration_societe',
        'type_societe_id',
        'delegation_id',
        'secteur_id',
        'accord_de_fondation',
        'convention_cadre_commun',
        'convention_id',
        'nombre_travailleurs_cdi',
        'nombre_travailleurs_cdd'];

    public function type_societe()
    {
        return $this->belongsTo('\App\TypeSociete');

    }

    public function delegation()
    {
        return $this->belongsTo('\App\Delegation');

    }

    public function secteur()
    {
        return $this->belongsTo('\App\Secteur');

    }

    /*

    public function gouvernorat()
    {
        return $this->belongsTo('\App\Gouvernorat');

    }

    public function convention()
    {
        return $this->belongsTo('\App\Convention');

    }

    */
    public function dossiers()
    {
        return $this->hasMany('\App\Dossier')->orderBy('id', 'desc');
    }
}

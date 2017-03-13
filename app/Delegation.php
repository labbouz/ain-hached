<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    protected $table = 'delegations';

    protected $fillable = ['nom_delegation','gouvernorat_id'];

    private $croisement_secteur = 0;

    public function gouvernorat()
    {
        return $this->belongsTo('\App\Gouvernorat');

    }

    public function societes()
    {
        return $this->hasMany('\App\Societe');
    }

    public function setSecteur($id_secteur)
    {
        return $this->croisement_secteur = $id_secteur;
    }

    public function societesViaSecteur()
    {
        return $this->hasMany('\App\Societe')->where('secteur_id', '=', $this->croisement_secteur)->orderBy('id', 'desc');
    }
}

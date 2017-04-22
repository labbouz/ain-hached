<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abus extends Model
{
    protected $table = 'abus';

    protected $fillable = ['dossier_id', 'violation_id', 'date_violation', 'statut_reglement'];

    public function dossier()
    {
        return $this->belongsTo('\App\Dossier');

    }

    public function violation()
    {
        return $this->belongsTo('\App\Violation');

    }

    public function endommage()
    {
        return $this->hasOne('App\Endommage');
    }

    public function agresseur()
    {
        return $this->hasOne('App\Agresseur');
    }

    public function accrochages_moves()
    {
        return $this->hasMany('App\AccrochageMove');
    }


}

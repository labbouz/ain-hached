<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $table = 'dossiers';
    protected $fillable = ['societe_id', 'created_by'];

    public function societe()
    {
        return $this->belongsTo('\App\Societe');

    }

    public function user()
    {
        return $this->belongsTo('\App\User', 'created_by');

    }

    public function abus()
    {
        return $this->hasMany('\App\Abus')->orderBy('id', 'desc');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Violation extends Model
{
    protected $table = 'violations';

    protected $fillable = ['nom_violation','description_violation','type_violation_id','gravite_id'];

    public function typeviolation()
    {
        return $this->belongsTo('\App\TypeViolation');

    }

    public function gravite()
    {
        return $this->belongsTo('\App\Gravite');

    }

    public function abus()
    {
        return $this->hasMany('\App\Abus')->orderBy('id', 'desc');
    }
}

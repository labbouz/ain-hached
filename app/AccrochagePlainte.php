<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccrochagePlainte extends Model
{
    protected $table = 'accrochages_plaintes';

    protected $fillable = ['abu_id','plainte_id','date_accrochage','description_accrochage','document'];

    public function abus()
    {
        return $this->belongsTo('\App\Abus', 'abu_id');

    }

    public function plainte()
    {
        return $this->belongsTo('\App\Plainte');

    }
}

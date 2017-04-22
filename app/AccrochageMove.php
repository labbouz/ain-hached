<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccrochageMove extends Model
{
    protected $table = 'accrochages_moves';

    protected $fillable = ['abu_id','move_id','date_accrochage','description_accrochage','document'];

    public function abus()
    {
        return $this->belongsTo('\App\Abus', 'abu_id');

    }

    public function move()
    {
        return $this->belongsTo('\App\Move');

    }

}

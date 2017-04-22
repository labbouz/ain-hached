<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    protected $table = 'moves';

    protected $fillable = ['nom_move'];

    public function accrochages_moves()
    {
        return $this->hasMany('App\AccrochageMove');
    }
}

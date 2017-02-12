<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    protected $table = 'moves';

    protected $fillable = ['nom_move'];
}

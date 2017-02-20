<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gravite extends Model
{
    protected $table = 'gravites';

    public function violations()
    {
        return $this->hasMany('\App\Violation');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gouvernorat extends Model
{
    protected $table = 'gouvernorats';

    protected $fillable = ['nom_gouvernorat','permission_slug'];

    public function delegations()
    {
        return $this->hasMany('\App\Delegation')->orderBy('id', 'desc');
    }

}

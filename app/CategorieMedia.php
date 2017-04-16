<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorieMedia extends Model
{
    protected $table = 'categories_medias';


    public function medias()
    {
        return $this->hasMany('\App\Media');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorieMedia extends Model
{
    protected $table = 'categories_medias';

    protected $fillable = ['nom_categorie_media','class_color_categorie_media'];

    public function medias()
    {
        return $this->hasMany('\App\Media');
    }

}

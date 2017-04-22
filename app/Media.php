<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';

    protected $fillable = ['nom_media','categorie_media_id'];

    public function categoriemedia()
    {
        return $this->belongsTo('\App\CategorieMedia');

    }

    public function accrochages_medias()
    {
        return $this->hasMany('App\AccrochageMedia');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccrochageMedia extends Model
{
    protected $table = 'accrochages_medias';

    protected $fillable = ['abu_id','media_id','date_accrochage','description_accrochage','document'];

    public function abus()
    {
        return $this->belongsTo('\App\Abus', 'abu_id');

    }

    public function media()
    {
        return $this->belongsTo('\App\Media');

    }
}

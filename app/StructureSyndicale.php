<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StructureSyndicale extends Model
{
    protected $table = 'structures_syndicales';

    protected $fillable = ['type_structure_syndicale','description_type'];

}

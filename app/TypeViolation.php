<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeViolation extends Model
{
    protected $table = 'types_violations';

    protected $fillable = ['nom_type_violation','description_type_violation','class_color_type_violation'];

    public function violations()
    {
        return $this->hasMany('\App\Violation', 'type_violation_id');
    }

}

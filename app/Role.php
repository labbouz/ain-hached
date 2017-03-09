<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    private $indicateur = 0;

    public function setIndicateur($indicateur)
    {
        return $this->indicateur = $indicateur;
    }


    public function users()
    {
        return $this->hasMany('\App\Role_user')->orderBy('id', 'desc');
    }

    public function deepusers()
    {

        switch ($this->slug) {
            case "administrator":
                return $this->hasMany('\App\Role_user')->orderBy('id', 'desc');
                break;

            case "observateur_regional":
            case "observateur":
            return $this->hasMany('\App\Role_user')->where('gouvernorat_id', '=', $this->indicateur)->orderBy('id', 'desc');
                break;

            case "observateur_secteur":
                return $this->hasMany('\App\Role_user')->where('secteur_id', '=', $this->indicateur)->orderBy('id', 'desc');
                break;
        }

    }

}

<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 28/10/17
 * Time: 19:26
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{

    protected $table='estados';

    public function Municipios()
    {
        return $this->hasMany('App\Models\Municipio');
    }

    public function Practicantes()
    {
        return $this->hasMany('App\Models\Pacticante');
    }
}
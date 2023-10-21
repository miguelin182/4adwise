<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 28/10/17
 * Time: 19:28
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{

    protected $table='municipios';

    public function Estado()
    {
        return $this->belongsTo('App\Models\Estado');
    }

    public function Practicantes()
    {
        return $this->hasMany('App\Models\Practicante');
    }
}
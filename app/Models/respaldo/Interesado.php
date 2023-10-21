<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 02/11/17
 * Time: 18:47
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Interesado extends  Model
{

    protected  $table='interesados';

    public function estado(){
        return $this->belongsTo('App\Models\Estado');
    }
}
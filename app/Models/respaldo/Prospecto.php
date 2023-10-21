<?php
/**
 * Created by PhpStorm.
 * User: SuZuMa
 * Date: 18/07/2017
 * Time: 09:13 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Prospecto extends Model
{
    protected $table='clientes';

    public function capturado()
    {
        return $this->belongsTo('App\Models\Usuario');
    }

}
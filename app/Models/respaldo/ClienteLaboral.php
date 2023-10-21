<?php
/**
 * Created by PhpStorm.
 * User: SuZuMa
 * Date: 20/07/2017
 * Time: 04:19 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ClienteLaboral extends Model
{
    protected $table='cliente_laboral';

    public function capturado()
    {
        return $this->belongsTo('App\Models\Prospecto');
    }

}
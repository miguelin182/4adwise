<?php
/**
 * Created by PhpStorm.
 * User: SuZuMa
 * Date: 20/07/2017
 * Time: 06:06 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ClienteEgreso extends  Model
{
    protected $table='cliente_egesos';

    public function cliente()
    {
        return $this->belongsTo('App\Models\Prospecto');
    }

}
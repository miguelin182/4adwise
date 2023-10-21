<?php
/**
 * Created by PhpStorm.
 * User: SuZuMa
 * Date: 20/07/2017
 * Time: 05:39 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ClienteIngreso extends Model
{
    protected $table='cliente_ingresos';

    public function prospecto()
    {
        return $this->belongsTo('App\Models\Prospecto');
    }

}
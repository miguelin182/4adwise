<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 12/12/17
 * Time: 15:40
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Practicante extends Model
{
    protected $table='practicantes';

    public function Estado()
    {
        return $this->belongsTo('App\Models\Estado');
    }

    public function Municipio()
    {
        return $this->belongsTo('App\Models\Municipio');
    }

}
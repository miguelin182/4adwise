<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 02/11/17
 * Time: 19:20
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Interesado;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class InteresadoRepository
{
    private $interesado;
    public function __construct()
    {
        $this->interesado=new Interesado();
    }

    public function guardar(Interesado $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(InteresadoRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Interesado{
        $dato=new Interesado();
        try{
            $dato=$this->interesado->find($id);
        }catch (\Exception $e){
            Log::error(InteresadoRepository::class,$e->getMessage());
        }
        return $dato;
    }

    public function listar():Collection{
        $datos=[];
        try{
            $datos = $this->interesado
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(InteresadoRepository::class,$e->getMessage());
        }
        return $datos;
    }

}
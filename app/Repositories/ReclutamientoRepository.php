<?php
/**
 * Created by PhpStorm.
 * User: Miguel Angel Becerra
 * Date: 03/01/2018
 * Time: 09:27 AM
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Reclutamiento;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class ReclutamientoRepository
{
    Private $reclutamiento;
    public function __construct()
    {
        $this->reclutamiento = new Reclutamiento();
    }

    public function listar():Collection{
        $datos=[];
        try{
            $datos=$this->reclutamiento
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(ReclutamientoRepository::class,$e->getMessage());
        }
        return $datos;
    }

    public function guardar(Reclutamiento $model):ResponseHelper{
        $rh = new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch(\Exception $e){
            Log::error(ReclutamientoRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function guardarmod(Reclutamiento $model):Reclutamiento{
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
        }catch (\Exception $e){
            Log::error(ReclutamientoRepository::class,$e->getMessage());
        }
        return $model;
    }

    public function obtener($id):Reclutamiento{
        $dato=new Reclutamiento();
        try{
            $dato=$this->reclutamiento->find($id);
        }catch (\Exception $e){
            Log::error(InteresadoRepository::class,$e->getMessage());
        }
        return $dato;
    }

}
<?php

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Renta;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class RentaRepository
{
    private $renta;
    public function __construct()
    {
        $this->renta = new Renta();
    }

    public function guardar(Renta $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(RentaRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Renta{
        $dato = new Renta();
        try{
            $dato=$this->renta->find($id);
        }catch (\Exception $e){
            Log::error(RentaRepository::class,$e->getMessage());
        }
        return $dato;
    }

    public function listar():Collection{
        $datos = [];
        try{
            $datos=$this->renta
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(RentaRepository::class,$e->getMessage());
        }
        return $datos;
    }

}
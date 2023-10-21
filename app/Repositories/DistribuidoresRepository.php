<?php


namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Distribuidores;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class DistribuidoresRepository
{
    private $distribuidor;
    public function __construct()
    {
        $this->distribuidor = new Distribuidores();
    }

    public function guardar(Distribuidores $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(DistribuidoresRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Distribuidores{
        $dato = new Distribuidores();
        try{
            $dato=$this->distribuidor->find($id);
        }catch (\Exception $e){
            Log::error(DistribuidoresRepository::class,$e->getMessage());
        }
        return $dato;
    }

    public function obtenerporemail($email):ResponseHelper{
        $rh = new ResponseHelper();
        try{
            $rh->result = $this->distribuidor->where('email',$email)->get();
            $rh->response = true;
        }catch (\Exception $e){
            Log::error(DistribuidoresRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function listar():Collection{
        $datos = [];
        try{
            $datos = $this->distribuidor->orderBy('id', 'DESC')->get();
        }catch (\Exception $e){
            Log::error(DistribuidoresRepository::class,$e->getMessage());
        }
        return $datos;
    }
}
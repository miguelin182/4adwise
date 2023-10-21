<?php


namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Prospectos;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class ProspectosRepository
{
    private $prospectos;
    public function __construct()
    {
        $this->prospectos = new Prospectos();
    }

    public function guardar(Prospectos $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(ProductosNecRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function guardar2($data):ResponseHelper{
        $rh=new ResponseHelper();
        $model = $this->prospectos;
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->insert($data);
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(ProductosNecRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Prospectos{
        $dato = new Prospectos();
        try{
            $dato=$this->prospectos->find($id);
        }catch (\Exception $e){
            Log::error(ProductosNecRepository::class,$e->getMessage());
        }
        return $dato;
    }
    public function listar():Collection{
        $datos = [];
        try{
            $datos = $this->prospectos->orderBy('id', 'DESC')->get();
        }catch (\Exception $e){
            Log::error(ProductosNecRepository::class,$e->getMessage());
        }
        return $datos;
    }

    public function listarpordist($id):Collection{
        $datos = [];
        try{
            $datos = $this->prospectos->where('id_dist',$id)->orderBy('id', 'DESC')->get();
        }catch (\Exception $e){
            Log::error(ProductosNecRepository::class,$e->getMessage());
        }
        return $datos;
    }
}
<?php


namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Oportunidades;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class OportunidadesRepository
{
    private $oportunidades;
    public function __construct()
    {
        $this->oportunidades = new Oportunidades();
    }

    public function guardar(Oportunidades $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(OportunidadesRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function guardar2($data):ResponseHelper{
        $rh=new ResponseHelper();
        try{

            $this->oportunidades->insert($data);
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(OportunidadesRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Oportunidades{
        $dato = new Oportunidades();
        try{
            $dato=$this->oportunidades->find($id);
        }catch (\Exception $e){
            Log::error(OportunidadesRepository::class,$e->getMessage());
        }
        return $dato;
    }
    public function listar():Collection{
        $datos = [];
        try{
            $datos = $this->oportunidades->orderBy('id', 'DESC')->get();
        }catch (\Exception $e){
            Log::error(OportunidadesRepository::class,$e->getMessage());
        }
        return $datos;
    }

    public function listarpordist($id):Collection{
        $datos = [];
        try{
            $datos = $this->oportunidades->where('id_dist',$id)->orderBy('id', 'DESC')->get();
        }catch (\Exception $e){
            Log::error(OportunidadesRepository::class,$e->getMessage());
        }
        return $datos;
    }
}
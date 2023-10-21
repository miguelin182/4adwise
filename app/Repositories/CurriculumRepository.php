<?php


namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Curriculum;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class CurriculumRepository
{
    private $curriculum;
    public function __construct()
    {
        $this->curriculum = new Curriculum();
    }

    public function guardar(Curriculum $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(CurriculumRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Curriculum{
        $dato = new Curriculum();
        try{
            $dato=$this->curriculum->find($id);
        }catch (\Exception $e){
            Log::error(CurriculumRepository::class,$e->getMessage());
        }
        return $dato;
    }

    public function listar():Collection{
        $datos = [];
        try{
            $datos = $this->curriculum->orderBy('id', 'DESC')->get();
        }catch (\Exception $e){
            Log::error(CurriculumRepository::class,$e->getMessage());
        }
        return $datos;
    }
}
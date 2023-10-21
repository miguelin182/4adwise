<?php


namespace App\Repositories;

use App\Helpers\ResponseHelper;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;
use App\Models\EvaluacionL;

class EvaluacionLRepository
{
    private $eval;

    public function __construct()
    {
        $this->eval = new EvaluacionL();
    }


    public function listar(): Collection
    {
        $datos = [];
        try {
            $datos = $this->eval->get();
        } catch (\Exception $e) {
            Log::error(EvaluacionLRepository::class, $e->getMessage());
        }
        return $datos;
    }

    public function guardar($model): ResponseHelper
    {
        $rh=new ResponseHelper();

        try {
            $this->eval = $model;
            if (isset($this->eval->id)) {
                $this->eval->exists = true;
            }
            $this->eval->save();
            $rh->result = $this->eval->id;
            $rh->setResponse(true);
        } catch (\Exception $e) {
            Log::error(EvaluacionLRepository::class, $e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):EvaluacionL{
        $dato= new EvaluacionL();
        try{
            $dato=$this->eval->find($id);
        } catch (\Exception $e) {
            Log::error(EvaluacionLRepository::class, $e->getMessage());
        }
        return $dato;
    }

    public function buscar($id):Collection{
        $dato= new EvaluacionL();
        try{
            $dato=$this->eval->where('id_emp',$id)->get();
        } catch (\Exception $e) {
            Log::error(EvaluacionLRepository::class, $e->getMessage());
        }
        return $dato;
    }
}
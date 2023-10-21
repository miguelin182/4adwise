<?php


namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Models\Analisis;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class AnalisisRepository
{
    private $ana;

    public function __construct()
    {
        $this->ana = new Analisis();
    }


    public function listar(): Collection
    {
        $datos = [];
        try {
            $datos = $this->ana->get();
        } catch (\Exception $e) {
            Log::error(AnalisisRepository::class, $e->getMessage());
        }
        return $datos;
    }

    public function guardar($model): ResponseHelper
    {
        $rh=new ResponseHelper();

        try {
            $this->ana = $model;
            if (isset($this->ana->id)) {
                $this->ana->exists = true;
            }
            $this->ana->save();
            $rh->result = $this->ana->id;
            $rh->setResponse(true);
        } catch (\Exception $e) {
            Log::error(AnalisisRepository::class, $e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Analisis{
        $dato= new Analisis();
        try{
            $dato= $this->ana->find($id);
        } catch (\Exception $e) {
            Log::error(AnalisisRepository::class, $e->getMessage());
        }
        return $dato;
    }

    public function buscar($id):Collection{
        $dato= new Analisis();
        try{
            $dato=$this->ana->where('id_emp',$id)->get();
        } catch (\Exception $e) {
            Log::error(AnalisisRepository::class, $e->getMessage());
        }
        return $dato;
    }
}
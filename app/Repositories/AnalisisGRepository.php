<?php


namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Models\AnalisisG;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;


class AnalisisGRepository
{
    private $anag;

    public function __construct()
    {
        $this->anag = new AnalisisG();
    }


    public function listar(): Collection
    {
        $datos = [];
        try {
            $datos = $this->anag->get();
        } catch (\Exception $e) {
            Log::error(AnalisisGRepository::class, $e->getMessage());
        }
        return $datos;
    }

    public function guardar($model): ResponseHelper
    {
        $rh=new ResponseHelper();

        try {
            $this->anag = $model;
            if (isset($this->anag->id)) {
                $this->anag->exists = true;
            }
            $this->anag->save();
            $rh->result = $this->anag->id;
            $rh->setResponse(true);
        } catch (\Exception $e) {
            Log::error(AnalisisGRepository::class, $e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):AnalisisG{
        $dato= new AnalisisG();
        try{
            $dato= $this->anag->find($id);
        } catch (\Exception $e) {
            Log::error(AnalisisGRepository::class, $e->getMessage());
        }
        return $dato;
    }

    public function buscar($id): Collection{
        $dato = new AnalisisG();
        try{
            $dato=$this->anag->where('id_emp',$id)->get();
        } catch (\Exception $e) {
            Log::error(AnalisisGRepository::class, $e->getMessage());
        }
        return $dato;
    }
}
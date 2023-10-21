<?php


namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Pymes;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class PymesRepository
{
    private $pyme;

    public function __construct()
    {
        $pyme = new Pymes();
    }

    public function listar(): Collection
    {
        $datos = [];
        try {
            $datos = $this->pyme->where('status', true)->get();
        } catch (\Exception $e) {
            Log::error(PymesRepository::class, $e->getMessage());
        }
        return $datos;
    }

    public function guardar($model): ResponseHelper
    {
        $rh = new ResponseHelper();

        try {
            $this->pyme = $model;
            if (isset($this->practicante->id)) {
                $this->pyme->exists = true;
            }
            $this->pyme->save();
            $rh->setResponse(true);
        } catch (\Exception $e) {
            Log::error(PymesRepository::class, $e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Pymes{
        $dato = new Pymes();
        try{
            $dato=$this->pyme->find($id);
        } catch (\Exception $e) {
            Log::error(PymesRepository::class, $e->getMessage());
        }
        return $dato;
    }
}
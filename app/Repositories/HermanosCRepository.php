<?php


namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\HermanosC;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class HermanosCRepository
{
    private $her;

    public function __construct()
    {
        $this->her = new HermanosC();
    }


    public function listar(): Collection
    {
        $datos = [];
        try {
            $datos = $this->her->get();
        } catch (\Exception $e) {
            Log::error(HermanosCRepository::class, $e->getMessage());
        }
        return $datos;
    }

    public function guardar($model): ResponseHelper
    {
        $rh=new ResponseHelper();

        try {
            $this->her = $model;
            if (isset($this->her->id)) {
                $this->her->exists = true;
            }
            $this->her->save();
            $rh->result = $this->her->id;
            $rh->setResponse(true);
        } catch (\Exception $e) {
            Log::error(HermanosCRepository::class, $e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):HermanosC{
        $dato= new HermanosC();
        try{
            $dato= $this->her->find($id);
        } catch (\Exception $e) {
            Log::error(HermanosCRepository::class, $e->getMessage());
        }
        return $dato;
    }

    public function buscar($id):Collection{
        $dato= new HermanosC();
        try{
            $dato=$this->her->where('id_emp',$id)->get();
        } catch (\Exception $e) {
            Log::error(HermanosCRepository::class, $e->getMessage());
        }
        return $dato;
    }
}
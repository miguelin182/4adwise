<?php


namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Models\Empresa;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class EmpresasRepository
{
    private $emp;

    public function __construct()
    {
        $this->emp = new Empresa();
    }


    public function listar(): Collection
    {
        $datos = new Collection();
        try {
            $datos = $this->emp->get();
        } catch (\Exception $e) {
            Log::error(EmpresasRepository::class, $e->getMessage());
        }
        return $datos;
    }

    public function guardar($model): ResponseHelper
    {
        $rh=new ResponseHelper();

        try {
            $this->emp = $model;
            if (isset($this->her->id)) {
                $this->emp->exists = true;
            }
            $this->emp->save();
            $rh->result = $this->emp->id;
            $rh->setResponse(true);
        } catch (\Exception $e) {
            Log::error(EmpresasRepository::class, $e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Empresa{
        $dato= new Empresa();
        try{
            $dato=$this->emp->find($id);
        } catch (\Exception $e) {
            Log::error(EmpresasRepository::class, $e->getMessage());
        }
        return $dato;
    }

    public function buscar($email):ResponseHelper{
        $rh =  new ResponseHelper();
        try{
            $dato = $this->emp->where('email',$email)->get();
            if(sizeof($dato) == 0) {
                $rh->message = 'No se encontro ninguna empresa registrada con este correo.';
                $rh->response = false;
            } else {
                $rh->response = true;
                $rh->message = 'Empresa encontrada!';
                $rh->result = $dato[0]->id;
            }
        } catch (\Exception $e) {
            Log::error(EmpresasRepository::class, $e->getMessage());
        }
        return $rh;
    }
}
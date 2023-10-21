<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 12/12/17
 * Time: 15:46
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Practicante;
use Cake\Http\Response;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class PracticanteRepository
{
    private $practicante;

    public function __construct()
    {
        $this->practicante = new Practicante();
    }


    public function listar(): Collection
    {
        $datos = [];
        try {
            $datos = $this->practicante->where('status', true)
                ->get();
        } catch (\Exception $e) {
            Log::error(PracticanteRepository::class, $e->getMessage());
        }
        return $datos;
    }

    public function guardar($model): ResponseHelper
    {
        $rh=new ResponseHelper();

        try {
            $this->practicante = $model;
            if (isset($this->practicante->id)) {
                $this->practicante->exists = true;
            }
            $this->practicante->save();
            $rh->setResponse(true);
        } catch (\Exception $e) {
            Log::error(PracticanteRepository::class, $e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Practicante{
        $dato=new Practicante();
        try{
            $dato=$this->practicante->find($id);
        } catch (\Exception $e) {
            Log::error(PracticanteRepository::class, $e->getMessage());
        }
        return $dato;
    }



}
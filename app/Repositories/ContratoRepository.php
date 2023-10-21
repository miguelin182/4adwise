<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 2/26/2018
 * Time: 4:25 PM
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Contrato;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class ContratoRepository
{
    private $contrato;
    public function __construct()
    {
        $this->contrato = new Contrato();
    }

    public function guardar(Contrato $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(RentaRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Contrato{
        $dato = new Contrato();
        try{
            $dato=$this->contrato->find($id);
        }catch (\Exception $e){
            Log::error(RentaRepository::class,$e->getMessage());
        }
        return $dato;
    }


    public function listar():Collection{
        $datos = [];
        try{
            $datos=$this->contrato
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(RentaRepository::class,$e->getMessage());
        }
        return $datos;
    }
    public function listarcad():Collection{
        $datos = [];
        try{
            $datos=$this->contrato
                ->whereRaw('fecha_ter <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)')
                ->where('estado',true)
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(RentaRepository::class,$e->getMessage());
        }
        return $datos;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Miguel Angel Becerra
 * Date: 03/01/2018
 * Time: 10:02 AM
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Referencia;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class ReferenciaRepository
{
    Private $referencia;
    public function __construct()
    {
        $this->referencia = new Referencia();
    }
    public function listar():Collection{
        $datos=[];
        try{
            $datos=$this->referencia
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(ReferenciaRepository::class,$e->getMessage());
        }
        return $datos;
    }
    public function listarporpersona(Int $id):Collection{
        $datos=[];
        try{
            $datos=$this->referencia
                ->where('referido',$id)
                ->get();
        }catch (\Exception $e){
            Log::error(ReferenciaRepository::class,$e->getMessage());
        }
        return $datos;
    }

    public function guardar(Referencia $model):ResponseHelper{
        $rh = new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch(\Exception $e){
            Log::error(ReferenciaRepository::class,$e->getMessage());
        }
        return $rh;
    }
    public function obtener($id):Referencia{
        $dato=new Referencia();
        try{
            $dato=$this->referencia->find($id);
        }catch (\Exception $e){
            Log::error(InteresadoRepository::class,$e->getMessage());
        }
        return $dato;
    }
}
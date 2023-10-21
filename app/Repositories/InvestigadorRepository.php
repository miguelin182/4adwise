<?php
/**
 * Created by PhpStorm.
 * User: Miguel Angel Becerra
 * Date: 03/01/2018
 * Time: 08:49 AM
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Investigador;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class InvestigadorRepository
{
    private $investigador;
    public function __construct()
    {
        $this->investigador = new Investigador();
    }

    public function listar():Collection{
        $datos=[];
        try{
            $datos=$this->investigador
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(InvestigadorRepository::class,$e->getMessage());
        }
        return $datos;
    }

    public function guardar(Investigador $model):ResponseHelper{
        $rh = new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch(\Exception $e){
            Log::error(InvestigadorRepository::class,$e->getMessage());
        }
        return $rh;
    }
    public function obtener($id):Investigador{
        $dato=new Investigador();
        try{
            $dato=$this->investigador->find($id);
        }catch (\Exception $e){
            Log::error(InteresadoRepository::class,$e->getMessage());
        }
        return $dato;
    }
}
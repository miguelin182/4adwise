<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 28/10/17
 * Time: 17:54
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Suscriptor;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class SuscriptoresRepository
{
    private $suscriptor;

    public function __construct()
    {
        $this->suscriptor=new Suscriptor();
    }


    public function guardar(Suscriptor $model):ResponseHelper {

        $rh=new ResponseHelper();
        try{
            $this->suscriptor=$model;
            if(isset($model->id)){
                $this->suscriptor->exists=true;
            }
            $this->suscriptor->save();
            $rh->setResponse(true);
            $rh->result=$this->suscriptor;
        }catch (\Exception $e){
            Log::error(SuscriptoresRepository::class,$e->getMessage());
        }

        return $rh;
    }


    public function existeEmail($email):ResponseHelper {
        $rh=new ResponseHelper();
        $datos=[];
        try{
            $datos=$this->suscriptor->where('email',$email)
                ->get();
        }catch (\Exception $e){
            Log::error(SuscriptoresRepository::class,$e->getMessage());
        }
        if(count($datos)>0){
            $rh->setResponse(true,'Dirección ya existe en la lista');
            $rh->result=$datos[0];
        }
        return $rh;

    }


    public function listar():Collection{
        $datos=[];
        try{
            $datos=$this->suscriptor->where('status',true)
                ->get();
        }catch (\Exception $e){
            Log::error(SuscriptoresRepository::class,$e->getMessage());
        }

        return $datos;
    }


}
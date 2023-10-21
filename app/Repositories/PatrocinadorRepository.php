<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 09/10/2019
 * Time: 12:01 PM
 */

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Models\Patrocinador;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class PatrocinadorRepository
{
    private $patrocinador;
    function __construct()
    {
        $this->patrocinador = new Patrocinador();
    }
    public function guardar(Patrocinador $model):ResponseHelper{
        $rh = new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(PatrocinadorRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Patrocinador{
        $dato = new Patrocinador();
        try{
            $dato=$this->patrocinador->find($id);
        }catch (\Exception $e){
            Log::error(PatrocinadorRepository::class,$e->getMessage());
        }
        return $dato;
    }

    public function listar():Collection{
        $datos=[];
        try{
            $datos=$this->patrocinador
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(PatrocinadorRepository::class,$e->getMessage());
        }
        return $datos;
    }
}
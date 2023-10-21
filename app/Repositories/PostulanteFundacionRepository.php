<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 17/09/2019
 * Time: 12:28 PM
 */

namespace App\Repositories;



use App\Helpers\ResponseHelper;
use App\Models\Postulante_fundacion;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class PostulanteFundacionRepository
{
    private $interesado;
    function __construct()
    {
        $this->interesado = new Postulante_fundacion();
    }
    public function guardar(Postulante_fundacion $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(InteresadoRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):Postulante_fundacion{
        $dato = new Postulante_fundacion();
        try{
            $dato=$this->interesado->find($id);
        }catch (\Exception $e){
            Log::error(InteresadoRepository::class,$e->getMessage());
        }
        return $dato;
    }

    public function listar():Collection{
        $datos=[];
        try{
            $datos=$this->interesado
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(InteresadoRepository::class,$e->getMessage());
        }
        return $datos;
    }

}
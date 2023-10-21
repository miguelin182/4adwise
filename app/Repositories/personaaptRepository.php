<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 09/08/2019
 * Time: 11:37 AM
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\persona_aptitudes;
use Illuminate\Database\Eloquent\Collection;
use Core\Log;

class personaaptRepository
{
    private $persona_apt;

    function __construct()
    {
        $this->persona_apt = new persona_aptitudes();
    }

    public function listar(): Collection
    {
        $datos = [];
        try {
            $datos = $this->persona_apt->get();
        } catch (\Exception $e) {
            Log::error(PracticanteRepository::class, $e->getMessage());
        }
        return $datos;
    }

    public function  guardar(persona_aptitudes $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            $this->persona_apt = $model;
            if(!empty($model->id)){
                $this->persona_apt->exists=true;
            }
            $this->persona_apt->save();
            $rh->setResponse(true);
            $rh->result = $this->persona_apt->id;
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):persona_aptitudes{
        $dato=new persona_aptitudes();
        try{
            $dato=$this->persona_apt->find($id);
        } catch (\Exception $e) {
            Log::error(PracticanteRepository::class, $e->getMessage());
        }
        return $dato;
    }

}
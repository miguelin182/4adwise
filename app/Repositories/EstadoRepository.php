<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 28/10/17
 * Time: 19:29
 */

namespace App\Repositories;


use App\Models\Estado;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class EstadoRepository
{
    private $estado;
    public function __construct()
    {
        $this->estado=new Estado();
    }

    public function listar():Collection{

        $datos=[];
        try{
            $datos=$this->estado->get();

        }catch (\Exception $e){
            Log::error(EstadoRepository::class,$e->getMessage());
        }

        return $datos;
    }
    public function obtener($id):Estado{
        $dato = new Estado();
        try{
            $dato=$this->estado->find($id);
        }catch (\Exception $e){
            Log::error(CurriculumRepository::class,$e->getMessage());
        }
        return $dato;
    }

}
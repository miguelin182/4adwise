<?php


namespace App\Repositories;


use App\Models\Municipio;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class MunicipioRepository
{
    private $municipio;
    public function __construct()
    {
        $this->municipio = new Municipio();
    }

    public function listar($id):Collection{

        $datos=[];
        try{
            $datos=$this->municipio->where('estado_id',$id)->get();

        }catch (\Exception $e){
            Log::error(MunicipioRepository::class,$e->getMessage());
        }

        return $datos;
    }

}
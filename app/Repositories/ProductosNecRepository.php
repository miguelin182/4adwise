<?php


namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\ProductosNec;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class ProductosNecRepository
{
    private $ProductosNec;
    public function __construct()
    {
        $this->ProductosNec = new ProductosNec();
    }

    public function guardar(ProductosNec $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(ProductosNecRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id):ProductosNec{
        $dato = new ProductosNec();
        try{
            $dato=$this->ProductosNec->find($id);
        }catch (\Exception $e){
            Log::error(ProductosNecRepository::class,$e->getMessage());
        }
        return $dato;
    }
    public function listar():Collection{
        $datos = [];
        try{
            $datos = $this->ProductosNec->orderBy('id', 'DESC')->get();
        }catch (\Exception $e){
            Log::error(ProductosNecRepository::class,$e->getMessage());
        }
        return $datos;
    }

    public function listarmrenciente($id):Collection{
        $datos = [];
        try{
            $datos = $this->ProductosNec->where('id_dist',$id)->orderBy('created_at', 'DESC')->get();
        }catch (\Exception $e){
            Log::error(ProductosNecRepository::class,$e->getMessage());
        }
        return $datos;
    }
}
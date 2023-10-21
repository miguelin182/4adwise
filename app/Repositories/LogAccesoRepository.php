<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 15/08/17
 * Time: 14:07
 */

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\LogAcceso;
use App\Models\LogMovimiento;
use Core\Auth;
use Core\Log;
use GuzzleHttp\Psr7\Response;

class LogAccesoRepository
{
    private $logacceso;
    private $logmovimiento;

    public function __construct()
    {
        $this->logacceso=new LogAcceso();
        $this->logmovimiento=new LogMovimiento();
    }

    public function guardar(LogAcceso $model){
        $rh=new ResponseHelper();
        try{
            $this->logacceso->id=$model->id;
            $this->logacceso->usuario_id=$model->usuario_id;
            $this->logacceso->ip=$model->ip;
            $this->logacceso->hash_hmac=$model->hash_hmac;
            if(!empty($model->id)){
                $this->logacceso->exists=true;
            }
            $this->logacceso->save();
            $rh->setResponse(true);
            $rh->result=$this->logacceso;

        }catch (\Exception $e){
            Log::error(LogAccesoRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public static function guardarMovimiento(string $pagina){
        $rh=new ResponseHelper();
        $logmovimiento=new LogMovimiento();
        try{
            $usuario=Auth::getCurrentUser();
            $logmovimiento->pagina=$pagina;
            $logmovimiento->hash_hmac=$usuario->hash_hmac;
            $logmovimiento->save();
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(LogAccesoRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function listar(int $usuario_id):array {
        $tProspecto=[];
        try{
            $tProspecto=$this->logacceso
                ->where('usuario_id',$usuario_id)
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();
        }catch (Exception $ex){
            Log::error(LogAccesoRepository::class,$ex->getMessage());
        }
        return $tProspecto;
    }
}
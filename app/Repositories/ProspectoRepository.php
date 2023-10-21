<?php
/**
 * Created by PhpStorm.
 * User: SuZuMa
 * Date: 18/07/2017
 * Time: 09:14 AM
 */

namespace App\Repositories;


use App\Helpers\AnexGridHelper;
use App\Helpers\ResponseHelper;
use App\Models\Producto;
use App\Models\Prospecto;
use Core\Log;
use Dompdf\Exception;
use Illuminate\Database\Eloquent\Collection;

class ProspectoRepository
{
    private $prospecto;
    public function __construct()
    {
        $this->prospecto=new Prospecto();
    }

    public function listarProspectos():string{
        $grid=new AnexGridHelper();
        try{
            $resul=$this->prospecto->where('esprospecto',true)->orderBy(
                $grid->columna,
                $grid->columna_orden
            )->skip($grid->pagina)
                ->take($grid->limite)
                ->get();
            return $grid->responde(
                $resul,
                $this->prospecto->where('esprospecto',true)->count()
            );
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return "";
    }


    public function  guardar(Prospecto $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            $this->prospecto->id=$model->id;
            $this->prospecto->rfc=$model->rfc;
            $this->prospecto->apaterno=$model->apaterno;
            $this->prospecto->amaterno=$model->amaterno;
            $this->prospecto->nombre=$model->nombre;
            $this->prospecto->lugarnacimiento=$model->lugarnacimiento;
            $this->prospecto->fechanacimiento=$model->fechanacimiento;
            $this->prospecto->sexo=$model->sexo;
            $this->prospecto->curp=$model->curp;
            $this->prospecto->celular=$model->celular;
            $this->prospecto->email=$model->email;
            $this->prospecto->entero=$model->entero;
            $this->prospecto->capturo=$model->capturo;

            if(!empty($model->id)){
                $this->prospecto->calle=strtoupper( $model->calle);
                $this->prospecto->numero=strtoupper($model->numero);
                $this->prospecto->entrecalles=strtoupper($model->entrecalles);
                $this->prospecto->codigopostal=strtoupper($model->codigopostal);
                $this->prospecto->colonia=strtoupper($model->colonia);
                $this->prospecto->ciudad=strtoupper($model->ciudad);
                //$this->prospecto->copiaine=$model->copiaine;
                $this->prospecto->ine=strtoupper($model->ine);
                $this->prospecto->estado=strtoupper($model->estado);

                $this->prospecto->copiaine=$model->copiaine;
                $this->prospecto->copiacomprobante=$model->copiacomprobante;
                $this->prospecto->exists=true;
            }
            $this->prospecto->save();
            $rh->setResponse(true);
            $rh->result=$this->prospecto;
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function listar():Collection {
        $tProspecto=[];
        try{
            $tProspecto=$this->prospecto
                ->orderBy('id', 'desc')
                ->get();
        }catch (Exception $ex){
            Log::error(ProspectoRepository::class,$ex->getMessage());
        }
        return $tProspecto;
    }

    public function obtener($id):Collection {
        $tProspecto=[];
        try{
            $tProspecto=$this->prospecto->where('id',$id)
                ->get();
        }catch (Exception $ex){
            Log::error(ProspectoRepository::class,$ex->getMessage());
        }
        return $tProspecto;
    }

    public function buscarGenerico(string $q):array {
        $resul=[];
        try{
            //->selectRaw('clientes.*','CONCAT(apaterno, " ", amaterno, " ", nombre, " " , celular) as ncompleto')
            $resul=$this->prospecto
                ->select('id','nombre','apaterno','amaterno')
                ->selectRaw('CONCAT(apaterno, " ", amaterno, " ", nombre, " " , celular) as ncompleto')
                ->Where('celular','like',"%$q%")
                ->orWhere('nombre','like',"%$q%")
                ->orderBy('nombre')
                ->get()
                ->toArray();
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $resul;
    }

    public function buscarNombre(string $q):array {
        $resul=[];
        try{
            $resul=$this->prospecto
                ->where('nombre', 'like', "%$q%")
                ->orderBy('nombre')
                ->get()
                ->toArray();
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $resul;
    }
    public function buscarAPaterno(string $q):array {
        $resul=[];
        try{
            $resul=$this->prospecto
                ->where('apaterno', 'like', "%$q%")
                ->orderBy('apaterno')
                ->get()
                ->toArray();
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $resul;
    }
    public function buscarAMaterno(string $q):array {
        $resul=[];
        try{
            $resul=$this->prospecto
                ->where('amaterno', 'like', "%$q%")
                ->orderBy('amaterno')
                ->get()
                ->toArray();
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $resul;
    }

    public function buscarFolio(int $q):array {
        $resul=[];
        try{
            $resul=$this->prospecto
                ->where('id',$q)
                ->orderBy('amaterno')
                ->get()
                ->toArray();
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $resul;
    }
    public function buscarFolio2(int $q):Collection {
        $resul=null;
        try{
            $resul=$this->prospecto
                ->where('id',$q)
                ->orderBy('amaterno')
                ->get();
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $resul;
    }

    public function buscarFolioObjeto(int $q):Prospecto{

        $res=new Prospecto();
        try{
            $res=$this->prospecto->where('id',$q)
                ->first();
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $res;
    }
    
    
    public function buscarTelefono(string $q):array {
        $resul=[];
        try{
            $resul=$this->prospecto
                ->where('celular',$q)
                ->orderBy('amaterno')
                ->get()
                ->toArray();
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $resul;
    }
    public function buscarDatos(string $ap,string $am,string $nom):array {
        $resul=[];
        try{
            $resul=$this->prospecto
                ->where('apaterno','like',"%$ap%")
                ->where('amaterno','like',"%$am%")
                ->where('nombre', 'like', "%$nom%")
                ->orderBy('nombre')
                ->get()
                ->toArray();
        }catch (\Exception $e){
            Log::error(ProspectoRepository::class,$e->getMessage());
        }
        return $resul;
    }


    public function existeRfc(string $rfc):bool {
        $res=[];
        try{
            $res=$this->prospecto->where('rfc',strtoupper( $rfc))
                ->get();
        }catch (Exception $e){
            Log::error(ProspectoRepository::class,
                $e->getMessage());
        }
        if(count($res)>0)
            return true;
        else{
            return false;
        }
    }
    public function existeTelefono(string $telefono):bool {
        $res=[];
        try{
            $res=$this->prospecto->where('celular',strtoupper( $telefono))
                ->get();
        }catch (Exception $e){
            Log::error(ProspectoRepository::class,
                $e->getMessage());
        }
        if(count($res)>0)
            return true;
        else{
            return false;
        }
    }

    public function datosLaborales(int $id):array{

    }


    /*
        public function eliminar(int $id) : ResponseHelper {
        $rh = new ResponseHelper;

        try {
            $this->cliente->destroy($id);
            $rh->setResponse(true);
        } catch (Exception $e) {
            Log::error(ClienteRepository::class, $e->getMessage());
        }

        return $rh;
    }
     * */

}
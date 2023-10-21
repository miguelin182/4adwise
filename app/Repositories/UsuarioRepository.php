<?php
namespace App\Repositories;

use Core\{Auth, Log};
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\{ResponseHelper,AnexGridHelper};
use App\Models\{
    LogAcceso, Usuario
};
use Exception;

class UsuarioRepository {
    private $usuario;

    public function __construct(){
        $this->usuario = new Usuario;
    }

    public function guardar(Usuario $model) : ResponseHelper {
        $rh = new ResponseHelper;

        try {
            $this->usuario->id = $model->id;
            $this->usuario->rol_id = $model->rol_id;
            $this->usuario->usuario = $model->usuario;
            $this->usuario->email = $model->email;
            $this->usuario->direccion = $model->direccion;
            $this->usuario->celular = $model->celular;
            $this->usuario->estado = $model->estado;
            $this->usuario->municipio = $model->municipio;
            $this->usuario->empresa = $model->empresa;
            $this->usuario->giro = $model->giro;
            $this->usuario->ventas = $model->ventas;
            $this->usuario->tamano = $model->tamano;

            if(!empty($model->id)){
                /*
                 * Al setear este valor a True hacemos que Eloquent lo considere como un registro existente,
                 * por lo tanto hará un update
                 */
                $this->usuario->exists = true;

                if(!empty($model->password)) {
                    $this->usuario->password = sha1($model->password);
                }
            } else {
                $this->usuario->password = sha1($model->password);
            }

            $this->usuario->save();
            $rh->setResponse(true);
        } catch (Exception $e) {
            Log::error(UsuarioRepository::class, $e->getMessage());
        }

        return $rh;
    }

    public function guardar2(Usuario $model):ResponseHelper{
        $rh=new ResponseHelper();
        try{
            if(!empty($model->id)){
                $model->exists=true;
            }
            $model->save();
            $rh->result = $model->id;
            $rh->setResponse(true);
        }catch (\Exception $e){
            Log::error(UsuarioRepository::class,$e->getMessage());
        }
        return $rh;
    }

    public function obtener($id) : Usuario {
        $usuario = new Usuario;

        try {
            $usuario = $this->usuario->find($id);
        } catch (Exception $e) {
            Log::error(UsuarioRepository::class, $e->getMessage());
        }

        return $usuario;
    }

    public function buscar($correo) : Collection {
        $usuario = new Usuario;

        try {
            $usuario = $this->usuario->where('email','=',$correo)->get();
        } catch (Exception $e) {
            Log::error(UsuarioRepository::class, $e->getMessage());
        }

        return $usuario;
    }

    public function listar() : string {
        $anexgrid = new AnexGridHelper;

        try {
            $result = $this->usuario->orderBy(
                $anexgrid->columna,
                $anexgrid->columna_orden
            )->skip($anexgrid->pagina)
             ->take($anexgrid->limite)
             ->get();

            foreach($result as $r) {
                $r->rol = $r->rol;
            }

            return $anexgrid->responde(
                $result,
                $this->usuario->count()
            );
        } catch (Exception $e) {
            Log::error(UsuarioRepository::class, $e->getMessage());
        }

        return "";
    }

    public function listararray():Collection{
        $datos=[];
        try{
            $datos = $this->usuario
                /*->where('rol_id','!=',1)*/
                ->orderBy('id', 'DESC')
                ->get();
        }catch (\Exception $e){
            Log::error(UsuarioRepository::class,$e->getMessage());
        }
        return $datos;
    }

    public function eliminar(int $id) : ResponseHelper {
        $rh = new ResponseHelper;

        try {
            if(Auth::getCurrentUser()->id == $id) {
                $rh->setResponse(false, 'No puede eliminarse usted mismo');
            } else {
                $this->usuario->destroy($id);
            }
        } catch (Exception $e) {
            Log::error(UsuarioRepository::class, $e->getMessage());
        }

        return $rh;
    }

    public function autenticar(string $correo, string $password) : ResponseHelper {
        $rh = new ResponseHelper();

        try {
            $row = $this->usuario->where('email', $correo)
                                 ->where('password', sha1($password))
                                 ->first();

            if(is_object($row)) {
                $clave= hash_hmac('sha256',$row->correo . date("Y-m-d H:i:s"),'SECRETO');
                Auth::signIn([
                    'id' => $row->id,
                    'usuario' => $row->usuario,
                    'empresa' =>$row->empresa,
                    'email' => $row->email,
                    'rol_id' => $row->rol_id,
                    'hash_hmac'=>$clave
                ]);
                    /*$log=new LogAccesoRepository();
                    $model=new LogAcceso();
                    $model->usuario_id=$row->id;
                    $model->ip=$_SERVER['REMOTE_ADDR'];
                    $model->hash_hmac=$clave;

                    $log->guardar($model);*/
                $rh->setResponse(true);
            } else {
                $rh->setResponse(false, 'Credenciales de aunteticación no válida');
                Log::critical(UsuarioRepository::class, "Intento fallido de autenticación para $correo");
            }
        } catch (Exception $e) {
            Log::error(UsuarioRepository::class, $e->getMessage());
        }

        return $rh;
    }
}
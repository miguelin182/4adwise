<?php
namespace App\Validations;
use App\Repositories\SuscriptoresRepository;
use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;
use App\Models\Usuario;

class UsuarioValidation {

    public static function  validarSuscripcion(array $model){
        try{
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('correo', v::stringType()->notEmpty()->email());

            $tmp=new SuscriptoresRepository();
            $rhTmp=$tmp->existeEmail($model['correo']);
            if($rhTmp->response){
                $rh=new ResponseHelper();
                $rh->setResponse(false,null);
                $rh->validations=['correo'=>$rhTmp->message ];
                exit(json_encode($rh));
            }

            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => '{{name}} es requerido',
                'correo' => '{{name}} es requerido o no esta en el formato correcto',
            ]);

            exit(json_encode($rh));
        }
    }

    public static function validate (array $model) {
        try{
            $v = v::key('usuario', v::stringType()->notEmpty())
              ->key('email', v::stringType()->notEmpty()->email())
                ->key('password', v::stringType()->notEmpty()->length(4))
                ->key('direccion', v::stringType()->notEmpty())
                ->key('celular', v::stringType()->notEmpty())
                ->key('empresa',v::stringType()->notEmpty());

            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'usuario' => 'Es requerido que se llene el campo de nombre',
                'password' => 'la contraseña debe tener como mínimo 4 caracteres',
                'email' => 'Debe ser un correo válido',
                'direccion' => 'Debe llenar la dirección de su empresa',
                'celular' => 'Debe llenar este espacio',
                'empresa' => 'Debe de escrbir la razon social de su empresa',
            ]);

            exit(json_encode($rh));
        }
    }
}
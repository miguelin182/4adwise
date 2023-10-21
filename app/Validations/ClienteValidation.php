<?php
namespace App\Validations;
use App\Repositories\ProspectoRepository;
use Core\Log;
use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;

class ClienteValidation {
    public static function validate (array $model) {
        try{
            $v = v::key('nombre', v::stringType()->length(5, null))
              ->key('direccion', v::stringType()->notEmpty());

            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => '{{name}} debe tener como mínimo 5 caracteres',
                'direccion' => '{{name}} es requerido'
            ]);
            exit(json_encode($rh));
        }
    }


    public static function validatePropecto(array $model){
        try{
            $v = v::key('txtNombre', v::stringType()->notEmpty())
                    ->key('txtAPaterno', v::stringType()->notEmpty())
                    ->key('txtAMaterno', v::stringType()->notEmpty())
                    ->key('txtRfc', v::stringType()->notEmpty())
                    ->key('cmbLugarNacimiento', v::stringType()->notEmpty())
                    ->key('radSexo', v::stringType()->notEmpty())
                    ->key('txtCurp', v::stringType()->notEmpty())
                    ->key('txtCelular', v::phone()->notEmpty())
                    ->key('txtEmail', v::email()->notEmpty());

            $pr=new ProspectoRepository();
            if($pr->existeRfc($model['txtRfc'])){
                $rh=new ResponseHelper();
                $rh->setResponse(false,null);
                $rh->validations=['txtRfc'=>'El RFC ingresado no puede ser utilizado, ya esta siendo utilzado por otro cliente' ];
                exit(json_encode($rh));
            }elseif ($pr->existeTelefono($model['txtCelular'])){
                $rh=new ResponseHelper();
                $rh->setResponse(false,null);
                $rh->validations=['txtCelular'=>'El número celular no puede ser utilizado, ya existe en la base de datos con otro usuario' ];
                exit(json_encode($rh));
            }

            $v->assert($model);
        }catch (\Exception $e){
            Log::debug(ClienteValidation::class,$e->getMessage());
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'txtNombre' => '{{name}} es requerido',
                'txtAPaterno' => '{{name}} es requerido',
                'txtAMaterno' => '{{name}} es requerido',
                'txtRfc' => '{{name}} es requerido',
                'cmbLugarNacimiento' => '{{name}} es requerido',
                'radSexo' => '{{name}} es requerido',
                'txtCurp' => '{{name}} es requerido',
                'txtCelular' => '{{name}} es requerido',
                'txtEmail' => '{{name}} es requerido'
            ]);
            exit(json_encode($rh));
        }
    }

    public static function validarPersonal(array $model){
        try{
            $v = v::key('calle', v::stringType()->notEmpty())
                ->key('colonia', v::stringType()->notEmpty())
                ->key('ciudad', v::stringType()->notEmpty())
                ->key('numero', v::stringType()->notEmpty())
                ->key('entre', v::stringType()->notEmpty())
                ->key('cp', v::stringType()->notEmpty())
                ->key('ine', v::stringType()->notEmpty())
                ->key('estado', v::stringType()->notEmpty())
                ->key('copiaine', v::stringType()->notEmpty())
                ->key('copiacomprobante', v::stringType()->notEmpty());

            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'calle' => '{{name}} es requerido',
                'colonia' => '{{name}} es requerido',
                'ciudad' => '{{name}} es requerido',
                'numero' => '{{name}} es requerido',
                'entre' => '{{name}} es requerido',
                'cp' => '{{name}} es requerido',
                'estado' => '{{name}} es requerido',
                'ine' => '{{name}} es requerido',
                'copiaine' => 'Se requiere copia de la credencia de elector o identificacion oficial',
                'copiacomprobante' => 'Se requiere comprobante de domicilio'
            ]);
            exit(json_encode($rh));
        }
    }

}
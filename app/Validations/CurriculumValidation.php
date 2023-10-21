<?php


namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;

class CurriculumValidation
{
    public static function validate(array $model){
        try {
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('email', v::stringType()->notEmpty()->email())
                ->key('direccion', v::stringType()->notEmpty())
                ->key('estado', v::stringType()->notEmpty())
                ->key('ciudad', v::stringType()->notEmpty())
                ->key('sexo', v::stringType()->notEmpty())
                ->key('fecha', v::stringType()->notEmpty())
                ->key('telefono', v::stringType()->notEmpty())
                ->key('curp', v::stringType()->notEmpty())
                ->key('rfc', v::stringType()->notEmpty())
                ->key('universidad', v::stringType()->notEmpty())
                ->key('carrera', v::stringType()->notEmpty())
                ->key('especialidad', v::stringType()->notEmpty())
                ->key('computo', v::stringType()->notEmpty())
                ->key('viajar', v::stringType()->notEmpty())
                ->key('transporte', v::stringType()->notEmpty())
                ->key('estado_civ', v::stringType()->notEmpty());

            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Es requerido',
                'email' => 'Es requerido o debe ser una dirección de correo valida',
                'telefono' => 'Es requerido',
                'direccion' => 'Es requerido',
                'estado' => 'Es requerido',
                'ciudad' => 'Es requerido',
                'sexo' => 'Es requerido',
                'fecha' => 'Es requerido',
                'curp' => 'Es requerido',
                'rfc' => 'Es requerido',
                'universidad' => 'Es requerido',
                'carrera' => 'Es requerido',
                'especialidad' => 'Es requerido',
                'computo' => 'Es requerido',
                'viajar' => 'Es requerido',
                'transpporte' => 'Es requerido',
                'estado_civ' => 'Es requerido',
            ]);
            exit(json_encode($rh));
        }
    }
}
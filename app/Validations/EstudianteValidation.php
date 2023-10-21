<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 18/09/2019
 * Time: 12:39 PM
 */

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;

class EstudianteValidation
{
    public static function validate(array $model){
        try{
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('celular', v::stringType()->notEmpty())
                ->key('email',v::stringType()->notEmpty()->email())
                ->key('fecha',v::stringType()->notEmpty())
                ->key('escuela',v::stringType()->notEmpty())
                ->key('area',v::stringType()->notEmpty());

            $v->assert($model);
        } catch (\Exception $e){
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Campo requerido',
                'celular' => 'Campo requerido',
                'email' => 'Campo requerido o debe ser una dirección de correo valida',
                'fecha' => 'Campo requerido',
                'escuela' => 'Campo requerido',
                'area' => 'Campo requerido'
        ]);

            exit(json_encode($rh));
        }
    }
}
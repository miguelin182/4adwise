<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 21/09/2019
 * Time: 12:11 PM
 */

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;

class CuestAptValidation
{
    public static function validate(array $model){
        try{
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('fecha_nac', v::stringType()->notEmpty())
                ->key('email',v::stringType()->notEmpty()->email())
                ->key('celular',v::stringType()->notEmpty())
                ->key('trabajo',v::stringType()->notEmpty());

            $v->assert($model);
        } catch (\Exception $e){
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Campo requerido',
                'fecha_nac' => 'Campo requerido',
                'email' => 'Campo requerido o debe ser una dirección de correo valida',
                'celular' => 'Campo requerido',
                'trabajo' => 'Campo requerido'
            ]);

            exit(json_encode($rh));
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 10/10/2019
 * Time: 10:47 AM
 */

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;

class PatrocinadorValidation
{
    public static function validate(array $model){
        try{
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('celular', v::stringType()->notEmpty())
                ->key('email',v::stringType()->notEmpty()->email());

            $v->assert($model);
        } catch (\Exception $e){
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Campo requerido',
                'celular' => 'Campo requerido',
                'email' => 'Campo requerido o debe ser una dirección de correo valida'
            ]);

            exit(json_encode($rh));
        }
    }
}
<?php

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;

class RentaValidation
{

    public static function validate(array $model)
    {
        try {
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('email', v::stringType()->notEmpty()->email())
                ->key('celular', v::stringType()->notEmpty());

            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Es requerido',
                'email' => 'Es requerido o debe ser una dirección de correo valida',
                'celular' => 'Es requerido',
            ]);
            exit(json_encode($rh));
        }
    }
}
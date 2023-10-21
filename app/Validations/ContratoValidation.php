<?php
/**
 * Created by PhpStorm.
 * User: Miguel
 * Date: 2/26/2018
 * Time: 4:34 PM
 */

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;

class ContratoValidation
{
    public static function validate(array $model)
    {
        try {
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('empresa', v::stringType()->notEmpty())
                ->key('duracion', v::stringType()->notEmpty())
                ->key('fecha_exp', v::stringType()->notEmpty());

            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Es requerido',
                'empresa' => 'Es requerido',
                'duracion' => 'Es requerido',
                'fecha_exp' => 'Es requerido',
            ]);
            exit(json_encode($rh));
        }
    }
}
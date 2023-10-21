<?php
/**
 * Created by PhpStorm.
 * User: Miguel Angel Becerra
 * Date: 21/12/2017
 * Time: 11:11 AM
 */

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;
class InvestigadorValidation
{
    public static function validate (array $model) {
        try{
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('apellidos', v::stringType()->notEmpty())
                ->key('dia', v::stringType()->notEmpty())
                ->key('mes', v::stringType()->notEmpty())
                ->key('anio', v::stringType()->notEmpty())
                ->key('direccion', v::stringType()->notEmpty())
                ->key('telefono', v::stringType()->notEmpty())
                ->key('sexo', v::stringType()->notEmpty())
                ->key('email', v::stringType()->notEmpty())
                ->key('carrera', v::stringType()->notEmpty())
                ->key('tactualmente',v::stringType()->notEmpty());



            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Campo  requerido',
                'apellidos' => 'Campo  requerido',
                'dia' => 'Día  requerido',
                'mes' => 'Mes  requerido',
                'anio' => 'Año  requerido',
                'direccion' => 'Campo  requerido',
                'telefono' => 'Campo  requerido',
                'sexo' => 'Campo  requerido',
                'email' => 'Campo  requerido',
                'carrera' => 'Campo  requerido',
                'tactualmente' => 'Campo requerido',
            ]);

            exit(json_encode($rh));
        }
    }
}
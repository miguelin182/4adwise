<?php
/**
 * Created by PhpStorm.
 * User: Miguel Angel Becerra
 * Date: 06/01/2018
 * Time: 10:41 AM
 */

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;
class PracticanteValidation
{
    public static function validate (array $model) {
        try{
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('sexo', v::stringType()->notEmpty())
                ->key('movil', v::stringType()->notEmpty())
                ->key('dia', v::stringType()->notEmpty())
                ->key('mes', v::stringType()->notEmpty())
                ->key('anio', v::stringType()->notEmpty())
                ->key('calle', v::stringType()->notEmpty())
                ->key('numero', v::stringType()->notEmpty())
                ->key('email', v::stringType()->notEmpty()->email())
                ->key('colonia', v::stringType()->notEmpty())
                ->key('codigo_postal',v::stringType()->notEmpty())
                ->key('dia',v::stringType()->notEmpty())
                ->key('mes',v::stringType()->notEmpty())
                ->key('anio',v::stringType()->notEmpty())
                ->key('universidad',v::stringType()->notEmpty())
                ->key('carrera', v::stringType()->notEmpty());



            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Campo  requerido',
                'sexo' => 'Campo  requerido',
                'dia' => 'dia  requerido',
                'mes' => 'mes  requerido',
                'anio' => 'año  requerido',
                'calle' => 'Campo  requerido',
                'movil' => 'Campo  requerido',
                'numero' => 'Campo  requerido',
                'email' => 'Introduzca un email valido',
                'colonia' => 'Campo  requerido',
                'codigo_postal' => 'Campo  requerido',
                'universidad' => 'Campo requerido',
                'carrera' => 'Campo requerido',
            ]);

            exit(json_encode($rh));
        }
    }
}
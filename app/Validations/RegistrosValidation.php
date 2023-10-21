<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 12/12/17
 * Time: 16:35
 */

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;
class RegistrosValidation
{
    public static function validate (array $model) {
        try{
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('sexo', v::stringType()->notEmpty())
                ->key('movil', v::intVal()->notEmpty())
                ->key('email', v::intVal()->notEmpty())
                ->key('calle', v::intVal()->notEmpty())
                ->key('numero', v::intVal()->notEmpty())
                ->key('colonia', v::intVal()->notEmpty())
                ->key('codigo_postal', v::intVal()->notEmpty())
                ->key('universidad', v::intVal()->notEmpty())
                ->key('carrera', v::intVal()->notEmpty())
                ->key('bconseguir', v::intVal()->notEmpty())
                ->key('gtrabajar', v::intVal()->notEmpty())
                ->key('ttrabajo', v::intVal()->notEmpty());



            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Campo  requerido',
                'sexo' => 'Campo  requerido',
                'movil' => 'Campo  requerido',
                'email' => 'Campo  requerido',
                'calle' => 'Campo  requerido',
                'numero' => 'Campo  requerido',
                'colonia' => 'Campo  requerido',
                'codigo_postal' => 'Campo  requerido',
                'universidad' => 'Campo  requerido',
                'carrera' => 'Campo  requerido',
                'bconseguir' => 'Campo  requerido',
                'gtrabajar' => 'Campo  requerido',
                'ttrabajo' => 'Campo  requerido',
            ]);

            exit(json_encode($rh));
        }
    }
}
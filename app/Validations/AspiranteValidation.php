<?php

namespace App\Validations;

use App\Repositories\ProspectoRepository;
use Core\Log;
use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;

class AspiranteValidation
{

    public static function validate(array $model)
    {
        try {
            $v = v::key('nombre', v::stringType()->notEmpty())
                ->key('apellidos', v::stringType()->notEmpty())
                ->key('email', v::stringType()->notEmpty()->email())
                ->key('celular', v::stringType()->notEmpty())
                ->key('ocupacion', v::stringType()->notEmpty())
                ->key('perfil', v::stringType()->notEmpty())
                ->key('en', v::stringType()->notEmpty())
                ->key('fnacimiento', v::stringType()->notEmpty())
                ->key('estado', v::stringType()->notEmpty())
                ->key('ciudad', v::stringType()->notEmpty())
                ->key('cuento', v::stringType()->notEmpty())
                ->key('sector', v::stringType()->notEmpty())
                ->key('especialidad', v::stringType()->notEmpty())
                ->key('giro', v::stringType()->notEmpty())
                //->key('cuentocon', v::stringType()->notEmpty())
                ->key('efisico', v::stringType()->notEmpty())
                ->key('financiamiento', v::stringType()->notEmpty())
                ->key('asesoria', v::stringType()->notEmpty())
                ->key('socios', v::stringType()->notEmpty())
                ->key('administracion', v::stringType()->notEmpty())
                ->key('ggobierno', v::stringType()->notEmpty())
                ->key('proveedores', v::stringType()->notEmpty())
                ->key('clientes', v::stringType()->notEmpty())
                ->key('rbancarias', v::stringType()->notEmpty())
                ->key('rfinancieros', v::stringType()->notEmpty())
                ->key('etrabajar', v::stringType()->notEmpty())
                ->key('interesado', v::stringType()->notEmpty())
                ->key('investigacion', v::stringType()->notEmpty())
                ->key('tinteresa', v::stringType()->notEmpty())
                ->key('rinvertir', v::stringType()->notEmpty())
                ->key('nidea', v::stringType()->notEmpty())
                ->key('cideas', v::stringType()->notEmpty())
                //->key('dias', v::stringType()->notEmpty())
                ->key('tinteres', v::stringType()->notEmpty())


            ;

            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'nombre' => 'Es requerido',
                'apellidos' => 'Es requerido',
                'email' => 'Es requerido o debe ser una dirección de correo valida',
                'celular' => 'Es requerido',
                'ocupacion' => 'Es requerido',
                'perfil' => 'Es requerido',
                'en' => 'Es requerido',
                'fnacimiento' => 'Es requerido',
                'estado' => 'Es requerido',
                'ciudad' => 'Es requerido',
                'cuento' => 'Es requerido',
                'sector' => 'Es requerido',
                'especialidad' => 'Es requerido',
                'giro' => 'Es requerido',
               // 'cuentocon'=>'Es requerido',
                'efisico'=>'Es requerido',
                'financiamiento'=>'Es requerido',
                'asesoria'=>'Es requerido',
                'socios'=>'Es requerido',
                'administracion'=>'Es requerido',
                'clientes'=>'Es requerido',
                'proveedores'=>'Es requerido',
                'ggobierno'=>'Es requerido',
                'rbancarias'=>'Es requerido',
                'rfinancieros'=>'Es requerido',
                'etrabajar'=>'Es requerido',
                'interesado'=>'Es requerido',
                'investigacion'=>'Es requerido',
                'rinvertir'=>'Es requerido',
                'tinteresa'=>'Es requerido',
                'nidea'=>'Es requerido',
                'cideas'=>'Es requerido',
               // 'dias'=>'Es requerido',
                'tinteres'=>'Es requerido',

            ]);
            exit(json_encode($rh));
        }
    }
}
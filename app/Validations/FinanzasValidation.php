<?php


namespace App\Validations;


use App\Helpers\ResponseHelper;
use Respect\Validation\Validator as v;

class FinanzasValidation
{
    public static function validate (array $model) {
        try{
            $v = v::key('f1', v::floatType()->max(10)->notEmpty())
                ->key('f2', v::floatType()->max(10)->notEmpty())
                ->key('f3', v::floatType()->max(10)->notEmpty())
                ->key('f4', v::floatType()->max(10)->notEmpty())
                ->key('f5', v::floatType()->max(10)->notEmpty())
                ->key('f6', v::floatType()->max(10)->notEmpty())
                ->key('f7', v::floatType()->max(10)->notEmpty())
                ->key('f8', v::floatType()->max(10)->notEmpty())
                ->key('f9', v::floatType()->max(10)->notEmpty())
                ->key('f10', v::floatType()->max(10)->notEmpty())
                ->key('f11', v::floatType()->max(10)->notEmpty())
                ->key('f12', v::floatType()->max(10)->notEmpty())
                ->key('empresa', v::stringType()->notEmpty());

            $v->assert($model);
        } catch (\Exception $e) {
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $e->findMessages([
                'empresa' => 'Este Campo no puede estar vacio',
                'f1' => 'La calificación maxima es 10',
                'f2' => 'La calificación maxima es 10',
                'f3' => 'La calificación maxima es 10',
                'f4' => 'La calificación maxima es 10',
                'f5' => 'La calificación maxima es 10',
                'f6' => 'La calificación maxima es 10',
                'f7' => 'La calificación maxima es 10',
                'f8' => 'La calificación maxima es 10',
                'f9' => 'La calificación maxima es 10',
                'f10' => 'La calificación maxima es 10',
                'f11' => 'La calificación maxima es 10',
                'f12' => 'La calificación maxima es 10'
            ]);
            exit(json_encode($rh));
        }
    }
}
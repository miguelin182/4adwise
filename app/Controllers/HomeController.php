<?php
/**
 * Created by PhpStorm.
 * User: suzumadev
 * Date: 10/08/17
 * Time: 15:04
 */

namespace App\Controllers;


use App\Helpers\ResponseHelper;
use App\Models\Analisis;
use App\Models\AnalisisG;
use App\Models\Empresa;
use App\Models\EvaluacionL;
use App\Models\HermanosC;
use App\Models\ProductosNec;
use App\Models\Registrog;
use App\Repositories\AnalisisGRepository;
use App\Repositories\AnalisisRepository;
use App\Repositories\DistribuidoresRepository;
use App\Repositories\EmpresasRepository;
use App\Repositories\EvaluacionLRepository;
use App\Repositories\HermanosCRepository;
use App\Repositories\OportunidadesRepository;
use App\Repositories\ProductosNecRepository;
use App\Repositories\ProspectosRepository;
use App\Repositories\RegistrogRepository;
use App\Repositories\UsuarioRepository;
use Core\Auth;
use Core\Controller;
use Core\ServicesContainer;
use Illuminate\Database\Eloquent\Model;

class HomeController extends Controller
{
    private $config;
    private $herRepo;
    private $empRepo;
    private $evalRepo;
    private $anavul;
    private $anavulg;
    private $distribuidor;
    private $prodnec;
    private $prospectos;
    private $oportunidades;
    private $registrog;
    private $usuarios;

    public function __construct()
    {
        parent::__construct();
        $this->config = ServicesContainer::getConfig();
        $this->herRepo = new HermanosCRepository();
        $this->empRepo = new EmpresasRepository();
        $this->evalRepo = new EvaluacionLRepository();
        $this->anavul = new AnalisisRepository();
        $this->anavulg = new AnalisisGRepository();
        $this->distribuidor = new DistribuidoresRepository();
        $this->prodnec = new ProductosNecRepository();
        $this->oportunidades = new OportunidadesRepository();
        $this->prospectos = new ProspectosRepository();
        $this->registrog = new RegistrogRepository();
        $this->usuarios = new  UsuarioRepository();
    }

    public function getindex(){
        return $this->render('Autodiagnosticos/enlace.twig', [
            'title' => 'Enlace',
            'menu' => false,
            'company_name' => '4adwise',
            'usuario' => Auth::getCurrentUser()
        ]);
    }

    public function getanalisis(){
        return $this->render('Autodiagnosticos/registro.twig', [
            'title' => 'Inicio',
            'menu' => false,
            'company_name' => '4adwise'
        ]);
    }

    public function geteval()
    {
        $usuario = Auth::getCurrentUser();
        $check = $this->herRepo->buscar($usuario->id);
        if (count($check) == 0){
            $model = new HermanosC();
            $model->id_emp = $usuario->id;
            $this->herRepo->guardar($model);
        }

        return $this->render('Autodiagnosticos/cuestionario.twig', [
            'title' => 'Inicio',
            'menu' => false,
            'company_name' => '4adwise',
            'cuestionario' => $this->herRepo->buscar($usuario->id)
        ]);
    }

    public function postregistro(){
        $emp = new Empresa();

        $emp->empresa = $_POST['empresa'];
        $emp->nombre = $_POST['nombre'];
        $emp->giro = $_POST['giro'];
        $emp->celular = $_POST['celular'];
        $emp->email = $_POST['email'];

        $rh = $this->empRepo->guardar($emp);


        $eval = new HermanosC();
        $cuest = new EvaluacionL();
        $anavul = new Analisis();
        $anavulg = new AnalisisG();


        $eval->id_emp = $rh->result;
        $cuest->id_emp = $rh->result;
        $anavul->id_emp = $rh->result;
        $anavulg->id_emp = $rh->result;
        $rh = $this->herRepo->guardar($eval);
        if($rh->response){
            $rh = $this->evalRepo->guardar($cuest);
            $rh = $this->anavul->guardar($anavul);
            $rh = $this->anavulg->guardar($anavulg);
            if ($rh->response){
                $rh->message = 'Se guardo exitosamente!';
                $rh->href = 'home/eval/'.$eval->id_emp;
            } else {
                $rh->message = 'Error en el registro, Por favor comuniquese con el administrador';
            }
        } else {
            $rh->message = 'Error en el registro, Por favor comuniquese con el administrador';
        }

        print_r(
            json_encode($rh)
        );
    }

    public function postregistro2(){
        $emp = new Empresa();

        $emp->empresa = $_POST['empresa'];
        $emp->nombre = $_POST['nombre'];
        $emp->giro = $_POST['giro'];
        $emp->celular = $_POST['celular'];
        $emp->email = $_POST['email'];

        $rh = $this->empRepo->guardar($emp);


        $eval = new HermanosC();
        $cuest = new EvaluacionL();
        $anavul = new Analisis();
        $anavulg = new AnalisisG();


        $eval->id_emp = $rh->result;
        $cuest->id_emp = $rh->result;
        $anavul->id_emp = $rh->result;
        $anavulg->id_emp = $rh->result;
        $rh = $this->herRepo->guardar($eval);
        if($rh->response){
            $rh = $this->evalRepo->guardar($cuest);
            $rh = $this->anavul->guardar($anavul);
            $rh = $this->anavulg->guardar($anavulg);
            if ($rh->response){
                $rh->message = 'Se guardo exitosamente!';
                $rh->href = 'home/cuest/'.$eval->id_emp;
            } else {
                $rh->message = 'Error en el registro, Por favor comuniquese con el administrador';
            }
        } else {
            $rh->message = 'Error en el registro, Por favor comuniquese con el administrador';
        }

        print_r(
            json_encode($rh)
        );
    }

    public function postbuscar(){
        $rh = new ResponseHelper();

        $rh = $this->empRepo->buscar($_POST['email']);
        if($rh->response) {
            $rh->href = 'home/eval/'.$rh->result;
        }
        print_r(
            json_encode($rh)
        );
    }

    public function postregistro3(){
        $emp = new Empresa();

        $emp->empresa = $_POST['empresa'];
        $emp->nombre = $_POST['nombre'];
        $emp->giro = $_POST['giro'];
        $emp->celular = $_POST['celular'];
        $emp->email = $_POST['email'];

        $rh = $this->empRepo->guardar($emp);


        $eval = new HermanosC();
        $cuest = new EvaluacionL();
        $anavul = new Analisis();
        $anavulg = new AnalisisG();


        $eval->id_emp = $rh->result;
        $cuest->id_emp = $rh->result;
        $anavul->id_emp = $rh->result;
        $anavulg->id_emp = $rh->result;
        $rh = $this->herRepo->guardar($eval);
        if($rh->response){
            $rh = $this->evalRepo->guardar($cuest);
            $rh = $this->anavul->guardar($anavul);
            $rh = $this->anavulg->guardar($anavulg);
            if ($rh->response){
                $rh->message = 'Se guardo exitosamente!';
                $rh->href = 'home/cuesan/'.$eval->id_emp;
            } else {
                $rh->message = 'Error en el registro, Por favor comuniquese con el administrador';
            }
        } else {
            $rh->message = 'Error en el registro, Por favor comuniquese con el administrador';
        }

        print_r(
            json_encode($rh)
        );
    }

    public function postguardar() {

        $fin = new HermanosC();
        $fin->id = $_POST['id'];
        $fin->f1 = $_POST['f1'];
        $fin->f2 = $_POST['f2'];
        $fin->f3 = $_POST['f3'];
        $fin->f4 = $_POST['f4'];
        $fin->f5 = $_POST['f5'];
        $fin->f6 = $_POST['f6'];
        $fin->f7 = $_POST['f7'];
        $fin->f8 = $_POST['f8'];
        $fin->f9 = $_POST['f9'];
        $fin->f10 = $_POST['f10'];
        $fin->f11 = $_POST['f11'];
        $fin->f12 = $_POST['f12'];

        $fin->fprom = ($_POST['f1'] + $_POST['f2'] +$_POST['f3'] +$_POST['f4'] +$_POST['f5'] +$_POST['f6'] +$_POST['f7'] +$_POST['f8'] +$_POST['f9'] +$_POST['f10'] +$_POST['f11'] + $_POST['f12']) / 12;

        $rh = $this->herRepo->guardar($fin);
        $rh->message = 'Se guardo exitosamente!';

        if($rh->response){
            print_r(json_encode($rh));
        }

    }

    public function postguardar2() {

        $fin = new HermanosC();

        $fin->id = $_POST['id'];
        $fin->c1 = $_POST['c1'];
        $fin->c2 = $_POST['c2'];
        $fin->c3 = $_POST['c3'];
        $fin->c4 = $_POST['c4'];
        $fin->c5 = $_POST['c5'];
        $fin->c6 = $_POST['c6'];
        $fin->c7 = $_POST['c7'];
        $fin->c8 = $_POST['c8'];
        $fin->c9 = $_POST['c9'];
        $fin->c10 = $_POST['c10'];
        $fin->c11 = $_POST['c11'];
        $fin->c12 = $_POST['c12'];

        $fin->cprom = ($_POST['c1'] + $_POST['c2'] +$_POST['c3'] +$_POST['c4'] +$_POST['c5'] +$_POST['c6'] +$_POST['c7'] +$_POST['c8'] +$_POST['c9'] +$_POST['c10'] +$_POST['c11'] + $_POST['c12']) / 12;

        $rh = $this->herRepo->guardar($fin);
        $rh->message = 'Se guardo exitosamente!';

        if($rh->response){
            print_r(json_encode($rh));
        }

    }

    public function postguardar3() {

        $fin = new HermanosC();

        $fin->id = $_POST['id'];
        $fin->o1 = $_POST['o1'];
        $fin->o2 = $_POST['o2'];
        $fin->o3 = $_POST['o3'];
        $fin->o4 = $_POST['o4'];
        $fin->o5 = $_POST['o5'];
        $fin->o6 = $_POST['o6'];
        $fin->o7 = $_POST['o7'];
        $fin->o8 = $_POST['o8'];
        $fin->o9 = $_POST['o9'];
        $fin->o10 = $_POST['o10'];
        $fin->o11 = $_POST['o11'];
        $fin->o12 = $_POST['o12'];

        $fin->oprom = ($_POST['o1'] + $_POST['o2'] +$_POST['o3'] +$_POST['o4'] +$_POST['o5'] +$_POST['o6'] +$_POST['o7'] +$_POST['o8'] +$_POST['o9'] +$_POST['o10'] +$_POST['o11'] + $_POST['o12']) / 12;

        $rh = $this->herRepo->guardar($fin);
        $rh->message = 'Se guardo exitosamente!';

        if($rh->response){
            print_r(json_encode($rh));
        }

    }

    public function postguardar4() {

        $fin = new HermanosC();

        $fin->id = $_POST['id'];
        $fin->a1 = $_POST['a1'];
        $fin->a2 = $_POST['a2'];
        $fin->a3 = $_POST['a3'];
        $fin->a4 = $_POST['a4'];
        $fin->a5 = $_POST['a5'];
        $fin->a6 = $_POST['a6'];
        $fin->a7 = $_POST['a7'];
        $fin->a8 = $_POST['a8'];
        $fin->a9 = $_POST['a9'];
        $fin->a10 = $_POST['a10'];
        $fin->a11 = $_POST['a11'];
        $fin->a12 = $_POST['a12'];

        $fin->aprom = ($_POST['a1'] + $_POST['a2'] +$_POST['a3'] +$_POST['a4'] +$_POST['a5'] +$_POST['a6'] +$_POST['a7'] +$_POST['a8'] +$_POST['a9'] +$_POST['a10'] +$_POST['a11'] + $_POST['a12']) / 12;

        $rh = $this->herRepo->guardar($fin);
        $rh->message = 'Se guardo exitosamente!';

        if($rh->response){
            print_r(json_encode($rh));
        }

    }

    public function postguardar5() {

        $fin = new HermanosC();

        $fin->id = $_POST['id'];
        $fin->ad1 = $_POST['ad1'];
        $fin->ad2 = $_POST['ad2'];
        $fin->ad3 = $_POST['ad3'];
        $fin->ad4 = $_POST['ad4'];
        $fin->ad5 = $_POST['ad5'];
        $fin->ad6 = $_POST['ad6'];
        $fin->ad7 = $_POST['ad7'];
        $fin->ad8 = $_POST['ad8'];
        $fin->ad9 = $_POST['ad9'];
        $fin->ad10 = $_POST['ad10'];
        $fin->ad11 = $_POST['ad11'];
        $fin->ad12 = $_POST['ad12'];

        $fin->adprom = ($_POST['ad1'] + $_POST['ad2'] +$_POST['ad3'] +$_POST['ad4'] +$_POST['ad5'] +$_POST['ad6'] +$_POST['ad7'] +$_POST['ad8'] +$_POST['ad9'] +$_POST['ad10'] +$_POST['ad11'] + $_POST['ad12']) / 12;

        $rh = $this->herRepo->guardar($fin);
        $rh->message = 'Se guardo exitosamente!';

        if($rh->response){
            print_r(json_encode($rh));
        }

    }

    public function postguardar6() {

        $fin = new HermanosC();

        $fin->id = $_POST['id'];
        $fin->r1 = $_POST['r1'];
        $fin->r2 = $_POST['r2'];
        $fin->r3 = $_POST['r3'];
        $fin->r4 = $_POST['r4'];
        $fin->r5 = $_POST['r5'];
        $fin->r6 = $_POST['r6'];
        $fin->r7 = $_POST['r7'];
        $fin->r8 = $_POST['r8'];
        $fin->r9 = $_POST['r9'];
        $fin->r10 = $_POST['r10'];
        $fin->r11 = $_POST['r11'];
        $fin->r12 = $_POST['r12'];

        $fin->rprom = ($_POST['r1'] + $_POST['r2'] +$_POST['r3'] +$_POST['r4'] +$_POST['r5'] +$_POST['r6'] +$_POST['r7'] +$_POST['r8'] +$_POST['r9'] +$_POST['r10'] +$_POST['r11'] + $_POST['r12']) / 12;

        $rh = $this->herRepo->guardar($fin);
        $rh->message = 'Se guardo exitosamente!';

        if($rh->response){
            print_r(json_encode($rh));
        }

    }

    public function postguardar7() {

        $fin = new HermanosC();

        $fin->id = $_POST['id'];
        $fin->t1 = $_POST['t1'];
        $fin->t2 = $_POST['t2'];
        $fin->t3 = $_POST['t3'];
        $fin->t4 = $_POST['t4'];
        $fin->t5 = $_POST['t5'];
        $fin->t6 = $_POST['t6'];
        $fin->t7 = $_POST['t7'];
        $fin->t8 = $_POST['t8'];
        $fin->t9 = $_POST['t9'];
        $fin->t10 = $_POST['t10'];
        $fin->t11 = $_POST['t11'];
        $fin->t12 = $_POST['t12'];

        $fin->tprom = ($_POST['t1'] + $_POST['t2'] +$_POST['t3'] +$_POST['t4'] +$_POST['t5'] +$_POST['t6'] +$_POST['t7'] +$_POST['t8'] +$_POST['t9'] +$_POST['t10'] +$_POST['t11'] + $_POST['t12']) / 12;

        $rh = $this->herRepo->guardar($fin);
        $rh->message = 'Se guardo exitosamente!';

        if($rh->response){
            print_r(json_encode($rh));
        }

    }

    public function postguardar8() {

        $fin = new HermanosC();

        $fin->id = $_POST['id'];
        $fin->l1 = $_POST['l1'];
        $fin->l2 = $_POST['l2'];
        $fin->l3 = $_POST['l3'];
        $fin->l4 = $_POST['l4'];
        $fin->l5 = $_POST['l5'];
        $fin->l6 = $_POST['l6'];
        $fin->l7 = $_POST['l7'];
        $fin->l8 = $_POST['l8'];
        $fin->l9 = $_POST['l9'];
        $fin->l10 = $_POST['l10'];
        $fin->l11 = $_POST['l11'];
        $fin->l12 = $_POST['l12'];

        $fin->lprom = ($_POST['l1'] + $_POST['l2'] +$_POST['l3'] +$_POST['l4'] +$_POST['l5'] +$_POST['l6'] +$_POST['l7'] +$_POST['l8'] +$_POST['l9'] +$_POST['l10'] +$_POST['l11'] + $_POST['l12']) / 12;

        $rh = $this->herRepo->guardar($fin);
        $rh->message = 'Se guardo exitosamente!';

        if($rh->response){
            print_r(json_encode($rh));
        }

    }

    public function postresr() {
        $rh = new ResponseHelper();
        $rh->response = true;
        $rh->message = '';
        $rh->href = 'home/res/'.$_POST['id'];
        print_r(
            json_encode($rh)
        );
    }

    public function getres() {
        $usuario = Auth::getCurrentUser();

        return $this->render('Autodiagnosticos/resultado.twig', [
            'title' => 'Resultado',
            'menu' => false,
            'company_name' => '4adwise',
            'dato' => $this->herRepo->buscar($usuario->id)
        ]);
    }

    public function getres2($id) {
        return $this->render('Autodiagnosticos/resultado.twig', [
            'title' => 'Resultado',
            'menu' => false,
            'company_name' => '4adwise',
            'dato' => $this->herRepo->buscar($id)
        ]);
    }

    public function getlistado(){
        return $this->render('Autodiagnosticos/listado.twig', [
            'title' => 'Listado de autoevaluaciones',
            'menu' => false,
            'company_name' => '4adwise',
            'datos' => $this->empRepo->listar(),
        ]);
    }

    /*   INICIO CUESTIONARIOS NUEVOS    */
    /***********************************/
    public function getini() {
        return $this->render('Autodiagnosticos/evdem/registro.twig', [
            'title' => 'Cuestionarios',
            'menu' => false,
            'company_name' => '4adwise'
        ]);
    }

    public function getcuest(){
        $usuario = Auth::getCurrentUser();
        $check = $this->evalRepo->buscar($usuario->id);
        if (count($check) == 0){
            $model = new EvaluacionL();
            $model->id_emp = $usuario->id;
            $this->evalRepo->guardar($model);
        }

        return $this->render('Autodiagnosticos/evdem/cuestionario.twig', [
            'title' => 'Cuestionarios',
            'menu' => false,
            'company_name' => '4adwise',
            'cuestionario' => $this->evalRepo->buscar($usuario->id)
        ]);
    }

    public function postbuscar2(){
        $rh = new ResponseHelper();

        $rh = $this->empRepo->buscar($_POST['email']);
        if($rh->response) {
            $rh->href = 'home/cuest/'.$rh->result;
        }
        print_r(
            json_encode($rh)
        );
    }

    public function postgcue1(){
        $model = new EvaluacionL();

        $model->id = $_POST['id'];
        $model->u1 = $_POST['u1'];
        $model->u2 = $_POST['u2'];
        $model->u3 = $_POST['u3'];
        $model->u4 = $_POST['u4'];
        $model->u5 = $_POST['u5'];
        $model->u6 = $_POST['u6'];
        $model->u7 = $_POST['u7'];
        $model->u8 = $_POST['u8'];
        $model->u9 = $_POST['u9'];
        $model->u10 = $_POST['u10'];

        $rh = $this->evalRepo->guardar($model);

        if($rh->response){
            $rh->message = 'Guardado con exito!';
        }

        print_r(
            json_encode($rh)
        );
    }
    public function postgcue2(){
        $model = new EvaluacionL();

        $model->id = $_POST['id'];
        $model->d1_1 = $_POST['d1_1'];
        $model->d1_2 = $_POST['d1_2'];
        $model->d1_3 = $_POST['d1_3'];
        $model->d2_1 = $_POST['d2_1'];
        $model->d2_2 = $_POST['d2_2'];
        $model->d2_3 = $_POST['d2_3'];
        $model->d3_1_1 = $_POST['d3_1_1'];
        $model->d3_1_2 = $_POST['d3_1_2'];
        $model->d3_1_3 = $_POST['d3_1_3'];
        $model->d3_2_1 = $_POST['d3_2_1'];
        $model->d3_2_2 = $_POST['d3_2_2'];
        $model->d3_2_3 = $_POST['d3_2_3'];
        $model->d3_3_1 = $_POST['d3_3_1'];
        $model->d3_3_2 = $_POST['d3_3_2'];
        $model->d3_3_3 = $_POST['d3_3_3'];
        $model->d4_1 = $_POST['d4_1'];
        $model->d4_2 = $_POST['d4_2'];
        $model->d4_3 = $_POST['d4_3'];
        $model->d5_1 = $_POST['d5_1'];
        $model->d5_2 = $_POST['d5_2'];
        $model->d5_3 = $_POST['d5_3'];
        $model->d6_1 = $_POST['d6_1'];
        $model->d6_2 = $_POST['d6_2'];
        $model->d6_3 = $_POST['d6_3'];
        $model->d7_1 = $_POST['d7_1'];
        $model->d7_2 = $_POST['d7_2'];
        $model->d7_3 = $_POST['d7_3'];

        $rh = $this->evalRepo->guardar($model);

        if($rh->response){
            $rh->message = 'Guardado con exito!';
        }

        print_r(
            json_encode($rh)
        );

    }
    public function postgcue3(){
        $model = new EvaluacionL();

        $model->id = $_POST['id'];
        $model->m1 = $_POST['m1'];
        $model->m2 = $_POST['m2'];
        $model->m3 = $_POST['m3'];
        $model->m4 = $_POST['m4'];
        $model->m5 = $_POST['m5'];
        $model->m6 = $_POST['m6'];

        $rh = $this->evalRepo->guardar($model);

        if($rh->response){
            $rh->message = 'Guardado con exito!';
        }

        print_r(
            json_encode($rh)
        );
    }
    public function postgcue4(){
        $model = new EvaluacionL();

        $model->id = $_POST['id'];
        $model->l1 = $_POST['l1'];
        $model->l2 = $_POST['l2'];
        $model->l3 = $_POST['l3'];
        $model->l4 = $_POST['l4'];
        $model->l5 = $_POST['l5'];
        $model->l6 = $_POST['l6'];
        $model->l7 = $_POST['l7'];
        $model->l8 = $_POST['l8'];
        $model->l9 = $_POST['l9'];
        $model->l10 = $_POST['l10'];

        $rh = $this->evalRepo->guardar($model);

        if($rh->response){
            $rh->message = 'Guardado con exito!';
        }

        print_r(
            json_encode($rh)
        );
    }

    public function getresl(){
        $usuario = Auth::getCurrentUser();
        return $this->render('Autodiagnosticos/evdem/resultado.twig', [
            'title' => 'Cuestionarios',
            'menu' => false,
            'company_name' => '4adwise',
            'dato' => $this->evalRepo->buscar($usuario->id)
        ]);
    }
    public function getresl2($id){
        return $this->render('Autodiagnosticos/evdem/resultado.twig', [
            'title' => 'Cuestionarios',
            'menu' => false,
            'company_name' => '4adwise',
            'dato' => $this->evalRepo->buscar($id)
        ]);
    }
    /****************************/
    /* FIN CUESTIONARIOS NUEVOS */
    /* Inicio Analisis 8 áreas especifico */
    /****************************/

    public function getregan() {
        return $this->render('Autodiagnosticos/analisis/registro.twig', [
            'title' => 'Cuestionarios',
            'menu' => false,
            'company_name' => '4adwise'
        ]);
    }

    public function getcuesan(){
        $usuario = Auth::getCurrentUser();
        $check = $this->anavul->buscar($usuario->id);
        if (count($check) == 0){
            $model = new Analisis();
            $model2 = new AnalisisG();
            $model->id_emp = $usuario->id;
            $this->anavul->guardar($model);
            $model2->id_emp = $usuario->id;
            $this->anavulg->guardar($model2);
        }


        return $this->render('Autodiagnosticos/analisis/cuestionario.twig', [
            'title' => 'Cuestionarios',
            'menu' => false,
            'company_name' => '4adwise',
            'cuestionario' => $this->anavul->buscar($usuario->id),
            'cuestionario2' => $this->anavulg->buscar($usuario->id),
        ]);
    }

    public function postbuscar3(){
        $rh = new ResponseHelper();

        $rh = $this->empRepo->buscar($_POST['email']);
        if($rh->response) {
            $rh->href = 'home/cuesan/'.$rh->result;
        }
        print_r(
            json_encode($rh)
        );
    }

    public function postganavul() {

        $fin = new Analisis();
        $fin2 = new AnalisisG();

        $fin->id = $_POST['id'];
        $fin->f1 = $_POST['f1'];
        $fin->f2 = $_POST['f2'];
        $fin->f3 = $_POST['f3'];
        $fin->f4 = $_POST['f4'];
        $fin->f5 = $_POST['f5'];
        $fin->f6 = $_POST['f6'];
        $fin->f7 = $_POST['f7'];
        $fin->f8 = $_POST['f8'];

        $fin2->id = $_POST['id2'];
        $fin2->f1 = $_POST['f1g'];
        $fin2->f2 = $_POST['f2g'];
        $fin2->f3 = $_POST['f3g'];
        $fin2->f4 = $_POST['f4g'];
        $fin2->f5 = $_POST['f5g'];
        $fin2->f6 = $_POST['f6g'];
        $fin2->f7 = $_POST['f7g'];
        $fin2->f8 = $_POST['f8g'];

        $rh = $this->anavul->guardar($fin);
        $rh2 = $this->anavulg->guardar($fin2);

        if($rh->response || $rh2->response){
            $rh->message = 'Se guardo exitosamente!';
        } else {
            $rh->message = 'Hubo un error al guardar, porfavor contacte al administrador.';
        }


        if($rh->response){
            print_r(json_encode($rh));
        }

    }

    public function postganavul2() {

        $fin = new Analisis();
        $fin2 = new AnalisisG();

        $fin->id = $_POST['id'];
        $fin->c1 = $_POST['c1'];
        $fin->c2 = $_POST['c2'];
        $fin->c3 = $_POST['c3'];
        $fin->c4 = $_POST['c4'];
        $fin->c5 = $_POST['c5'];
        $fin->c6 = $_POST['c6'];
        $fin->c7 = $_POST['c7'];

        $fin2->id = $_POST['id2'];
        $fin2->c1 = $_POST['c1g'];
        $fin2->c2 = $_POST['c2g'];
        $fin2->c3 = $_POST['c3g'];
        $fin2->c4 = $_POST['c4g'];
        $fin2->c5 = $_POST['c5g'];
        $fin2->c6 = $_POST['c6g'];
        $fin2->c7 = $_POST['c7g'];

        $rh = $this->anavul->guardar($fin);
        $rh2 = $this->anavulg->guardar($fin2);

        if($rh->response || $rh2->response){
            $rh->message = 'Se guardo exitosamente!';
        } else {
            $rh->message = 'Hubo un error al guardar, porfavor contacte al administrador.';
        }

        if($rh->response){
            print_r(json_encode($rh));
        }
    }

    public function postganavul3() {

        $fin = new Analisis();
        $fin2 = new AnalisisG();

        $fin->id = $_POST['id'];
        $fin->o1 = $_POST['o1'];
        $fin->o2 = $_POST['o2'];
        $fin->o3 = $_POST['o3'];
        $fin->o4 = $_POST['o4'];
        $fin->o5 = $_POST['o5'];
        $fin->o6 = $_POST['o6'];

        $fin2->id = $_POST['id2'];
        $fin2->o1 = $_POST['o1g'];
        $fin2->o2 = $_POST['o2g'];
        $fin2->o3 = $_POST['o3g'];
        $fin2->o4 = $_POST['o4g'];
        $fin2->o5 = $_POST['o5g'];
        $fin2->o6 = $_POST['o6g'];


        $rh = $this->anavul->guardar($fin);
        $rh2 = $this->anavulg->guardar($fin2);

        if($rh->response || $rh2->response){
            $rh->message = 'Se guardo exitosamente!';
        } else {
            $rh->message = 'Hubo un error al guardar, porfavor contacte al administrador.';
        }

        if($rh->response){
            print_r(json_encode($rh));
        }
    }

    public function postganavul4() {

        $fin = new Analisis();
        $fin2 = new AnalisisG();

        $fin->id = $_POST['id'];
        $fin->a1 = $_POST['a1'];
        $fin->a2 = $_POST['a2'];
        $fin->a3 = $_POST['a3'];
        $fin->a4 = $_POST['a4'];

        $fin2->id = $_POST['id2'];
        $fin2->a1 = $_POST['a1g'];
        $fin2->a2 = $_POST['a2g'];
        $fin2->a3 = $_POST['a3g'];
        $fin2->a4 = $_POST['a4g'];


        $rh = $this->anavul->guardar($fin);
        $rh2 = $this->anavulg->guardar($fin2);

        if($rh->response || $rh2->response){
            $rh->message = 'Se guardo exitosamente!';
        } else {
            $rh->message = 'Hubo un error al guardar, porfavor contacte al administrador.';
        }

        if($rh->response){
            print_r(json_encode($rh));
        }
    }

    public function postganavul5() {

        $fin = new Analisis();
        $fin2 = new AnalisisG();

        $fin->id = $_POST['id'];
        $fin->ad1 = $_POST['ad1'];
        $fin->ad2 = $_POST['ad2'];
        $fin->ad3 = $_POST['ad3'];
        $fin->ad4 = $_POST['ad4'];
        $fin->ad5 = $_POST['ad5'];
        $fin->ad6 = $_POST['ad6'];

        $fin2->id = $_POST['id2'];
        $fin2->ad1 = $_POST['ad1g'];
        $fin2->ad2 = $_POST['ad2g'];
        $fin2->ad3 = $_POST['ad3g'];
        $fin2->ad4 = $_POST['ad4g'];
        $fin2->ad5 = $_POST['ad5g'];
        $fin2->ad6 = $_POST['ad6g'];


        $rh = $this->anavul->guardar($fin);
        $rh2 = $this->anavulg->guardar($fin2);

        if($rh->response || $rh2->response){
            $rh->message = 'Se guardo exitosamente!';
        } else {
            $rh->message = 'Hubo un error al guardar, porfavor contacte al administrador.';
        }

        if($rh->response){
            print_r(json_encode($rh));
        }
    }

    public function postganavul6() {

        $fin = new Analisis();
        $fin2 = new AnalisisG();

        $fin->id = $_POST['id'];
        $fin->r1 = $_POST['r1'];
        $fin->r2 = $_POST['r2'];
        $fin->r3 = $_POST['r3'];
        $fin->r4 = $_POST['r4'];
        $fin->r5 = $_POST['r5'];
        $fin->r6 = $_POST['r6'];
        $fin->r7 = $_POST['r7'];
        $fin->r8 = $_POST['r8'];
        $fin->r9 = $_POST['r9'];

        $fin2->id = $_POST['id2'];
        $fin2->r1 = $_POST['r1g'];
        $fin2->r2 = $_POST['r2g'];
        $fin2->r3 = $_POST['r3g'];
        $fin2->r4 = $_POST['r4g'];
        $fin2->r5 = $_POST['r5g'];
        $fin2->r6 = $_POST['r6g'];
        $fin2->r7 = $_POST['r7g'];
        $fin2->r8 = $_POST['r8g'];
        $fin2->r9 = $_POST['r9g'];

        $rh = $this->anavul->guardar($fin);
        $rh2 = $this->anavulg->guardar($fin2);

        if($rh->response || $rh2->response){
            $rh->message = 'Se guardo exitosamente!';
        } else {
            $rh->message = 'Hubo un error al guardar, porfavor contacte al administrador.';
        }

        if($rh->response){
            print_r(json_encode($rh));
        }
    }

    public function postganavul7() {

        $fin = new Analisis();
        $fin2 = new AnalisisG();

        $fin->id = $_POST['id'];
        $fin->t1 = $_POST['t1'];
        $fin->t2 = $_POST['t2'];
        $fin->t3 = $_POST['t3'];
        $fin->t4 = $_POST['t4'];
        $fin->t5 = $_POST['t5'];
        $fin->t6 = $_POST['t6'];
        $fin->t7 = $_POST['t7'];
        $fin->t8 = $_POST['t8'];

        $fin2->id = $_POST['id2'];
        $fin2->t1 = $_POST['t1g'];
        $fin2->t2 = $_POST['t2g'];
        $fin2->t3 = $_POST['t3g'];
        $fin2->t4 = $_POST['t4g'];
        $fin2->t5 = $_POST['t5g'];
        $fin2->t6 = $_POST['t6g'];
        $fin2->t7 = $_POST['t7g'];
        $fin2->t8 = $_POST['t8g'];

        $rh = $this->anavul->guardar($fin);
        $rh2 = $this->anavulg->guardar($fin2);

        if($rh->response || $rh2->response){
            $rh->message = 'Se guardo exitosamente!';
        } else {
            $rh->message = 'Hubo un error al guardar, porfavor contacte al administrador.';
        }

        if($rh->response){
            print_r(json_encode($rh));
        }
    }

    public function postganavul8() {

        $fin = new Analisis();
        $fin2 = new AnalisisG();

        $fin->id = $_POST['id'];
        $fin->l1 = $_POST['l1'];
        $fin->l2 = $_POST['l2'];
        $fin->l3 = $_POST['l3'];
        $fin->l4 = $_POST['l4'];
        $fin->l5 = $_POST['l5'];
        $fin->l6 = $_POST['l6'];
        $fin->l7 = $_POST['l7'];

        $fin2->id = $_POST['id2'];
        $fin2->l1 = $_POST['l1g'];
        $fin2->l2 = $_POST['l2g'];
        $fin2->l3 = $_POST['l3g'];
        $fin2->l4 = $_POST['l4g'];
        $fin2->l5 = $_POST['l5g'];
        $fin2->l6 = $_POST['l6g'];
        $fin2->l7 = $_POST['l7g'];

        $rh = $this->anavul->guardar($fin);
        $rh2 = $this->anavulg->guardar($fin2);

        if($rh->response || $rh2->response){
            $rh->message = 'Se guardo exitosamente!';
        } else {
            $rh->message = 'Hubo un error al guardar, porfavor contacte al administrador.';
        }

        if($rh->response){
            print_r(json_encode($rh));
        }
    }

    public function getresana(){
        $usuario = Auth::getCurrentUser();

        return $this->render('Autodiagnosticos/analisis/resultado.twig', [
            'title' => 'Cuestionarios',
            'menu' => false,
            'company_name' => '4adwise',
            'dato' => $this->anavul->buscar($usuario->id),
            'dato2' => $this->anavulg->buscar($usuario->id)
        ]);
    }

    public function getresana2($id){
        $usuario = Auth::getCurrentUser();

        return $this->render('Autodiagnosticos/analisis/resultado.twig', [
            'title' => 'Cuestionarios',
            'menu' => false,
            'company_name' => '4adwise',
            'dato' => $this->anavul->buscar($id),
            'dato2' => $this->anavulg->buscar($id)
        ]);
    }

    /****************************/
    /* Fin Analisis 8 áreas especifico */

    /**************************************/
    /* Seguimiento distribuidores */
    public function getregprod($id){
        return $this->render( 'Autodiagnosticos/seguimiento/registro.twig',[
            'title' => 'Registro de información',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'distribuidor' => $this->distribuidor->obtener($id),
        ]);
    }
    public function getinidist(){
        return $this->render( 'Autodiagnosticos/seguimiento/inicio.twig',[
            'title' => 'Registro de información',
            'menu' => false,
            'company_name' => $this->config['company_name'],
        ]);
    }
    public function postbuscardist(){
        $rh = new ResponseHelper();

        $rh = $this->distribuidor->obtenerporemail($_POST['email']);
        if($rh->response) {
            $rh->message = 'Distribuidor localizado';
            $rh->href = 'home/regprod/'.$rh->result[0]->id;
        }
        print_r(
            json_encode($rh)
        );
    }

    public function postprodnec(){
        $model = new  ProductosNec();

        $model->id_dist = $_POST['id'];
        $model->v12e = $_POST['12'];
        $model->v34e = $_POST['34'];
        $model->v1e = $_POST['1'];
        $model->v2e = $_POST['2'];
        $model->v3e = $_POST['3'];
        $model->v4e = $_POST['4'];
        $model->flushe = $_POST['flush'];
        $model->bace = $_POST['bacteria'];
        $model->llue = $_POST['lluvia'];
        $model->v12n = $_POST['12n'];
        $model->v34n = $_POST['34n'];
        $model->v1n = $_POST['1n'];
        $model->v2n = $_POST['2n'];
        $model->v3n = $_POST['3n'];
        $model->v4n = $_POST['4n'];
        $model->flushn = $_POST['flushn'];
        $model->bacn = $_POST['bacterian'];
        $model->llun = $_POST['lluvian'];

        $rh = $this->prodnec->guardar($model);

        if ($rh->response){
            $rh->message = 'Se guardo exitosamente!';
            print_r(
                json_encode($rh)
            );
        }

    }
    public function postpros(){
        $arr = [];


        for ($i = 1; $i <= 5; $i++)
        {
            if (isset($_POST["p{$i}"]))
            {
                $arr[$i]["id_dist"] = $_POST["id"];
                $arr[$i]["prospecto"] = $_POST["p{$i}"];
                $arr[$i]["celular"] = $_POST["cel{$i}"];
                $arr[$i]["email"] = $_POST["email{$i}"];
                $arr[$i]["created_at"] = date("Y-m-d");
                $arr[$i]["updated_at"] = date("Y-m-d");
            }
        }
        $rh = $this->prospectos->guardar2($arr);
        if ($rh->response){
            $rh->message = 'Se guardo exitosamente!';
            print_r(
                json_encode($rh)
            );
        }

    }
    public function postopor(){
        $arr = [];

        for ($i = 1; $i <= 3; $i++) {
            $arr[$i]["id_dist"] = $_POST["id"];
            $arr[$i]["lh"] = $_POST["loh{$i}"];
            $arr[$i]["created_at"] = date("Y-m-d");
            $arr[$i]["updated_at"] = date("Y-m-d");
        }

        $rh = $this->oportunidades->guardar2($arr);

        if ($rh->response){
            $rh->message = 'Se guardo exitosamente!';
            print_r(
                json_encode($rh)
            );
        }
    }
    public function getlistdist(){
        return $this->render( 'Autodiagnosticos/seguimiento/listado.twig',[
            'title' => 'Listado',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'distribuidores' => $this->distribuidor->listar()
        ]);
    }
    public function getsitdist($id){
        return $this->render( 'Autodiagnosticos/seguimiento/distribuidor.twig',[
            'title' => 'Situación del distribuidor',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'prodnec' => $this->prodnec->listarmrenciente($id),
            'prospectos' => $this->prospectos->listarpordist($id),
            'logros' => $this->oportunidades->listarpordist($id)
        ]);
    }
    public function getveremp($id) {
        return $this->render( 'Autodiagnosticos/verinfo.twig',[
            'title' => 'Situación del distribuidor',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'datos' => $this->empRepo->obtener($id),
        ]);
    }

    public function get5areas() {
        $usuario = Auth::getCurrentUser();
        $check = $this->registrog->buscar($usuario->id);
        if (count($check) == 0){
            $model = new Registrog();
            $model->id_emp = $usuario->id;
            $this->registrog->guardar($model);
        }

        return $this->render( '5areas/cuestionario.twig',[
            'title' => 'Cuestionario',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'cuestionario' => $this->registrog->buscar($usuario->id)
        ]);
    }

    public function get5areasadmin($id) {
        return $this->render( '5areas/cuestionario.twig',[
            'title' => 'Cuestionario',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'cuestionario' => $this->registrog->buscar($id)
        ]);
    }

    public function postreg5areas1(){
        $model = new Registrog();

        $usuario = Auth::getCurrentUser();

        $model->id = $_POST['id'];
        $model->so1 = $_POST['os1'];
        $model->so2 = $_POST['os2'];
        $model->so3 = $_POST['os3'];
        $model->so4 = $_POST['os4'];


        $rh = $this->registrog->guardar($model);

        if ($rh->response){
            $rh->message = "Guardado Exitosamente!";
            print_r(json_encode($rh));
        }
    }
    public function postreg5areas2(){
        $model = new Registrog();

        $usuario = Auth::getCurrentUser();

        $model->id = $_POST['id'];
        $model->adm1 = $_POST['adm1'];
        $model->adm2 = $_POST['adm2'];
        $model->adm3 = $_POST['adm3'];
        $model->adm4 = $_POST['adm4'];

        $rh = $this->registrog->guardar($model);

        if ($rh->response){
            $rh->message = "Guardado Exitosamente!";
            print_r(json_encode($rh));
        }
    }
    public function postreg5areas3(){
        $model = new Registrog();

        $usuario = Auth::getCurrentUser();

        $model->id = $_POST['id'];
        $model->cm1 = $_POST['cm1'];
        $model->cm2 = $_POST['cm2'];
        $model->cm3 = $_POST['cm3'];
        $model->cm4 = $_POST['cm4'];

        $rh = $this->registrog->guardar($model);

        if ($rh->response){
            $rh->message = "Guardado Exitosamente!";
            print_r(json_encode($rh));
        }
    }
    public function postreg5areas4(){
        $model = new Registrog();

        $usuario = Auth::getCurrentUser();

        $model->id = $_POST['id'];
        $model->dd1 = $_POST['dd1'];
        $model->dd2 = $_POST['dd2'];
        $model->dd3 = $_POST['dd3'];
        $model->dd4 = $_POST['dd4'];

        $rh = $this->registrog->guardar($model);

        if ($rh->response){
            $rh->message = "Guardado Exitosamente!";
            print_r(json_encode($rh));
        }
    }
    public function postreg5areas5(){
        $model = new Registrog();

        $usuario = Auth::getCurrentUser();

        $model->id = $_POST['id'];
        $model->fe1 = $_POST['fe1'];
        $model->fe2 = $_POST['fe2'];
        $model->fe3 = $_POST['fe3'];
        $model->fe4 = $_POST['fe4'];

        $rh = $this->registrog->guardar($model);

        if ($rh->response){
            $rh->message = "Guardado Exitosamente!";
            print_r(json_encode($rh));
        }
    }

    public function getresg(){
        $usuario = Auth::getCurrentUser();
        return $this->render( '5areas/resultados.twig',[
            'title' => 'Cuestionario',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'datos' => $this->registrog->buscar($usuario->id),
            'rol' => $usuario->rol_id
        ]);
    }
    public function getresg2($id){
        $usuario = Auth::getCurrentUser();
        return $this->render( '5areas/resultados.twig',[
            'title' => 'Cuestionario',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'datos' => $this->registrog->buscar($id),
            'rol' => $usuario->rol_id
        ]);
    }

    public function getlistusua(){
        return $this->render( 'Autodiagnosticos/listado.twig',[
            'title' => 'Listado de usuarios',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'datos' => $this->usuarios->listararray()
        ]);
    }
}
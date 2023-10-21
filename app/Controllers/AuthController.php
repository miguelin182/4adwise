<?php
namespace App\Controllers;

use App\Models\Registrog;
use App\Models\Usuario;
use App\Validations\UsuarioValidation;
use Core\{Auth, Controller};
use App\Helpers\{MailHelper, ResponseHelper, UrlHelper};
use App\Repositories\{EstadoRepository, MunicipioRepository, RegistrogRepository, UsuarioRepository};
use Core\ServicesContainer;

class AuthController extends Controller {
    private $usuarioRepo;
    private $config;
    private $estados;
    private $munRepo;
    private $registrog;

    public function __construct() {
        if(Auth::isLoggedIn()) {
            UrlHelper::redirect();
        }

        parent::__construct();
        $this->usuarioRepo = new UsuarioRepository();
        $this->config=ServicesContainer::getConfig();
        $this->estados = new EstadoRepository();
        $this->munRepo = new MunicipioRepository();
        $this->registrog = new RegistrogRepository();
    }

    public function getIndex() {
        return $this->render('auth/index.twig', [
            'title' => 'Autenticación',
            'company_name'=>$this->config['company_name'],
            'menu'  => false
        ]);
    }


    public function postguard1()
    {
        $rh = new ResponseHelper();
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            if ($_POST['empresa'] == null || $_POST['empresa'] == '' || empty($_POST['empresa'])) {
                $rh->message = "Por favor ingrese la razon social de la empresa.";
                $rh->response = false;
                print_r(
                    json_encode($rh)
                );
            } else {
                $model = new Usuario();
                $model2 = new Registrog();

                $model->empresa = $_POST['empresa'];
                $model->email = $_POST['email'];
                $model->celular = $_POST['celular'];
                $model->rol_id = 2;

                $rbus = $this->usuarioRepo->buscar($_POST['email']);
                if (count($rbus) == 0) {
                    $registro = $this->usuarioRepo->guardar2($model);

                    $model2->id_emp = $registro->result;
                    $registro2 = $this->registrog->guardar($model2);

                    $rh->result = [$registro->result, $registro2->result];
                    $rh->response = true;
                    if ($rh->response) {
                        $rh->message = "guardado con exito!";
                    }
                    print_r(json_encode($rh));
                } else {
                    $rh = new ResponseHelper();
                    $rh->message = "El correo electronico que ingreso ya esta registrado.";
                    $rh->response = false;
                    print_r(
                        json_encode($rh)
                    );
                }
            }
        } else {
            $rh->message = "Por favor ingrese un correo electronico valido.";
            $rh->response = false;
            print_r(
                json_encode($rh)
            );
        }
    }


    public function getdiagnostico() {
        return $this->render('5areas/cuestionario2.twig', [
            'title' => 'Diagnostico Gratuito',
            'company_name'=>$this->config['company_name'],
            'menu'  => false
        ]);
    }

    public function postsignin() {
        $rh = $this->usuarioRepo->autenticar(
            $_POST['email'],
            $_POST['password']
        );

        if ($rh->response){
            $rh->href = "home";
        }

        print_r(json_encode($rh));
    }

    public function postiniciasesion($email,$password) {
        $rh = $this->usuarioRepo->autenticar(
            $email,
            $password
        );
        if($rh->response) {
            $rh->href = 'home';
        }
        return $rh;
    }

    public function getregister() {
        return $this->render('auth/registro.twig', [
            'title' => 'Registrate',
            'company_name'=>$this->config['company_name'],
            'menu'  => false,
            'estados' => $this->estados->listar()
        ]);
    }

    public function postmunirelest($id){
        print_r(json_encode($this->munRepo->listar($id)));
    }

    public function postregister2(){
        UsuarioValidation::validate($_POST);

        $usuario = new Usuario();
        $usuario->usuario = $_POST['usuario'];
        $usuario->email = $_POST['email'];
        $usuario->password = $_POST['password'];
        $usuario->direccion = $_POST['direccion'];
        /*$usuario->estado = $_POST['estado'];
        $usuario->municipio = $_POST['municipio'];*/
        $usuario->celular = $_POST['celular'];
        $usuario->empresa = $_POST['empresa'];
        /*$usuario->giro = $_POST['giro'];
        $usuario->ventas = $_POST['ventas'];
        $usuario->tamano = $_POST['tamano'];*/
        $usuario->rol_id = 2;
        if($_POST['rpassword'] == $_POST['password']){
            $rbus = $this->usuarioRepo->buscar($usuario->email);
            if (count($rbus) == 0){
                $rh = $this->usuarioRepo->guardar($usuario);
                $rh2= new ResponseHelper();
                if($rh->response){
                    $body=$this->render('auth/mailsuscriptor.twig',['title'=>'Registro Exitoso']);
                    MailHelper::senMail('4adwise - ¡Gracias por Registrarse!', $_POST['email'], $body);
                    $rh2 = $this->postiniciasesion($usuario->email,$usuario->password);
                }
                print_r(
                    json_encode($rh2)
                );
            } else {
                $rh = new ResponseHelper();
                $rh->message = "El correo electronico que ingreso ya esta registrado.";
                $rh->response = false;
                print_r(
                    json_encode($rh)
                );
            }
        } else {
            $rh = new ResponseHelper();
            $rh->message = "Las contraseñas no coinciden";
            $rh->response = false;
            print_r(
                json_encode($rh)
            );
        }
    }

    public function getsignout() {
        Auth::destroy();

        UrlHelper::redirect('');
    }
    public function postreg5areas1(){
        $model = new Registrog();
        $model2 = new Usuario();

        $model2->id = $_POST['idops2'];
        $model2->tamano = $_POST['tamano'];

        $model->id = $_POST['idops'];
        $model->so1 = $_POST['os1'];
        $model->so2 = $_POST['os2'];
        $model->so3 = $_POST['os3'];
        $model->so4 = $_POST['os4'];

        $rh2 = $this->usuarioRepo->guardar2($model2);
        $rh = $this->registrog->guardar($model);

        if ($rh->response && $rh2->response){
            $rh->message = "Guardado Exitosamente!";
            print_r(json_encode($rh));
        } else {
            $rh->message = "Error al guardar, intentelo de nuevo.";
            print_r(json_encode($rh));
        }
    }
    public function postreg5areas2()
    {
        $model = new Registrog();
        $model2 = new Usuario();

        $model2->ventas = $_POST['ventas'];
        $model2->id = $_POST['idrec2'];

        $model->id = $_POST['idrec'];
        $model->adm1 = $_POST['adm1'];
        $model->adm2 = $_POST['adm2'];
        $model->adm3 = $_POST['adm3'];
        $model->adm4 = $_POST['adm4'];

        $rh = $this->registrog->guardar($model);
        $rh2 = $this->usuarioRepo->guardar2($model2);

        if ($rh->response && $rh2->response){
            $rh->message = "Guardado Exitosamente!";
            print_r(json_encode($rh));
        }
    }
    public function postreg5areas3(){
        $model = new Registrog();
        $model2 = new Usuario();

        $model2->giro = $_POST['giro'];
        $model2->id = $_POST['idcm2'];

        $model->id = $_POST['idcm'];
        $model->cm1 = $_POST['cm1'];
        $model->cm2 = $_POST['cm2'];
        $model->cm3 = $_POST['cm3'];
        $model->cm4 = $_POST['cm4'];

        $rh = $this->registrog->guardar($model);
        $rh2 = $this->usuarioRepo->guardar2($model2);

        if ($rh->response && $rh2->response){
            $rh->message = "Guardado Exitosamente!";
            print_r(json_encode($rh));
        }
    }
    public function postreg5areas4(){
        $model = new Registrog();

        $model->id = $_POST['iddd'];
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

        $model->id = $_POST['idfe'];
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

    public function postres(){
        $rh = new ResponseHelper();
        $rh->response = true;
        $rh->message = "redireccionando...";
        $rh->href = 'auth/resultados/'.$_POST['id'];

        print_r(json_encode($rh));
    }

    public function getresultados($id){
        return $this->render( '5areas/resultados.twig',[
            'title' => 'Cuestionario',
            'menu' => false,
            'company_name' => $this->config['company_name'],
            'datos' => $this->registrog->buscar($id)
        ]);
    }
    public function getvistagratuito(){
        return $this->render( '5areas/cuestionariogratuitovista.twig',[
            'title' => 'Cuestionario vista',
            'menu' => false,
            'company_name' => $this->config['company_name']
        ]);
    }
    public function getcentro(){
        return $this->render( 'auth/centrodeayuda.twig',[
            'title' => 'Centro de ayuda',
            'menu' => false,
            'company_name' => $this->config['company_name']
        ]);
    }
}
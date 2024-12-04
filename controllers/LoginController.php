<?php
namespace Controllers;

use classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function index(Router $router) {
        $titulo = "Iniciar Sesión";
        $alertas = [];
        $router->render('/auth/login', [
            'titulo' => $titulo,
            'alertas' => $alertas
        ]);
    }

    public static function login(Router $router) {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            
            if(empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario) {
                    // Verificar el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redirección
                        if(isset($_GET['redirect'])) {
                            header('Location: ' . $_GET['redirect']);
                        } else {
                            // Si no hay redirección específica, usar la ruta por defecto
                            if($usuario->admin === "1") {
                                $_SESSION['admin'] = $usuario->admin ?? null;
                                header('Location: /admin');
                            } else {
                                header('Location: /cita');
                            }
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        
        $router->render('auth/login', [
            'alertas' => $alertas,
            'redirect' => $_GET['redirect'] ?? null
        ]);
    }

    public static function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header('Location: /');
        exit;
    }

    public static function olvide(Router $router) {
        
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

        if($usuario && $usuario->confirmado === "1") {
            //crear token
            $usuario->crearToken();
            $usuario->guardar();

            // Enviar email

            $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
            $email->enviarInstrucciones();

            //alerta de exito 
            Usuario::setAlerta('exito', 'Se ha enviado un correo con las instrucciones para recuperar tu contraseña');

            }else{
                Usuario::setAlerta('error', 'El usuario no existe o no está confirmado');
                
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
        
    }

    // public static function recuperar(Router $router) {
        
    //     $alertas = [];
    //     $error = false;

    //     $token = s($_GET['token']);

    //     $usuario = Usuario::where('token', $token);

    //     if(empty($usuario)) {
    //         Usuario::setAlerta('error', 'Token no válido');
    //         $error = true;
    //     }

    //     if($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $password = new Usuario($_POST);
    //         $alertas = $password->validarPassword();

    //         if(empty($alertas)){
    //             $usuario->password = null;
    //             $usuario->password = $password->password;
    //             $usuario->hashPassword();
    //             $usuario->token = null;

    //             $resultado = $usuario->guardar();
    //             if($resultado) {
    //                 header('Location: /login');
    //             }

    //         }
    //     }

    //     $alertas = Usuario::getAlertas();
    //     $router->render('auth/recuperar-password', [
    //         'alertas' => $alertas,
    //         'error' => $error
    //     ]);
    // }

    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false;
        $passwordActualizado = false; // Nueva variable
    
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
    
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }
    
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
    
            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
    
                $resultado = $usuario->guardar();
                if($resultado) {
                    $passwordActualizado = true; // Marcamos como actualizado
                    Usuario::setAlerta('exito', 'Contraseña actualizada correctamente');
                }
            }
        }
    
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error,
            'passwordActualizado' => $passwordActualizado // Pasamos la variable a la vista
        ]);
    }

    public static function crear(Router $router) {
        $titulo = "StyloReserva | Crear Cuenta";
        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                $existe = $usuario->existeUsuario();

                if ($existe->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashPassword();
                    $usuario->crearToken();

                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    if ($usuario->guardar()) {
                        header('Location: /mensaje');
                        exit;
                    }
                }
            }
        }

        $router->render('/auth/crear-cuenta', [
            'titulo' => $titulo,
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router) {
        $router->render('/auth/mensaje');
    }

    public static function confirmar(Router $router) {
        $alertas = [];
        $token = s($_GET['token'] ?? '');

        $usuario = Usuario::where('token', $token);

        if (!$usuario) {
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            $usuario->confirmarCuenta();
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}

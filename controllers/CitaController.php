<?php

namespace Controllers;

use MVC\Router;

class CitaController
{
    public static function index(Router $router)
    {
        isAuth();


        $router->render('cita/index',[
            'nombre' => $_SESSION['nombre']
        ]);
    }

    public static function comprobante(Router $router)
    {
        isAuth();

        // Obtener los datos del comprobante de la sesión
        $comprobante = $_SESSION['comprobante'] ?? null;

        if (!$comprobante) {
            header('Location: /cita');
            return;
        }

        $router->render('cita/comprobante', [
            'comprobante' => $comprobante
        ]);

        // Limpiar la sesión después de mostrar el comprobante
        unset($_SESSION['comprobante']);
    }
}
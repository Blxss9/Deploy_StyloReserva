<?php

namespace Controllers;

use MVC\Router;

class LandingController {
    public static function index(Router $router) {
        $titulo = "Elite Barbershop | Bienvenido"; // Título específico para la landing page
        $esLandingPage = true; // Variable que identifica si el usuario está en la landing page o no.
        
        // Pasa ambas variables al render
        $router->render('landing', [
            'titulo' => $titulo,
            'esLandingPage' => $esLandingPage
        ]);
    }
}
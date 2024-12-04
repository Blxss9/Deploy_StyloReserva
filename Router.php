<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        session_start();
        
        // $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        // Verificar si es una ruta de API
        $esRutaApi = strpos($currentUrl, '/api/') === 0;
        
        if ($esRutaApi) {
            header('Content-Type: application/json');
        }

        // Extraer parámetros de URL para rutas dinámicas
        if (strpos($currentUrl, '/api/orders/capture/') === 0) {
            $currentUrl = '/api/orders/capture/:id';
        }

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }

        if ($fn) {
            try {
                call_user_func($fn, $this);
            } catch (\Exception $e) {
                if ($esRutaApi) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ]);
                } else {
                    // Manejo de errores para vistas normales
                    $this->render('error', [
                        'titulo' => 'Error',
                        'mensaje' => $e->getMessage()
                    ]);
                }
            }
        } else {
            if ($esRutaApi) {
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Ruta no encontrada'
                ]);
            } else {
                $this->render('error404', [
                    'titulo' => 'Página No Encontrada',
                    'esError404' => true
                ]);
            }
        }
    }

    public function render($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer
        include_once __DIR__ . '/views/layout.php';
    }
}

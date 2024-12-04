<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;
use Model\Usuario;
use Model\ActiveRecord;
use Model\Testimonio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar() {
        $datos = json_decode(file_get_contents('php://input'), true);
        
        // Almacena la Cita y devuelve el ID
        $cita = new Cita([
            'fecha' => $datos['fecha'],
            'hora' => $datos['hora'],
            'usuarioId' => $datos['id'],
            'pago' => $datos['pago'] ?? 'PENDING',
            'estado' => ($datos['pago'] === 'COMPLETED') ? 'confirmada' : 'pendiente'
        ]);
        
        $resultado = $cita->guardar();

        if ($resultado['resultado']) {
            $idCita = $resultado['id'];
            
            // Almacena los Servicios con el ID de la Cita
            $idServicios = explode(",", $datos['servicios']);
            foreach($idServicios as $idServicio) {
                $args = [
                    'citaId' => $idCita,
                    'servicioId' => $idServicio
                ];
                $citaServicio = new CitaServicio($args);
                $citaServicio->guardar();
            }
            
            echo json_encode([
                'resultado' => true,
                'mensaje' => 'Cita agendada correctamente'
            ]);
        } else {
            echo json_encode([
                'resultado' => false,
                'mensaje' => 'Error al agendar la cita'
            ]);
        }
    }

    public static function eliminar() {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public static function createOrder() {
        header('Content-Type: application/json');
        
        try {
            $datos = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($datos['servicios']) || empty($datos['servicios'])) {
                throw new Exception('No hay servicios seleccionados');
            }

            // Guardar en sesión para usar después
            $_SESSION['paypal_order'] = [
                'servicios' => $datos['servicios'],
                'fecha' => $datos['fecha'] ?? date('Y-m-d'),
                'hora' => $datos['hora'] ?? '00:00',
                'usuarioId' => $datos['usuarioId'] ?? $_SESSION['id']
            ];

            // Calcular el total
            $total = array_reduce($datos['servicios'], function($carry, $servicio) {
                return $carry + floatval($servicio['precio']);
            }, 0);

            $accessToken = getPayPalAccessToken();
            
            $order = [
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($total, 2, '.', '')
                    ]
                ]]
            ];

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => PAYPAL_API_URL . '/v2/checkout/orders',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $accessToken,
                    'PayPal-Request-Id: ' . uniqid()
                ],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($order),
                CURLOPT_SSL_VERIFYPEER => false // Solo para desarrollo
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            if (curl_errno($ch)) {
                throw new Exception(curl_error($ch));
            }
            
            curl_close($ch);

            if ($httpCode === 201) {
                $orderData = json_decode($response, true);
                echo json_encode(['id' => $orderData['id']]);
            } else {
                throw new Exception('Error al crear la orden en PayPal');
            }
        } catch (Exception $e) {
            error_log('Error en createOrder: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public static function captureOrder() {
        header('Content-Type: application/json');
        
        try {
            // Log para debugging
            error_log("Iniciando captureOrder");
            
            if (!isset($_SESSION['id'])) {
                throw new \Exception('Usuario no autenticado');
            }

            // Obtener y validar OrderID
            $uri = $_SERVER['REQUEST_URI'];
            error_log("URI recibida: " . $uri);
            
            // Extraer ID de la orden
            preg_match('/\/api\/orders\/capture\/([A-Z0-9]+)$/', $uri, $matches);
            $orderId = $matches[1] ?? null;
            error_log("OrderID extraído: " . ($orderId ?? 'null'));

            if (!$orderId) {
                throw new \Exception('ID de orden no proporcionado');
            }

            // Obtener token de PayPal
            $accessToken = getPayPalAccessToken();
            if (empty($accessToken)) {
                throw new \Exception('No se pudo obtener el token de PayPal');
            }

            // Capturar el pago
            $ch = curl_init();
            $captureUrl = PAYPAL_API_URL . "/v2/checkout/orders/$orderId/capture";
            error_log("URL de captura: " . $captureUrl);
            
            curl_setopt_array($ch, [
                CURLOPT_URL => $captureUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $accessToken,
                    'Prefer: return=representation'
                ],
                CURLOPT_POST => true,
                CURLOPT_SSL_VERIFYPEER => false // Solo para desarrollo
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            error_log("Respuesta PayPal - HTTP Code: " . $httpCode);
            error_log("Respuesta PayPal: " . $response);
            
            if (curl_errno($ch)) {
                throw new \Exception('Error cURL: ' . curl_error($ch));
            }
            
            curl_close($ch);

            if ($httpCode === 201 || $httpCode === 200) {
                $paypalData = json_decode($response, true);
                
                // Crear la cita
                $cita = new Cita([
                    'fecha' => $_SESSION['paypal_order']['fecha'] ?? date('Y-m-d'),
                    'hora' => $_SESSION['paypal_order']['hora'] ?? '00:00',
                    'usuarioId' => $_SESSION['id'],
                    'pago' => 'COMPLETED',
                    'estado' => 'confirmada'
                ]);
                
                $resultado = $cita->guardar();
                
                if ($resultado['resultado']) {
                    $servicios = [];
                    $total = 0;
                    
                    // Guardar servicios
                    if (isset($_SESSION['paypal_order']['servicios'])) {
                        foreach ($_SESSION['paypal_order']['servicios'] as $servicio) {
                            $citaServicio = new CitaServicio([
                                'citaId' => $resultado['id'],
                                'servicioId' => $servicio['id']
                            ]);
                            $citaServicio->guardar();
                            
                            // Agregar al array de servicios para el comprobante
                            $servicios[] = [
                                'nombre' => $servicio['nombre_servicio'],
                                'precio' => number_format($servicio['precio'], 0, ',', '.')
                            ];
                            $total += floatval($servicio['precio']);
                        }
                    }
                    
                    // Preparar datos del comprobante
                    $comprobante = [
                        'ordenId' => $paypalData['id'],
                        'fecha' => date('d/m/Y', strtotime($cita->fecha)),
                        'hora' => $cita->hora,
                        'total' => '$' . number_format($total, 0, ',', '.'),
                        'servicios' => $servicios
                    ];
                    
                    // Guardar el comprobante en la sesión
                    $_SESSION['comprobante'] = $comprobante;
                    
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Pago procesado correctamente',
                        'comprobanteUrl' => '/comprobante'
                    ]);
                    return;
                }
                
                throw new \Exception('Error al guardar la cita');
            } else {
                throw new \Exception('Error en la respuesta de PayPal: ' . $response);
            }
        } catch (\Exception $e) {
            error_log('Error en captureOrder: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public static function crearServicio() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $servicio = new Servicio($_POST);
                
                // Validar
                $alertas = $servicio->validar();
                
                if(empty($alertas)) {
                    $resultado = $servicio->guardar();
                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Servicio creado correctamente',
                        'id' => $resultado['id']
                    ]);
                } else {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => $alertas['error'][0] // Enviamos el primer error
                    ]);
                }
            } catch (\Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al crear el servicio'
                ]);
            }
        }
    }

    public static function actualizarServicio() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $servicio = Servicio::find($_POST['id']);
                $servicio->sincronizar($_POST);
                
                // Validar
                $alertas = $servicio->validar();
                
                if(empty($alertas)) {
                    $resultado = $servicio->guardar();
                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Servicio actualizado correctamente'
                    ]);
                } else {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => $alertas['error'][0] // Enviamos el primer error
                    ]);
                }
            } catch (\Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al actualizar el servicio'
                ]);
            }
        }
    }

    public static function eliminarServicio() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $servicio = Servicio::find($_POST['id']);
                $resultado = $servicio->eliminar();

                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Servicio eliminado correctamente'
                ]);
            } catch (\Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al eliminar el servicio'
                ]);
            }
        }
    }

    public static function obtenerUsuario() {
        if(!isset($_SESSION['admin'])) {
            header('Location: /');
            return;
        }

        $id = $_GET['id'] ?? '';
        if(!$id) {
            echo json_encode(['error' => 'ID no proporcionado']);
            return;
        }

        $usuario = Usuario::find($id);
        
        if($usuario) {
            // Asegurarse de que las fechas estén en formato correcto
            $usuario->fecha_creacion = date('Y-m-d', strtotime($usuario->fecha_creacion));
            $usuario->ultima_actualizacion = date('Y-m-d', strtotime($usuario->ultima_actualizacion));
            
            echo json_encode($usuario);
        } else {
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    }

    public static function actualizarUsuario() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            isAdmin();

            try {
                // Obtener y validar el usuario
                $usuario = Usuario::find($_POST['id']);
                if(!$usuario) {
                    echo json_encode(['tipo' => 'error', 'mensaje' => 'Usuario no encontrado']);
                    return;
                }

                // Verificar que no sea admin
                if($usuario->admin) {
                    echo json_encode(['tipo' => 'error', 'mensaje' => 'No se puede editar un usuario administrador']);
                    return;
                }

                // Actualizar campos incluyendo el estado de confirmación
                $usuario->sincronizar([
                    'nombre' => $_POST['nombre'],
                    'apellido' => $_POST['apellido'],
                    'email' => $_POST['email'],
                    'telefono' => $_POST['telefono'],
                    'confirmado' => $_POST['confirmado']
                ]);

                // Validar
                $alertas = $usuario->validarEdicion();
                
                if(empty($alertas)) {
                    // Si se está confirmando la cuenta, eliminar el token
                    if($_POST['confirmado'] === "1") {
                        $usuario->token = null;
                    }
                    
                    $resultado = $usuario->guardar();
                    
                    if($resultado) {
                        echo json_encode([
                            'tipo' => 'exito',
                            'mensaje' => 'Usuario actualizado correctamente'
                        ]);
                    } else {
                        echo json_encode([
                            'tipo' => 'error',
                            'mensaje' => 'Error al actualizar el usuario'
                        ]);
                    }
                } else {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => $alertas['error'][0]
                    ]);
                }
            } catch (\Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al actualizar el usuario: ' . $e->getMessage()
                ]);
            }
        }
    }

    public static function eliminarUsuario() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            isAdmin();
            
            $id = $_POST['id'] ?? '';
            
            if(!$id) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'ID de usuario no válido']);
                return;
            }

            // Obtener el usuario
            $usuario = Usuario::find($id);
            
            if(!$usuario) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'Usuario no encontrado']);
                return;
            }

            // Verificar que no sea admin
            if($usuario->admin) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'No se puede eliminar un usuario administrador']);
                return;
            }

            try {
                // Eliminar las citas asociadas usando el modelo Cita
                $citas = Cita::whereAll('usuarioId', $id);
                if($citas) {
                    foreach($citas as $cita) {
                        // Eliminar los servicios asociados a la cita
                        $citaServicios = CitaServicio::whereAll('citaId', $cita->id);
                        if($citaServicios) {
                            foreach($citaServicios as $citaServicio) {
                                $citaServicio->eliminar();
                            }
                        }
                        // Eliminar la cita
                        $cita->eliminar();
                    }
                }

                // Eliminar el usuario
                $resultado = $usuario->eliminar();

                if($resultado) {
                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Usuario eliminado correctamente'
                    ]);
                } else {
                    throw new \Exception('Error al eliminar el usuario');
                }
            } catch(\Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Error al eliminar el usuario: ' . $e->getMessage()
                ]);
            }
        }
    }

    public static function verificarDisponibilidad() {
        header('Content-Type: application/json');
        
        try {
            $fecha = $_GET['fecha'] ?? '';
            $hora = $_GET['hora'] ?? '';
            
            error_log("Verificando disponibilidad para fecha: $fecha, hora: $hora");
            
            if(empty($fecha) || empty($hora)) {
                throw new \Exception('Fecha y hora son requeridas');
            }
            
            $disponible = Cita::verificarDisponibilidad($fecha, $hora);
            
            echo json_encode([
                'disponible' => $disponible,
                'mensaje' => $disponible ? 'Horario disponible' : 'Este horario ya está reservado'
            ]);
            
        } catch (\Exception $e) {
            error_log("Error en verificarDisponibilidad: " . $e->getMessage());
            echo json_encode([
                'disponible' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    public static function guardarTestimonio() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = json_decode(file_get_contents('php://input'), true);
            
            try {
                // Verificar que el usuario esté autenticado
                if(!isset($_SESSION['id'])) {
                    throw new \Exception('Usuario no autenticado');
                }

                $testimonio = new Testimonio([
                    'usuario_id' => $_SESSION['id'],
                    'contenido' => $datos['contenido'],
                    'calificacion' => $datos['calificacion']
                ]);

                // Validar
                $alertas = $testimonio->validar();
                
                if(empty($alertas)) {
                    $resultado = $testimonio->guardar();
                    echo json_encode([
                        'tipo' => 'exito',
                        'mensaje' => 'Testimonio guardado correctamente'
                    ]);
                } else {
                    echo json_encode([
                        'tipo' => 'error',
                        'mensaje' => $alertas['error'][0]
                    ]);
                }
            } catch (\Exception $e) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => $e->getMessage()
                ]);
            }
        }
    }

    public static function obtenerTestimonios() {
        try {
            $testimonios = Testimonio::SQL("
                SELECT t.*, u.nombre, u.apellido 
                FROM testimonios t 
                INNER JOIN usuarios u ON t.usuario_id = u.id 
                ORDER BY t.fecha_creacion DESC 
                LIMIT 10
            ");
            
            echo json_encode($testimonios);
        } catch (\Exception $e) {
            echo json_encode([
                'error' => $e->getMessage()
            ]);
        }
    }
}
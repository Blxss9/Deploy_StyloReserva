<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;
use Model\Servicio;
use Model\Usuario;

class AdminController {
    public static function index(Router $router) {
        isAdmin();

        $fecha = $_GET['fecha'] ?? '';
        $consulta = $_GET['buscar'] ?? '';

        // Obtener todas las citas para estadísticas generales
        $todasLasCitas = AdminCita::all();
        
        // Filtrar citas según los parámetros
        if($fecha && $consulta) {
            $citas = AdminCita::buscarPorFechaYCliente($fecha, $consulta);
        } elseif($fecha) {
            $citas = AdminCita::citasPorFecha($fecha);
        } elseif($consulta) {
            $citas = AdminCita::buscarPorCliente($consulta);
        } else {
            // Si no hay filtros, mostrar todas las citas ordenadas por fecha y hora
            $citas = AdminCita::all(); // Asumiendo que el método all() incluye el ORDER BY
        }

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'todasLasCitas' => $todasLasCitas,
            'fecha' => $fecha,
            'busqueda' => $consulta,
            'servicios' => Servicio::all(),
            'usuarios' => Usuario::all()
        ]);
    }

    public static function actualizarEstado() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            isAdmin();

            $id = $_POST['id'];
            $estado = $_POST['estado'];

            // Validar estados permitidos
            $estadosPermitidos = ['pendiente', 'confirmada', 'completada', 'cancelada'];
            
            if(!$id || !$estado || !in_array($estado, $estadosPermitidos)) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'Datos inválidos']);
                return;
            }

            // Obtener la cita
            $cita = AdminCita::find($id);
            if(!$cita) {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'Cita no encontrada']);
                return;
            }

            // Actualizar el estado
            $cita->estado = $estado;
            $resultado = $cita->guardar();

            if($resultado) {
                echo json_encode(['tipo' => 'exito', 'mensaje' => 'Estado actualizado correctamente']);
            } else {
                echo json_encode(['tipo' => 'error', 'mensaje' => 'Error al actualizar el estado']);
            }
        }
    }
}

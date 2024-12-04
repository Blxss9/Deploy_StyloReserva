<?php

namespace Model;

class AdminCita extends ActiveRecord {
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuarioId', 'created_at', 'pago', 'estado'];

    public $id;
    public $fecha;
    public $hora;
    public $usuarioId;
    public $created_at;
    public $pago;
    public $estado;
    public $cliente;
    public $email;
    public $telefono;
    public $servicios;
    public $total;

    public static $ultimaConsulta;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->created_at = $args['created_at'] ?? '';
        $this->pago = $args['pago'] ?? '';
        $this->estado = $args['estado'] ?? '';
        
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->servicios = $args['servicios'] ?? '';
        $this->total = $args['total'] ?? 0;
    }

    public static function citasPorFecha($fecha) {
        self::$ultimaConsulta = "SELECT 
            c.id, 
            c.hora, 
            c.fecha, 
            CASE 
                WHEN c.pago = 'PENDING' THEN 'pendiente'
                WHEN c.pago = 'COMPLETED' THEN 'completado'
                ELSE c.pago 
            END as pago,
            c.estado,
            CONCAT(u.nombre, ' ', u.apellido) as cliente,
            u.email,
            u.telefono,
            GROUP_CONCAT(DISTINCT s.nombre_servicio SEPARATOR ', ') as servicios,
            SUM(s.precio) as total
        FROM citas c
        INNER JOIN usuarios u ON u.id = c.usuarioId
        LEFT JOIN citasServicios cs ON cs.citaId = c.id
        LEFT JOIN servicios s ON s.id = cs.servicioId
        WHERE c.fecha = '$fecha'
        GROUP BY 
            c.id, 
            c.hora, 
            c.fecha, 
            c.estado, 
            c.pago,
            cliente,
            u.email,
            u.telefono
        ORDER BY c.hora";

        return self::consultarSQL(self::$ultimaConsulta);
    }

    public static function buscarPorCliente($busqueda) {
        $query = "SELECT 
            c.id, 
            c.hora, 
            c.fecha, 
            c.estado, 
            c.pago,
            CONCAT(u.nombre, ' ', u.apellido) as cliente,
            u.email,
            u.telefono,
            GROUP_CONCAT(s.nombre_servicio SEPARATOR ', ') as servicios,
            SUM(s.precio) as total
        FROM citas c
        INNER JOIN usuarios u ON u.id = c.usuarioId
        LEFT JOIN citasServicios cs ON cs.citaId = c.id
        LEFT JOIN servicios s ON s.id = cs.servicioId
        WHERE CONCAT(u.nombre, ' ', u.apellido) LIKE '%$busqueda%'
            OR u.email LIKE '%$busqueda%'
            OR u.telefono LIKE '%$busqueda%'
        GROUP BY 
            c.id, 
            c.hora, 
            c.fecha, 
            c.estado, 
            c.pago,
            cliente,
            u.email,
            u.telefono
        ORDER BY c.fecha, c.hora";

        return self::consultarSQL($query);
    }

    public static function actualizarEstado($id, $estado) {
        $query = "UPDATE citas SET estado = ? WHERE id = ? LIMIT 1";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param("si", $estado, $id);
        return $stmt->execute();
    }

    public static function buscarPorFechaYCliente($fecha, $busqueda) {
        $query = "SELECT 
            c.id, 
            c.hora, 
            c.fecha, 
            c.estado, 
            c.pago,
            CONCAT(u.nombre, ' ', u.apellido) as cliente,
            u.email,
            u.telefono,
            GROUP_CONCAT(s.nombre_servicio SEPARATOR ', ') as servicios,
            SUM(s.precio) as total
        FROM citas c
        INNER JOIN usuarios u ON u.id = c.usuarioId
        LEFT JOIN citasServicios cs ON cs.citaId = c.id
        LEFT JOIN servicios s ON s.id = cs.servicioId
        WHERE c.fecha = '$fecha'
            AND (CONCAT(u.nombre, ' ', u.apellido) LIKE '%$busqueda%'
            OR u.email LIKE '%$busqueda%'
            OR u.telefono LIKE '%$busqueda%')
        GROUP BY 
            c.id, 
            c.hora, 
            c.fecha, 
            c.estado, 
            c.pago,
            cliente,
            u.email,
            u.telefono
        ORDER BY c.hora";

        return self::consultarSQL($query);
    }

    public static function all() {
        $query = "SELECT 
            c.id, 
            c.hora, 
            c.fecha, 
            CASE 
                WHEN c.pago = 'PENDING' THEN 'pendiente'
                WHEN c.pago = 'COMPLETED' THEN 'completado'
                ELSE c.pago 
            END as pago,
            c.estado,
            CONCAT(u.nombre, ' ', u.apellido) as cliente,
            u.email,
            u.telefono,
            GROUP_CONCAT(DISTINCT s.nombre_servicio SEPARATOR ', ') as servicios,
            SUM(s.precio) as total
        FROM citas c
        INNER JOIN usuarios u ON u.id = c.usuarioId
        LEFT JOIN citasServicios cs ON cs.citaId = c.id
        LEFT JOIN servicios s ON s.id = cs.servicioId
        GROUP BY 
            c.id, 
            c.hora, 
            c.fecha, 
            c.estado, 
            c.pago,
            cliente,
            u.email,
            u.telefono
        ORDER BY c.fecha, c.hora";

        return self::consultarSQL($query);
    }
}

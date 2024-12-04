<?php

namespace Model;

class Cita extends ActiveRecord {
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuarioId', 'created_at', 'pago', 'estado'];

    public $id;
    public $fecha;
    public $hora;
    public $usuarioId;
    public $created_at;
    public $pago;
    public $estado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->created_at = date('Y-m-d H:i:s');
        $this->pago = $args['pago'] ?? '';
        $this->estado = $args['estado'] ?? '';
    }

    public static function verificarDisponibilidad($fecha, $hora) {
        $query = "SELECT id FROM " . static::$tabla . 
                " WHERE fecha = '" . s($fecha) . "' AND hora = '" . s($hora) . "'" .
                " AND (estado = 'confirmada' OR estado = 'pendiente')";
        
        $resultado = static::SQL($query);
        return empty($resultado);
    }
}
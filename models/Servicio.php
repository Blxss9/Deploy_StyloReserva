<?php

namespace Model;

class Servicio extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre_servicio', 'precio', 'tiempo_estimado'];

    public $id;
    public $nombre_servicio;
    public $precio;
    public $tiempo_estimado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre_servicio = $args['nombre_servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->tiempo_estimado = $args['tiempo_estimado'] ?? '';
    }

    public function validar() {
        
        if(!$this->nombre_servicio) {
            self::$alertas['error'][] = 'El nombre del servicio es obligatorio';
        }
        if(!$this->precio) {
            self::$alertas['error'][] = 'El precio es obligatorio';
        } elseif(!is_numeric($this->precio) || $this->precio <= 0) {
            self::$alertas['error'][] = 'El precio debe ser un número mayor a 0';
        }
        if(!$this->tiempo_estimado) {
            self::$alertas['error'][] = 'El tiempo estimado es obligatorio';
        } elseif(!is_numeric($this->tiempo_estimado) || $this->tiempo_estimado <= 0) {
            self::$alertas['error'][] = 'El tiempo estimado debe ser un número mayor a 0';
        }

        return self::$alertas;
    }
}
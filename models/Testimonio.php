<?php

namespace Model;

class Testimonio extends ActiveRecord {
    protected static $tabla = 'testimonios';
    protected static $columnasDB = ['id', 'usuario_id', 'contenido', 'calificacion', 'fecha_creacion'];

    public $id;
    public $usuario_id;
    public $contenido;
    public $calificacion;
    public $fecha_creacion;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->usuario_id = $args['usuario_id'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
        $this->calificacion = $args['calificacion'] ?? '';
        $this->fecha_creacion = $args['fecha_creacion'] ?? date('Y-m-d H:i:s');
    }

    public function validar() {
        if(!$this->contenido) {
            self::$alertas['error'][] = 'El contenido del testimonio es obligatorio';
        }
        if(!$this->calificacion || $this->calificacion < 1 || $this->calificacion > 5) {
            self::$alertas['error'][] = 'La calificación debe ser entre 1 y 5 estrellas';
        }
        return self::$alertas;
    }
} 
<?php

namespace Model;

class ActiveRecord {
    // Base de Datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        $resultado = self::$db->query($query);
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        $resultado->free();
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    public function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue; // Ignorar clave primaria
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public function sincronizar($args = []) { 
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    public function guardar(): mixed {
        if (!empty($this->id)) {
            // Actualizar registro existente
            $this->ultima_actualizacion = date('Y-m-d H:i:s'); // Actualiza la fecha
            return $this->actualizar();
        } else {
            // Crear nuevo registro
            $this->fecha_creacion = date('Y-m-d H:i:s'); // Fecha de creación
            $this->ultima_actualizacion = date('Y-m-d H:i:s'); // Fecha inicial de última actualización
            return $this->crear();
        }
    }

    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        return self::consultarSQL($query);
    }

    public static function find($id): ?ActiveRecord {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($id);
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function where($columna, $valor): ?ActiveRecord {
        $query = "SELECT * FROM " . static::$tabla . " WHERE " . $columna . " = '" . self::$db->escape_string($valor) . "' LIMIT 1";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado) ?? null;
    }

    public function crear() {
        $atributos = $this->sanitizarAtributos();
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        $resultado = self::$db->query($query);
        return [
            'resultado' => $resultado,
            'id' => self::$db->insert_id
        ];
    }

    public function actualizar() {
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";
        return self::$db->query($query);
    }

    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        return self::$db->query($query);
    }

    public static function whereAll($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE " . $columna . " = '" . self::$db->escape_string($valor) . "'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function SQL($query) {
        $resultado = self::$db->query($query);
        
        $array = [];
        if($resultado) {
            while($registro = $resultado->fetch_assoc()) {
                $array[] = $registro;
            }
            $resultado->free();
        }
        
        return $array;
    }
}

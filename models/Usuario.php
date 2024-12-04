<?php

namespace Model;

class Usuario extends ActiveRecord {
    // BD
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token', 'fecha_creacion', 'ultima_actualizacion'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $fecha_creacion;
    public $ultima_actualizacion;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
        
        // Establecer fechas automáticamente
        if(!isset($args['id'])) {
            // Si es un nuevo usuario
            $this->fecha_creacion = date('Y-m-d H:i:s');
            $this->ultima_actualizacion = date('Y-m-d H:i:s');
        } else {
            // Si es una actualización
            $this->fecha_creacion = $args['fecha_creacion'] ?? date('Y-m-d H:i:s');
            $this->ultima_actualizacion = date('Y-m-d H:i:s');
        }
    }

    // Validaciones
    public function validarNuevaCuenta() {
        // Validar nombre
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        } elseif (preg_match('/\d/', $this->nombre)) {
            self::$alertas['error'][] = 'El Nombre no puede contener números';
        }
        // Validar apellido
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        } elseif (preg_match('/\d/', $this->apellido)) {
            self::$alertas['error'][] = 'El Apellido no puede contener números';
        }
        // Validar email
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El Email no es válido';
        }
        
        // Validar telefono
        if (!$this->telefono) {
            self::$alertas['error'][] = 'El Teléfono es Obligatorio';
        } elseif (!preg_match('/^\d{9}$/', $this->telefono)) {
            self::$alertas['error'][] = 'El Teléfono debe contener exactamente 9 dígitos';
        }

        // Validar password
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*\d).{8,}$/', $this->password)) {
            self::$alertas['error'][] = 'El Password debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial';
        }
    
        return self::$alertas;
    }
    

    public function validarLogin() {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El Email no es válido';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }

        return self::$alertas;
    }

    public function validarEmail() {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El Email no es válido';
        }

        return self::$alertas;
    }

    public function validarPassword() {
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        } elseif (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*\d).{8,}$/', $this->password)) {
            self::$alertas['error'][] = 'El Password debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial';
        }

        return self::$alertas;
    }

    // Revisa si el usuario ya existe
    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya está registrado';
        }

        return $resultado;
    }

    // Encriptar contraseña
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Verificar contraseña y confirmación de cuenta
    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);

        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password incorrecto o tu cuenta no está confirmada';
            return false;
        }
        return true;
    }

    // Generar token único
    public function crearToken() {
        $this->token = uniqid();
    }

    // Marcar la cuenta como confirmada
    public function confirmarCuenta() {
        $this->confirmado = 1;
        $this->token = null;
    }

    public function validarEdicion() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        } elseif (preg_match('/\d/', $this->nombre)) {
            self::$alertas['error'][] = 'El Nombre no puede contener números';
        }

        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        } elseif (preg_match('/\d/', $this->apellido)) {
            self::$alertas['error'][] = 'El Apellido no puede contener números';
        }

        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El Email no es válido';
        }
        
        if (!$this->telefono) {
            self::$alertas['error'][] = 'El Teléfono es Obligatorio';
        } elseif (!preg_match('/^\d{9}$/', $this->telefono)) {
            self::$alertas['error'][] = 'El Teléfono debe contener exactamente 9 dígitos';
        }

        return self::$alertas;
    }
}

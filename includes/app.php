<?php 

use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';
require 'paypal-config.php';


// Configurar zona horaria para Chile
date_default_timezone_set('America/Santiago');

// Conectarnos a la base de datos
ActiveRecord::setDB($db);


<?php

require '../config/config.php';
require '../config/database.php';
require 'clienteFunciones.php';

// conexion a base de datos
$db = new Database();
$con = $db->conectar();   


$datos = [];

$nombre = 'Pepe';
$apellido = 'Flores';

// agregar valores 
$datos['nombre'] = $nombre; 
$datos['apellido'] = $apellido;


$sql = $con->prepare ("INSERT INTO prueba (nombre, apellido) VALUES (?,?)");
$sql->execute($datos);
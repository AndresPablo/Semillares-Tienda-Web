<?php

require '../config/config.php';
require '../config/database.php';
require 'clienteFunciones.php';

// conexion a base de datos
$db = new Database();
$con = $db->conectar();   


// Valores a mano : FUNCIONA BIEN, hay que omitir el ID
//$sql = $con->prepare ("INSERT INTO prueba (nombre, apellido) VALUES ('pepe, 'flores')");

// Valores dinamicos insertando un array

$datos = [];

$nombre = 'Pepe';
$apellido = 'Flores';

// agregar valores 
$datos['nombre'] = $nombre; 
$datos['apellido'] = $apellido;

print_r($datos);

$sql = $con->prepare ("INSERT INTO prueba (nombre, apellido) VALUES (?, ?)"); 
$sql->execute([$nombre, $apellido]);





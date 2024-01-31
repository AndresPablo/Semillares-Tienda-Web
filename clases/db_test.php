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

/*
$nombre = 'Pepe';
$apellido = 'Flores';

// agregar valores 
$datos['nombre'] = $nombre; 
$datos['apellido'] = $apellido;

print_r($datos);

$sql = $con->prepare ("INSERT INTO prueba (nombre, apellido) VALUES (?, ?)"); */


$nombre = 'Pepe';
$apellido = 'Flores';
$email = 'Pepito@servicio.com';
$telefono = '011 1568987';
$dni = '30303030';

$datos['nombres'] = $nombre; 
$datos['apellidos'] = $apellido;
$datos['email'] = $email; 
$datos['telefono'] = $telefono;
$datos['dni'] = $dni; 

$sql = $con->prepare ("INSERT INTO clientes (nombres, apellidos, email, telefono, dni, estatus, fecha_alta) VALUES(?,?,?,?,?,1, now())");

$sql->execute(array_values($datos));

//$sql->execute($datos); // NO funciona
//$sql->execute([$nombre, $apellido]); // Funciona






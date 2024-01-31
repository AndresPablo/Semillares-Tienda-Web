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

/*
// PRUEBA registro cliente
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
*/

// --------------------------------------------
// PRUEBA insertar compra
$status = "pendiente";
$id_transaccion = $nombre; 
$datos_compra = $payment;
$total = 1235;
$fecha = date('Y-m-d H:i:s');
$fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
$email = 'correo@servicioejemplo.com';
$id_cliente = '123';
// Prepara los datos para insertarlos en la base de datos
$comando = $con->prepare ("INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total) VALUES (?,now(),1,?,?,?)");
$comando->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total]);
$id = $con->lastInsertId();

echo "ID compra: ";
echo $id;
// -------------------------------------------------------------------------------------------------------------

$sql = $con->prepare ("INSERT INTO clientes (nombres, apellidos, email, telefono, dni, estatus, fecha_alta) VALUES(?,?,?,?,?,1, now())");
$sql->execute(array_values($datos));

//$sql->execute($datos); // NO funciona
// $sql->execute(array_values($datos)); // Funciona
//$sql->execute([$nombre, $apellido]); // Funciona






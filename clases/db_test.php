<?php

require '../config/config.php';
require '../config/database.php';
require 'clienteFunciones.php';

// conexion a base de datos
$db = new Database();
$con = $db->conectar();   

$sql = $con->prepare ("INSERT INTO prueba (nombre, apellido) VALUES ('pepe', 'flores')");
$sql->execute($datos);
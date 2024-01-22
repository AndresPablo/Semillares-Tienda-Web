<?php

require '../config/config.php';
require '../config/database.php';
require '/clienteFunciones.php';

// conexion a base de datos
$db = new Database();
$con = $db->conectar();   



$errors = [];


$query = "INSERT INTO prueba (nombre, apellido) VALUES ('pepe', 'flores')";
$result = $db->query($query);

if(!$result) {
    echo "Error al insertar datos: " . $db->error;
  } else {
    echo "Datos insertados exitosamente"; 
  }

  $db->close();
<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';

// conexion a base de datos
$db = new Database();
$con = $db->conectar();   

$errors = [];

$id =  0;
// estamos trabajando con PDO para los valores, pore eso los ?????
$sql = $con->prepare ("INSERT INTO clientes (nombres, apellidos, email, telefono, dni, estatus, fecha_alta) VALUES(?,?,?,?,?,?,1, now())");
if($sql->execute($datos))
{
    $id =   $con->lastInsertId();
}

 // si es mayor a 0 es porque hay un error y nose registro el cliente
 if($id > 0)
 {
     $pass_hash = password_hash($contraseña, PASSWORD_DEFAULT);
     $token = generarToken();
     if(!registraUsuario([$usuario, $password, $token, $id], $con))
     {
         $errors[] = "error al registrar Usuario";
     }
 }else
 {
     $errors[] = "error al registrar Cliente";
 }

 if(count($errors) == 0)
 {

 }else
 {
     print_r($errors);
 }
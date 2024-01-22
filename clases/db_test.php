<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../config/config.php';
require '../config/database.php';
require 'clienteFunciones.php';

// conexion a base de datos
$db = new Database();
$con = $db->conectar();   

$errors = [];



$nombres = 'pepe';
$apellidos = 'flores';
$email = 'correo@servicio.com';
$telefono = '123345';
$dni = 01010101;
$usuario = 'miUser99';
$contraseña = 'Prueba_198654*';
$recontraseña = 'Prueba_198654*';

$datos = [];

// agregar valores 
$datos['nombres'] = $nombres; 
$datos['apellidos'] = $apellidos;
$datos['email'] = $email; 
$datos['telefono'] = $telefono;
$datos['dni'] = $dni; 
$datos['usuario'] = $usuario;
$datos['contraseña'] = $contraseña; 
$datos['recontraseña'] = $recontraseña;


$id =  0;

// estamos trabajando con PDO para los valores, pore eso los ?????
$sql = $con->prepare ("INSERT INTO clientes (nombres, apellidos, email, telefono, dni, estatus, fecha_alta)
VALUES (?, ?, ?, ?, ?, 1, NOW())");
if($sql->execute($datos))
{
    $id = $con->lastInsertId();
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
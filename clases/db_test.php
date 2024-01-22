<?php

require '../config/config.php';
require '../config/database.php';
require 'clienteFunciones.php';

// conexion a base de datos
$db = new Database();
$con = $db->conectar();   

$errors = [];



$nombres = trim('pepe');
$apellidos = trim('flores');
$email = trim('correo@servicio.com');
$telefono = trim('123345');
$dni = trim('01010101');
$usuario = trim('mi_user_99');
$contraseña = trim('1234');
$recontraseña = trim('1234');

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
$sql = $con->prepare ("INSERT INTO clientes (nombres, apellidos, email, telefono, dni, estatus, fecha_alta) VALUES(NULL,?,?,?,?,?,1, now(), NULL, NULL)");
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
<?php

require '../config/config.php';
require '../config/database.php';
require 'clienteFunciones.php';

// conexion a base de datos
$db = new Database();
$con = $db->conectar();   

// Imprimir valor de la conexión
echo "<pre>";
print_r($con); 
echo "</pre>";

// Verifica que no sea null
if($con == null) {
  echo "Error de conexión";
  exit;
}

// Verifica que esté conectado 
if(!$con->getAttribute(PDO::ATTR_SERVER_INFO)) {
  echo "Error de conexión";
  exit;
}



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

try{
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
        error_log(print_r($datos, true)); // registro en log
    }
}catch (PDOException $e) {
    echo "Error PDO: " . $e->getMessage();
  }

 if(count($errors) == 0)
 {

 }else
 {
     print_r($errors);
 }
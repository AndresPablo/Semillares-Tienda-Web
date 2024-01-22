<?php 

function generarToken()
{
    // genera una id unica basada en la hora del sistema y le agrega algun numero mas al azar pos is acaso
    return md5(uniqid(mt_rand(), false));
}

function registraCliente(array $datos, $con)
{
    // estamos trabajando con PDO para los valores, pore eso los ?????
    $sql = $con->prepare ("INSERT INTO clientes (nombres, apellidos, email, telefono, dni, estatus, fecha_alta) VALUES(?,?,?,?,?,1, now())");
    if($sql->execute(array_values($datos)))
    {
        return $con->lastInsertId();
    }
    return 0;
}

function registraUsuario(array $datos, $con)
{
    // omitimos la columna "activacion"
    $sql = $con->prepare ("INSERT INTO usuarios (usuario, password, token, id_cliente) VALUES(?,?,?,?)");
    if($sql->execute(array_values($datos)))
    {
        return true;
    }
    return false;
}
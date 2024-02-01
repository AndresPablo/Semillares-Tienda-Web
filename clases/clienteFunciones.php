<?php 

function esNulo(array $parametros)
{
    foreach($parametros as $parametro)
    {
        if(strlen(trim($parametro)) < 1)
        {
            return true;
        }
    }
    return false;
}

function esEmail($email)
{
    if(filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        return true;
    }
    return false;
}

function validaPassword($password, $repassword)
{
    if(strcmp($password, $repassword ) !== 0)
    {
        return true;
    }
    return false;
}

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

function usuarioExiste($usuario, $con)
{
    // estamos trabajando con PDO para los valores, pore eso los ?????
    $sql = $con->prepare ("SELECT id FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute(array_values($usuario));
    if($sql->fetchColumn() > 0)
    {
        return true;
    }
    return false;
}

function emailExiste($email, $con)
{
    // estamos trabajando con PDO para los valores, pore eso los ?????
    $sql = $con->prepare ("SELECT id FROM clientes   WHERE email LIKE ? LIMIT 1");
    $sql->execute(array_values($email));
    if($sql->fetchColumn() > 0)
    {
        return true;
    }
    return false;
}

function mostrarMensajes(array $errors)
{
    if(count($errors) > 0)
    {
        echo '<div class="alert alert-warning alert-dismissable fade show" role="alert">';
        foreach($errors as $error)
        {
            echo '<li>' . $error . '</li>';
        }
        echo '<ul>';
        echo '<button> type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button> </div>';
    }
}
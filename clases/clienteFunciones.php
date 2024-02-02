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
    if(strcmp($password, $repassword ) === 0)
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
        return $con->lastInsertId();
    }
    return 0;
}

function usuarioExiste($usuario, $con)
{
    // estamos trabajando con PDO para los valores, pore eso los ?????
    $sql = $con->prepare ("SELECT id FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if($sql->fetchColumn() > 0)
    {
        return true;
    }
    return false;
}

function emailExiste($email, $con)
{
    $sql = $con->prepare ("SELECT id FROM clientes   WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
    if($sql->fetchColumn() > 0)
    {
        return true;
    }
    return false;
}

function validaToken($id, $token, $con)
{
    $msg = "";
    $datos = [];
    $datos['id'] = $id; 
    $datos['token'] = $token; 
    $sql = $con->prepare ("SELECT id FROM usuarios WHERE id = ? AND token LIKE ? LIMIT 1");
    //$sql->execute(array_values($datos)); // TODO: genera error de activacion de cuenta??
    $sql->execute([$id, $token]);
    if($sql->fetchColumn() > 0)
    {
        // TODO: ver FIX error aca, la cuenta se activa pero devuelve "error al activar cuenta"
        if(activarUsuario($id,$con))
        {
            $msg = "Cuenta activada.";
        }else{
            $msg = "Error al activar cuenta";
        }
    }else
    {
        $msg = "No existe el registro del cliente.";
    }
    return $msg;
}

function activarUsuario($id, $con)
{
    $sql = $con->prepare ("UPDATE usuarios SET activacion = 1, token = ''  WHERE id = ?");
    //$sql = $con->prepare ("UPDATE usuarios SET activacion = 1 WHERE id = ?");
    return $sql->execute([$id]);
}

function mostrarMensajes(array $errors)
{
print($_SESSION);
    if(count($errors) > 0)
    {
        echo '<div class="alert alert-warning alert-dismissable fade show" role="alert"><ul>';
        foreach($errors as $error)
        {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button></div>';
    }
}

function login($usuario, $password, $con)
{
    $sql = $con->prepare("SELECT id, usuario, password FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if(esActivo($usuario, $con)){
            if(password_verify($password, $row['password']))
            {
                // Inicio exitoso
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['usuario'];
                header("Location: index.php");
                exit;
            }
        }
        else
        {
            return 'El usuario no ha sido activado';
        }
    }
    else
    {
        return 'El usuario y/o contraseña son incorrectos';
    }
}

function esActivo($usuario, $con)
{
    $sql = $con->prepare ("SELECT activacion from usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if($row['activacion'] == 1)
    {
        return true;
    }
    return false;
}
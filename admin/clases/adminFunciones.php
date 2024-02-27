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

// Esta insercion incluye direccion, referencia, provincia y localidad
function registraClienteAvanzado(array $datos, $con)
{
    // estamos trabajando con PDO para los valores, pore eso los ?????
    $sql = $con->prepare ("INSERT INTO clientes (nombres, apellidos, email, telefono, dni, direccion, referencia, provincia, localidad, estatus, fecha_alta) 
        VALUES(?,?,?,?,?,?,?,?,?,1, now())");
    if($sql->execute(array_values($datos)))
    {
        return $con->lastInsertId();
    }
    return 0;
}

function usuarioExiste($usuario, $con)
{
    // estamos trabajando con PDO para los valores, pore eso los ?????
    $sql = $con->prepare ("SELECT id FROM admin WHERE usuario LIKE ? LIMIT 1");
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
    $sql = $con->prepare ("SELECT id FROM admin WHERE id = ? AND token LIKE ? LIMIT 1");
    $sql->execute([$id, $token]);
    if($sql->fetchColumn() > 0)
    {
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
    $sql = $con->prepare ("UPDATE admin SET activo = 1, token = ''  WHERE id = ?");
    return $sql->execute([$id]);
}

function mostrarMensajes(array $errors)
{
    if(count($errors) > 0)
    {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"> </button>';
        echo '<ul>';
            foreach($errors as $error)
            {
                echo '<li>' . $error . '</li>';
            }
        echo '</ul>';
        echo '</div>';
    }
}

function login($usuario, $password, $con)
{
    $sql = $con->prepare("SELECT id, usuario, password, nombre FROM admin WHERE usuario LIKE ? AND activo = 1 LIMIT 1");
    $sql->execute([$usuario]);
    if($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if(esActivo($usuario, $con)){
            if(password_verify($password, $row['password']))
            {
                // Inicio exitoso
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['usuario'];
                $_SESSION['user_type'] = 'admin';
                header('Location: inicio.php');
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

function login_correo($correo, $password, $con, $proceso)
{
    $sql = $con->prepare("SELECT id, email, password, id_cliente FROM admin WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$correo]);
    if($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if(esActivo($correo, $con)){
            if(password_verify($password, $row['password']))
            {
                // Inicio exitoso
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['usuario'];
                $_SESSION['user_mail'] = $row['email'];
                $_SESSION['user_cliente'] = $row['id_cliente'];
                if($proceso == 'pago')
                {
                    header("Location: checkout.php");
                } else{
                    header("Location: index.php");
                }
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
    $sql = $con->prepare ("SELECT activo from admin WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if($row['activo'] == 1)
    {
        return true;
    }
    return false;
}

function solicitaPassword($user_id, $con)
{
    $token = generarToken();

    $sql = $con->prepare("UPDATE admin SET token_password=?, password_request=1 WHERE id=?");
    if($sql->execute([$token, $user_id]))
    {
        return $token;
    }
    return null;
}

function verificaTokenRequest($userId, $token, $con)
{
    $sql = $con->prepare("SELECT id FROM admin WHERE id=? AND token_password LIKE ? AND password_request=1 LIMIT 1");
    $sql->execute([$userId, $token]);
    if($sql->fetchColumn() > 0)
    {
        return true;
    }
    return false;
    
}

function actualizaPassword($user_id, $password, $con)
{
    $sql = $con->prepare("UPDATE admin SET password=?, token_password = '', password_request = 0 WHERE id = ?");
    if($sql->execute([$password, $user_id]))
    {
        return true;
    }
    return false;
}

function getEmail($user_id, $con)
{
    $sql = $con->prepare("SELECT email FROM clientes WHERE id = ?");
    $email = '';
    $idCliente = $_SESSION['user_cliente'];
    if($sql->execute([$idCliente]))
    {
        $row_cliente = $sql->fetch(PDO::FETCH_ASSOC);
        if($row_cliente)
        {
            $email = $row_cliente['email'];
        }
    }
    return $email;
}

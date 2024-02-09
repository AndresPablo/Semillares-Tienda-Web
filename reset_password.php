<?php 

require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';

$user_id = $_GET['id'] ?? $_POST['user_id'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if($user_id == '' || $token == '')
{
    header("Location: index.php");
    exit;
}

$db = new Database();
$con = $db->conectar();
$errors = [];

if(!verificaTokenRequest($user_id, $token, $con))
{
    echo "No se pudo verificar la información.";
    exit;
}

if(!empty($_POST))
{
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    if(esNulo([$user_id, $token, $password, $repassword]))
    {
        $erorrs[] = "Debes completar todos los campos";
    }
    if(!validaPassword([$password, $repassword]))
    {
        $erorrs[] = "Las contraseñas no coinciden";
    }
    if(count($errors) == 0)
    {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        if(actualizaPassword([$user_id, $password_hash, $con]))
        {
            echo "Contraseña modificada <br><a href='login.php'>Iniciar Sesión</a>";
            exit;
        }else 
        {
            $erorrs[] = "Error al modificar conbtraseña. Intentalo nuevamente";
        }
    }


}

?>


<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Semillares - Dietética</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <!-- Custom CSS (personalizado)-->
        <link href="css/custom.css" rel="stylesheet" />
        <!-- Fuentes (Montserrat) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&display=swap" rel="stylesheet">
    </head>


    <body>
        
        <!------- CONTENIDO -------------------->
        <main class="form-login m-auto pt-4">
            <h3>Cambiar contraseña</h3>
            <?php mostrarMensajes($errors); ?>
            <form action="reset_password.php" method="post" class="row g-3" autocomplete="off">

                <input type="hidden" name="user_id" id="user_id" value="<?= $user_id;?>">
                <input type="hidden" name="token" id="token" value="<?= $token;?>">
                <div class="form-floating">
                    <input class="form-control" type="email" name="email" id="email" placeholder="Correo Electrónico" required>
                    <label for="email">Correo Electrónico</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña" required>
                    <label for="password">Nueva Contraseña</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" type="password" name="repassword" id="repassword" placeholder="Confirmar Contraseña" required>
                    <label for="repassword">Confirmar Contraseña</label>
                </div>
                

                <div class="d-grid gap-3 col-12">
                    <button type="submit" class="btn btn-primary">Continuar</button>
                </div>

                
                <div class="col-12">
                    <a href="login.php"> Iniciar Sesión </a>
                </div>

                <div class="col-12">
                    ¿No tiene cuenta? <a href="registro.php"> Registrate aquí </a>
                </div>

            </form>

        </main>
        
        
        <!------- -------------------->
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
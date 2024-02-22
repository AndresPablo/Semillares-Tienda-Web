<?php
    require 'config/config.php';
    require 'config/database.php';
    require 'clases/clienteFunciones.php';

    $db = new Database();
    $con = $db->conectar();
    $errors = [];

    if(!empty($_POST['email']))
    {
        $email = trim($_POST['email']);
    }

    if(esNulo([$email]))
    {
        $errors[] = "Debe llenar todos los campos obligatorios.";
    }

    if(!esEmail($email))
    {
        $errors[] = "La dirección de correo no es válida.";
    }

    if(count($errors) == 0)
    {
        if(emailExiste($email, $con))
        {
            $sql = $con->prepare("SELECT usuarios.id, clientes.nombres FROM usuarios
            INNER JOIN clientes ON usuarios.id_cliente=clientes.id
            WHERE clientes.email LIKE ? LIMIT 1");
            $sql->execute([$email]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];
            $nombres = $row['nombres'];
            $token = solicitaPassword($user_id, $con);
            if($token !== null)
            {
                require 'clases/Mailer.php';
                $mailer = new Mailer();
                $url = SITE_URL . '/reset_password.php?id=' . $user_id . '&token=' . $token;
                $asunto = "Recuperar contraseña - Tienda Semillares";
                $cuerpo = "Estimado $nombres: <br> Si has solicitado el cambio de su contraseña, hacé clic en el siguiente link <a href='$url'>$url</a>.";
                $cuerpo .= "<br>SI no solicitaste este blanqueo, ignorá este correo.";
                $cuerpo  = mb_convert_encoding($cuerpo, 'ISO-8859-1', 'UTF-8');

                if($mailer->enviarMail($email, $asunto, $cuerpo))
                {
                    echo "<p><b>correo enviado $email</b></p>";
                    echo "<p>Hemos enviado un correo a la dirección $email para restablecer la contraseña.</p>";
                    exit;
                }
            }
        }
    }else{
        $errors[] = "No existe una cuenta asociada a esa dirección de correo electrónico.";
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

    <?php include 'menu.php'; ?>

    <main>
        <h3>Recuperar contraseña</h3>
        <?php mostrarMensajes($errors) ?>
        <form action="recupera.php" method="post" class="row g-3" autocomplete="off">
            <div class="form-floating">
                <label for="email">Correo Electrónico</label>
                <input class="form-control" type="text" name="email" id="email" placeholder="Email"> 
            </div>
            <div class="d-grid gap-3 col-12">
                <div class="login_btn d-flex align-items-center justify-content-center my-3">
                    <button type="submit" class="btn btn-primary" >Continuar</button>
                </div>
            </div>
            <div class="col-12">
                ¿No tenés cuenta? <a href="registro.php">Registrate acá</a>
            </div>
        </form>
    </main>

    <?php include 'footer.php'; ?>

</html>
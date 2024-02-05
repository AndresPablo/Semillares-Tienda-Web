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
            INNER JOIN clientes ON usuarios.id_cliente=cliente=clientes.id
            WHERE clientes.email LIKE ? LIMIT 1");
            $sql->execute([$email]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];
            $nombres = $row['nombres'];
            $token = solicitaPassword($user_id, $con);
            if($token !== null)
            {
                require 'class/Mailer.php';
                $mailer = new Mailer();
                $url = SITE_URL - 'user/reset_password.php?' . $id_usuario . '$token=' .$token;
                $asunto = "Recuperar contraseña - Tienda Semillares";
                $cuerpo = "Estimado $nombres: <br> Si has solicitado el cambio de su contraseña, hacé clic en el siguiente link <a href=$url'>$url </a>.";
                $cuerpo = "<br>SI no solicitaste este blanqueo, ignorá este correo.";

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

</html>
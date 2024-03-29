<?php

    require 'config/config.php';
    require 'config/database.php';
    require 'clases/clienteFunciones.php';

    // https://youtu.be/SDXkKHF2jD8?list=PL-Mlm_HYjCo-Odv5-wo3CCJ4nv0fNyl9b&t=1433
    // ESTE https://youtu.be/ox6FIJM5uY0?list=PL-Mlm_HYjCo-Odv5-wo3CCJ4nv0fNyl9b&t=1078 

    $db = new Database();
    $con = $db->conectar();

    $id_transaccion = isset($_GET['key']) ? $_GET['key'] : '0';
    $error = '';
    if($id_transaccion == '' || $id_transaccion == 0)
    {
        $error = 'Error al procesar la peticion';
    }else{
        $sql = $con->prepare("SELECT count(id) FROM compra WHERE id_transaccion=? AND status=?");
        $sql->execute([$id_transaccion, 'approved']);
        if($sql->fetchColumn() > 0)
        {
            $sql = $con->prepare("SELECT id, fecha, email, total FROM compra WHERE id_transaccion=? AND
            status=? LIMIT 1");
            $sql->execute([$id_transaccion, 'approved']);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            
            $id_compra = $row['id'];
            $total = $row['total'];
            $fecha = $row['fecha'];
            $fecha_formateada = date('d-m-Y H:i', strtotime($fecha));
            $correo = $row['email'];
            $email = getEmail($_SESSION['user_cliente'], $con);

            $sqlDet = $con->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
            $sqlDet->execute([$id_compra]);
        } else {
            $error = 'Error al comprobar la compra.';
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
        <title>Completado</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
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
        <main>
            <div class="container m-3 p-2">
                <h2>
                    Gracias por su compra
                </h2>
                <div class="">
                    <b>Número de orden: </b> <?php echo $id_transaccion; ?><br>
                    <b>Fecha de compra: </b><?php echo $fecha_formateada; ?><br>
                    <b>Total: </b><?php echo MONEDA . number_format($total,2, '.', '.');?><br>
                    <br>
                    <p>Te enviamos un correo electrónico a <b><?php echo $correo; ?></b> con el detalle de tu compra.</p><br>
                    <a href="tienda.php"> <button class="btn btn-primary">
                            Volver a la tienda
                    </button></a>
                    <p>No te llegó? Revisá tu correo no deseado y spam. Si no lo encontrás comunicate con nosotros.</p>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <?php include 'footer.php'?>

    </body>

</html>
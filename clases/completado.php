<?php

    require 'config/config.php';
    require 'config/database.php';
    $db = new Database();
    $con = $db->conectar();

    $id_transaccion = isset($GET['key']) ? $_GET['key'] : '0';
    $error = '';
    if($id_transaccion == '')
    {
        $error = 'Error al procesar la peticion';
    }else{
        $sql = $con->prepare("SELECT count(id) FROM compra WHERE id_transaccion=? AND status=?");
        $sql->execute([$id_transaccion, 'COMPLETED']);
        if($sql->fetchColumn() > 0)
        {
            $sql = $con->prepare("SELECT id, fecha, email, total FROM compra WHERE id_transaccion=? AND
            status=? LIMIT 1");
            $sql->execute([$id_transaccion, 'COMPLETED']);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $id_compra = $row['id'];
            $id_compra = $row['total'];
            $id_compra = $row['fecha'];

            $sqlDet = $con->prepare("SELECT nombre, precio, cantidad FROM detalle_compra WHERE id_compra = ?");
            $sqlDet->execute([$id_compra]);
        } else {
            $error = 'Error al comprobar la compra.';
        }
    }

?>

<!DOCTYPE>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <h2>
            Gracias por su compra.
        </h2>
        <div>
            <b>Folio de la compra:</b> <?php echo $id_transaccion; ?><br>
            <b>Fecha de la compra</b><?php echo $fecha; ?><br>
            <b>Total:</b><?php echo MONEDA . number_format($total,2, '.', '.');?><br>
        </div>
    </body>

</html>
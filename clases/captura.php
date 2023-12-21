<?php

require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);

$payment = $_GET['payment_id'];
$status = $_GET['status'];
$payment_type = $_GET['payment_type'];
$order_id = $_GET['merchant_order_id'];

echo "<h3> Pago exitoso! </h3>";
echo $payment.'<br>';
echo $status.'<br>';
echo $payment_type.'<br>';
echo $order_id.'<br>';

//unset($_SESSION['carrito']);

if(is_array($datos)){

    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_adress'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];

    $comando = $con->prepare("INSERT INTO compra (id_transaccion, fecha,status, email,id_cliente, total)
    VALUES (?,?,?,?,?,?)");
    $comando->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total]);
    $id = $con->lastInsertId();

    if($id > 0)
    {
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if($productos != null)
        {
            foreach($productos as $clave => $cantidad)
            {
                $sqlProd = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo =1");
                $sqlProd->execute([$clave]);
                $row_prod = $sqlProd->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];
                $precio_desc =  $precio - (( $precio * $descuento)/100);
                
                $sql_insert = $con->prepare("INSERT INTO detalle_compra (id-compra, id-producto, nombre, precio, cantidad)");
                $sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio_desc, $cantidad]);
            }
            include 'enviar_mail.php';
        }
        unset($_SESSION['carrito']); // limpiamos la variable de sesion carrito
    }
    // TODO: revisar luego borrar
    // timestamp
    // https://youtu.be/fRYErum_xkY?list=PL-Mlm_HYjCo-Odv5-wo3CCJ4nv0fNyl9b&t=1527
}

?>
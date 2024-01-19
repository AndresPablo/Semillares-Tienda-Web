<?php

require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();


// Consultar BD
//$sql = "SELECT preference_id FROM pagos WHERE ...";

//$row = ...;
$preferenceId = $row['preference_id'];
$paymentInfo = $sdk->payment->get($preferenceId);
$payment = $paymentInfo['response'];



$payment = $_GET['payment_id'];
$status = $_GET['status'];
$payment_type = $_GET['payment_type'];
$order_id = $_GET['merchant_order_id'];
$live_mode = $_GET['live_mode'];
$payer = $_GET['payer'];
$card = $_GET['card'];

var_dump($payment); // TEST

$paymentId = $payment['id']; 
$status = $payment['status'];

if(!empty($payment)) {
    echo "Datos del pago recibidos";
  } else {
    echo "No se recibieron datos del pago";
}

echo "<h3> Pago exitoso! </h3>";

echo $payment.'<br>';
echo $status.'<br>';
echo $payment_type.'<br>';
echo $order_id.'<br>';
echo $live_mode.'<br>';
echo $card.'<br>';

print_r($datos);

if($payment > 0)
{
    echo "llamando enviar_mail.php";
    include 'enviar_mail.php';
    echo "Borrar (unset) carrito";
    unset($_SESSION['carrito']); // limpiamos la variable de sesion carrito
}

if(is_array($datos))
{
    //$id_transaccion = $datos['detalles']['id']; // paypal
    $id_transaccion = $payment;
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos['detalles']['payer']['email_adress'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];
    // Prepara los datos para insertarlos en la base de datos
    $comando = $con->prepare("INSERT INTO compra (id_transaccion, fecha,status, email,id_cliente, total)
    VALUES (?,?,?,?,?,?)");
    $comando->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total]);
    $id = $con->lastInsertId();

    if($id > 0)
    {
        echo "id es mas de cero";
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
        if($productos != null)
        {
            echo "Hay productos";
            foreach($productos as $clave => $cantidad)
            {
                echo "iteracion de producto";
                $sqlProd = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo =1");
                $sqlProd->execute([$clave]);
                $row_prod = $sqlProd->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];
                $precio_desc =  $precio - (( $precio * $descuento)/100);
                
                $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad)");
                $sql_insert->execute([$id, $clave, $row_prod['nombre'], $precio_desc, $cantidad]);
            }
            // Enviar correo única vez después de insertar productos
            echo "llamando enviar_mail.php";
            include 'enviar_mail.php';
        }
        echo "Borrar (unset) carrito";
        unset($_SESSION['carrito']); // limpiamos la variable de sesion carrito
    }
    // TODO: revisar luego borrar
    // timestamp
    // https://youtu.be/fRYErum_xkY?list=PL-Mlm_HYjCo-Odv5-wo3CCJ4nv0fNyl9b&t=1527
}
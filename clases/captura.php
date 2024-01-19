<?php

require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();


// Consultar BD
//$sql = "SELECT preference_id FROM pagos WHERE ...";
//$row = ...;
//$preferenceId = $row['preference_id'];
//$paymentInfo = $sdk->payment->get($preferenceId);
//$payment = $paymentInfo['response'];
//$paymentId = $payment['id']; 
//$status = $payment['status'];

$payment = $_GET['payment_id'];
$status = $_GET['status'];
$payment_type = $_GET['payment_type'];
$order_id = $_GET['merchant_order_id'];

var_dump($payment); // TEST

if(!empty($payment)) {
    echo "Datos del pago recibidos";
  } else {
    echo "No se recibieron datos del pago";
}

if($payment > 0)
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
}

?>

<!DOCTYPE html>
<html lang="es-AR">
        
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Semillares - Checkout Mercado Pago</title>
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
        <!-- JQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- SDK Mercado Pago -->
        <script src="https://sdk.mercadopago.com/js/v2"></script>
        <!-- Funciones SDK Mercado Pago -->
        <script src="js/funciones-MP.js"></script>
    </head>

    <body>
        <section>
            <div class="container">
                <h3>Tu pago se realizó con éxito</h3>
                <h5>Te hemos enviado un correo con los datos de tu compra</h5>
                <a href=""> <button>
                    Volver a la tienda
                </button></a>
                <p>No te llegó? Revisá tu correo no deseado y spam. Si no lo encontrás comunicate con nosotros.</p>
            </div>
        </section>
    <body>
</html>
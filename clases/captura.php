<?php

require '../config/config.php';
require '../config/database.php';
$db = new Database();
$con = $db->conectar();

$idTransaccion = isset($_GET['payment_id']) ? $_GET['payment_id'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : ''; 


if ($idTransaccion != '') {
    // 19. asignar compras
    $idCliente = $_SESSION['user_cliente'];
    $sqlProd = $con->prepare("SELECT email, direccion, referencia, provincia, localidad FROM clientes WHERE id=? AND estatus=1");
    $sqlProd->execute([$idCliente]);

    $fecha = date("Y-m-d H:i:s");
    $monto = isset($_SESSION['carrito']['total']) ? $_SESSION['carrito']['total'] : 0;
    $row_cliente = $sqlProd->fetch(PDO::FETCH_ASSOC);
    $email = $row_cliente['email']; // enviamos a este mail
    $direccion = $row_cliente['direccion'];
    $referencia = $row_cliente['referencia'];
    $provincia = $row_cliente['provincia'];
    $localidad = $row_cliente['localidad'];


    $datos = [];
    $datos['id_transaccion'] = $idTransaccion; 
    $datos['fecha_nueva'] = $fecha; 
    $datos['status'] = $status; 
    $datos['email'] = $email; 
    $datos['id_cliente'] = $idCliente;
    $datos['total'] = $monto; 

    // Prepara los datos para insertarlos en la base de datos (tabla COMPRA)
    $comando = $con->prepare("INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total) VALUES (?,?,?,?,?,?)");
    $comando->execute(array_values($datos)); // Inserta la compra en la tabla "compra"
    $id = $con->lastInsertId(); // La id de la insercion, para encontrarlo en la DB

    // Inserta los datos del detalle de cada compra en la tabla DETALLES
    if($id > 0) {
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : 
        null;
        
        // Tabla para el mail
        $tabla = '<table class="table" border="0" cellpadding="10" cellspacing="0" style="border:1px solid #eee">
                    <thead>
                        <tr style="background: #fff5ee">
                            <th style="text-align:left; padding:10px; border:1px solid #eee;">Producto</th>
                            <th style="text-align:center; padding:10px; border:1px solid #eee;">Precio</th>
                            <th style="text-align:center; padding:10px; border:1px solid #eee;">Cantidad</th>
                            <th style="text-align:center; padding:10px; border:1px solid #eee;">Subtotal</th>
                        </tr>
                    </thead>
                <tbody>';

        if($productos != null)
        {
            foreach($productos as $clave => $cantidad)
            {
                $sqlProd = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo =1");
                $sqlProd->execute([$clave]);
                $row_prod = $sqlProd->fetch(PDO::FETCH_ASSOC);

                $precio = $row_prod['precio'];
                $descuento = $row_prod['descuento'];
                $precio_desc =  $precio - (( $precio * $descuento) / 100);

                $detalles = [];
                $detalles['id_compra'] = $id; 
                $detalles['id_producto'] = $row_prod['id']; 
                $detalles['nombre'] = $row_prod['nombre']; 
                $detalles['precio'] = $precio_desc; 
                $detalles['cantidad'] = $cantidad; 
                
                $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad)  VALUES (?,?,?,?,?)");
                $sql_insert->execute(array_values($detalles)); // Inserta la compra en la tabla "detalle_compra"

                // construye el cuerpo de la tabla para enviar luego por correo
                $tabla .= '<tr>';
                $tabla .= '<td>' . $row_prod['nombre'] . '</td>';
                $tabla .= '<td>' . $precio_desc . '</td>';
                $tabla .= '<td>' . $cantidad . '</td>';
                $tabla .= '<td>' . $precio_desc * $cantidad . '</td>';
                $tabla .= '</tr>';
            }
            
            $tabla .= '</tbody></table>';
            
            // ENVIAR mail con Mailer.php
            require 'Mailer.php';
            $asunto = "Detalles de tu compra";
            $cuerpo = '<h4> Gracias por su compra! </h4>';
            $cuerpo .= '<p>El ID de su compra es <b>'. $idTransaccion .'</b></p>';
            $cuerpo .= '<p>Ha comprado por <b>$'. $monto .'</b></p>';
            $cuerpo .= '<p>Te enviaremos el pedido a ' . $direccion . ', ' . $localidad . ', ' . $provincia . '.';
            $cuerpo .= '<br><p>En breve te contactamos para coordinar el envio, o llamanos al 0221 570-2432.</p><br>';
            $cuerpo .= $tabla;
    
            $mailer = new Mailer();
            $mailer->enviarMail($email, $asunto, $cuerpo);
        }
        unset($_SESSION['carrito']); // limpiamos la variable de sesion carrito       
        header("Location: " . SITE_URL . "/completado.php?key=" . $idTransaccion);
    }

}



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



// TEST
/*$pago = $sdk->payment->get($payment);
if(!empty($payment)) {
    echo "Datos del pago recibidos";
    echo $payment;
    var_dump($payment);
    var_dump($pago);
  } else {
    echo "No se recibieron datos del pago";
}
*/

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
        <link href="../css/styles.css" rel="stylesheet" />
        <!-- Custom CSS (personalizado)-->
        <link href="../css/custom.css" rel="stylesheet" />
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
        <!-- Responsive navbar-->
        <?php include 'menu.php'?>
        <section>
            <div class="container">
                <h3>Tu pago se realizó con éxito</h3>
                <h5>Te hemos enviado un correo con los datos de tu compra</h5>
                <h5>El código de tu compra es <b><?php echo $id_transaccion;?>.</b></h5>
                <a href=""> <button>
                    Volver a la tienda
                </button></a>
                <p>No te llegó? Revisá tu correo no deseado y spam. Si no lo encontrás comunicate con nosotros.</p>
            </div>
        </section>

        <main>
        </main>
    <body>
</html>
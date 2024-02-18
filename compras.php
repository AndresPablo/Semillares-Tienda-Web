<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';

$token_session = $_SESSION['token'];
$orden = $_GET['orden'] ?? null;
$token = $_GET['token'] ?? null;

if($orden == null || $token == null || $token == $token_session)
{
    header("Location: compras.php");
    exit;
}

$db = new Database();
$con = $db->conectar();

print_r($_SESSION);
$idCliente = $_SESSION['user_cliente'];

$sqlCompra = $con->prepare("SELECT id_transaccion, fecha, status, total FROM compra WHERE id_cliente=? ORDER BY DATE(fecha) DESC");
$sqlCompra->execute([$idCliente]);

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
        
        <!-- Responsive navbar-->
        <?php include 'menu.php'?>

        <!-- Contenido -->
        <main>
            <div class="container">
                <h4>Mis compras</h4>
                <hr>
                <div class="col-12 col-md-4">
                    <h3>Informacion Personal</h3>
                    <p>Nombre de usuario</p>
                    <p>correo@ejemplo.com</p>
                </div>
                <hr>
                <?php while($rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC)){
                    $rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC);
                    $idCompra = $rowCompra['id'];

                    $sqlDetalle = $con->prepare("SELECT id, id_compra, nombre, precio, cantidad FROM detalle_compra WHERE id_compra =?");
                    $sqlDetalle->execute([$idCompra]);
                    ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <?php echo $rowCompra['fecha']; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">     <?php echo $rowCompra['id_transaccion']; ?>     </h5>
                            <p class="card-text">  <?php echo $rowCompra['total']; ?>  </p>
                            <p><strong>Fecha: </strong><?php echo $rowCompra['fecha']; ?></p>
                            <p><strong>Orden: </strong><?php echo $rowCompra['id_transaccion']; ?></p>
                            <p><strong>Total: </strong><?php echo MONEDA . ' ' . number_format($rowCompra['total'], 2, ',', '.'); ?></p>
                            <p><strong>Fecha: </strong><?php echo $rowCompra['fecha']; ?></p>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php 
                                        while($rowDetalle = $sqlDetalle->fetch(PDO::FETCH_ASSOC)){ 
                                            $precio = $rowDetalle['precio'];
                                            $cantidad = $rowDetalle['cantidad'];
                                            $subtotal = $precio * $cantidad;
                                        ?>
                                        <tr>
                                            <td><?php echo $rowDetalle['nombre']; ?></td>
                                            <td><?php echo MONEDA . ' ' . number_format($precio, 2, ',', '.'); ?></td>
                                            <td><?php echo $cantidad; ?></td>
                                            <td><?php echo MONEDA . ' ' . number_format($subtotal, 2, ',', '.'); ?></td>
                                        </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <a href="compra_detalle.php" class="btn btn-primary">Detalle</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
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
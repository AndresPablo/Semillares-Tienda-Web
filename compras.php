<?php

require 'config/config.php';
require 'config/database.php';
require 'clases/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

$token = generarToken();
$_SESSION['token'] = $token;
$idCliente = $_SESSION['user_cliente'];

$sqlCliente = $con->prepare("SELECT nombres, apellidos, email, telefono, dni, direccion, localidad, provincia FROM clientes WHERE id=? LIMIT 1");
$sqlCliente->execute([$idCliente]);
$rowCliente = $sqlCliente->fetch(PDO::FETCH_ASSOC);

$nombres = $rowCliente['nombres'];
$apellidos = $rowCliente['apellidos'];
$dni = $rowCliente['dni'];
$correo = $rowCliente['email'];
$telefono = $rowCliente['telefono'];
$provincia = $rowCliente['provincia'];
$direccion = $rowCliente['direccion'];
$localidad = $rowCliente['localidad'];

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
            <div class="container row">
                <!-- TITULAR -->
                <div class="mt-3 pt-3">
                    <h2>Hola, <b><?php echo $_SESSION['user_name']; ?>!</b></h2>
                </div>
                <!-- INFO PERSONAL -->
                <div class="container mt-3 col col-lg-12 col-md-4">
                    <h4>Información Personal</h4>
                    <hr>
                    <div class="col-12 col-md-4">
                        <p><strong>Nombre y Apellido: </strong><?php echo $nombres . ' ' . $apellidos; ?></p>
                        <p><strong>Correo:</strong> <?php echo $correo; ?></p>
                        <p><strong>Telefono:</strong> <?php echo $telefono;?></p>
                        <p><strong>Localidad:  </strong><?php echo $localidad;?></p>
                        <p><strong>Provincia:  </strong><?php echo $provincia;?></p>
                        <p><strong>Direccion:  </strong><?php echo $direccion;?></p>
                        <p><strong>DNI: </strong><?php echo $dni;?></p>
                        <a href="#" class="btn btn-primary">Editar Datos</a>
                    </div>
                    <hr>
                </div>
                <!-- COMPRAS -->
                    
                <div class="container col col-lg-12 col-md-8">
                    <h4>Mis compras</h4>
                    <hr>
                    <?php while($rowCompra = $sqlCompra->fetch(PDO::FETCH_ASSOC)){ ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <?php 
                                    $fecha = $rowCompra['fecha'];
                                    $fecha_formateada = date('d-m-Y H:i', strtotime($fecha));
                                    echo $fecha_formateada; 
                                ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><strong>Orden: </strong><?php echo $rowCompra['id_transaccion']; ?>     </h5>
                                <p><strong>Total: </strong><?php echo MONEDA . ' ' . number_format($rowCompra['total'], 2, ',', '.'); ?></p>                                
                                <a href="compra_detalles.php?orden=<?php echo $rowCompra['id_transaccion']; ?>$token=<?php echo $token;?>" class="btn btn-primary">Ver Detalle</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>                
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
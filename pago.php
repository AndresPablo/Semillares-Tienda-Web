<?php
    require 'config/config.php';
    require 'config/database.php';

    // SDK Mercado Pago
    require __DIR__ .  '/vendor/autoload.php'; 

    // Configurar SDK
    MercadoPago\SDK::setAccessToken(TOKEN_MP);  

    // Crear preferencia
    $preference = new MercadoPago\Preference();


    $preference->back_urls = array(
        "success"=> "https://semillares.com.ar/clases/captura.php",
        "failure"=> "https://semillares.com.ar/clases/fallo.php"
    );

    // Los compradores vuelven a mi sitio tras terminar con exito la compra
        $preference->auto_return = "approved";
    // el pago solo puede ser aprobado o rechazado (instantaneo)
        $preference->binary_mode = true; 

    $lista_carrito = array();

    // conexion a base de datos
    $db = new Database();
    $con = $db->conectar();

    // Tomar productos del carrito de la sesión
    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;


    if ($productos != null && count($productos) > 0) {
        foreach ($productos as $clave => $cantidad) {
            $sql = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id=? AND activo=1");
            if (!$sql) {
                die("Error en la preparación de la consulta");
            }
            if (!$sql->execute([$clave])) {
                die("Error al ejecutar la consulta");
            }
            $producto = $sql->fetch(PDO::FETCH_ASSOC);
            // Agrega la cantidad al array de resultados
            $producto['cantidad'] = $cantidad;
            $lista_carrito[] = $producto;

            // Agregar item al carrito
            $item = new MercadoPago\Item();
            $item->id = $producto['id'];
            $item->title = $producto['nombre'];
            $item->quantity = $producto['cantidad'];
            $item->unit_price = $producto['precio'] - (($producto['precio'] * $producto['descuento']) / 100);
            $item->currency = "ARS";

            $productos_mp[] = $item;
        }
    } else {
        header("location: index.php");
        exit;
    }

    // Agregar items al carrito
    $preference->items = $productos_mp;

    // Guardar preferencia
    $preference->save();

    $preferenceId = $preference->id;
    // Guardar en BD  
    $sql = "INSERT INTO pagos(preference_id) VALUES ($preferenceId)";

    if (!$con) {
        die("Error de conexión a la base de datos: " . $db->getLastError());
    }
?>




<!-- HTML -->
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
      <!-- Contenido -->
      <main>
        <div class="container">

        <div class="row my-5">
            <div class="col-6">
                <h4>Detalles de pago</h4>
                <div class="row">
                    <div class= "col-12">
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
                <div class="row">
                    <div class= "col-12">
                        <div class="cho-container"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">            
            </div>
                <div class="table table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                            <tbody>
                                <?php if($lista_carrito == null)
                                {
                                    echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
                                }
                                else
                                {
                                    $total = 0;
                                    foreach($lista_carrito as $producto)
                                    {
                                        $_id = $producto['id'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $descuento = $producto['descuento'];
                                        $cantidad = $producto['cantidad'];
                                        $precio_desc = $precio - (($precio * $descuento) / 100);
                                        $subtotal = $cantidad * $precio_desc;
                                        $total += $subtotal;

                                        $item = new MercadoPago\Item();
                                        $item->id = $_id;
                                        $item->title = $nombre;
                                        $item->quantity = $cantidad;
                                        $item->unit_price = $precio_desc;
                                        $item->currency = "ARS";
                                        
                                        array_push($productos_mp, $item);
                                        unset($item);
                                    ?>
                                    <tr>
                                        <td> <?php echo $nombre; ?></td>
                                        <td> 
                                            <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"> <?php echo MONEDA . 
                                            number_format($subtotal, 2, '.', ','); ?></div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">
                                        <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, '.', ','); ?></p>
                                    </td>
                                </tr>
                            </tbody> 
                        <?php } ?>
                    </table>
                </div>
            </div> 
        </div>
        </main>

        
        <?php 
            //TODO: atenti con todo ese bloque 
            //$preference->items = $productos_mp;
            // Salidas de captura fallo y exito
            $preference->back_urls = array(
                "success"=> "https://semillares.com.ar/clases/captura.php",
                "failure"=> "https://semillares.com.ar/clases/fallo.php"
            );

            // Los compradores vuelven a mi sitio tras terminar con exito la compra
                $preference->auto_return = "approved";
            // redirecciona después de 5 segundos
                $preference->auto_return_after = 5; 
            // el pago solo puede ser aprobado o rechazado (instantaneo)
                $preference->binary_mode = true; 
            // Guardar preferencia
            $preference->save();
        ?>

        <script>
            // Llamar a la función para inicializar Mercado Pago
            initializeMercadoPago('TEST-37621760-87a1-41e5-86c6-0956594e0489', '<?php echo $preference->id; ?>');
        </script>

</body>
</html>
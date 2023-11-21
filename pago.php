<?php
    require 'config/config.php';
    require 'config/database.php';

    // SDK Mercado Pago
    require __DIR__ .  '/vendor/autoload.php'; 

    // Configurar SDK
    MercadoPago\SDK::setAccessToken(TOKEN_MP);  

    // Crear preferencia
    $preference = new MercadoPago\Preference();

    // Agregar item al carrito
    $item = new MercadoPago\Item();
    $item->title = 'Mi Producto';
    $item->quantity = 1;
    $item->unit_price = 150; 
    $item->currency = "ARS";

    $preference->items = array($item);
    // Guardar preferencia
    $preference->save();

?>

<!DOCTYPE html>
<html lang="es-AR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semillares - Checkout Mercado Pago</title>
  <title>Semillares </title>
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
  <!-- SDK Mercado Pago -->
  <script src="https://sdk.mercadopago.com/js/v2"></script>

</head>
<body>
  

      <!-- Contenido -->
      <main>
        <div class="container">

        <div class="row">
            <div class="col-6">
                <h4>Detalles de pago</h4>
                <div class="row">
                    <div class= "col-12">
                        <div id="paypal-button-container">Boton Paypal</div>
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

    <!-- MOVER a otro script -->
    <script>
        // Inicializar Mercado Pago
        const mp = new MercadoPago('TEST-37621760-87a1-41e5-86c6-0956594e0489', {
                    locale: 'es-AR'
        });

        // Abrir checkout
        mp.checkout({
        preference: {
            id: '<?php echo $preference->id; ?>'
        },
        render: {
            container: '.cho-container', // Class container
            label: 'Pagar con MP', // Botón de pago
        }
        });
    </script>

</body>
</html>
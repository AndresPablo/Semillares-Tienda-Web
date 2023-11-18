<?php
 require 'config/config.php';
 require 'vendor/autoload.php';
 MercadoPago\SDK::setAccessToken("TEST-2201111208646800-111318-a4f836fb220b257ac19c45656d760d73-521156782");
 $preference = new MercadoPago\Preference();
 $item = new MercadoPago\Item();
 $item->id = '0001';
 $item->title = 'Producto CDP';
 $item->quantity = 1;
 $item->unit_price = 150.00;
 $item->currency = "ARS";
 $preference->items = array($item);

 $preference->back_urls = array($item);

$preference->back_urls = array(
    "success" => "http://semillares.com.ar/captura.php",
    "failure" => "http://semillares.com.ar/fallo.php"
);

 $preference->auto_return = "approved";
 $preference->binary_mode = true;

 $preference->save();
?>

<!DOCTYPE html>
<html lang="es-AR">

<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="Andrés Pablo" />
        <title>Semillares - Tienda</title>
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
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://sdk.mercadopago.com/js/v2"></script>
    </head>

    <body>
        <h3> Mercado Pago </h3>
        <div class="checkout-btn"></div>

        <script>
            // Clave publica
            const mp = new MercadoPago('TEST-37621760-87a1-41e5-86c6-0956594e0489', {
                locale: 'es-MX'
            });

            mp.checkout({
                preference:{
                    id: '<?php echo $preference->id; ?> '
                },
                render: {
                    container: '.checkout-btn',
                    label: 'Pagar con MP'
                }
            });
        </script>
    </body>



</html>
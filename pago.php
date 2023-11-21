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
$preference->items = array($item);

// Guardar preferencia
$preference->save();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout Mercado Pago</title>

  <!-- SDK Mercado Pago -->
  <script src="https://sdk.mercadopago.com/js/v2"></script>

</head>
<body>
  
  <div class="cho-container"></div>

  <script>
    // Inicializar Mercado Pago
    const mp = new MercadoPago('TEST-37621760-87a1-41e5-86c6-0956594e0489');

    // Abrir checkout
    mp.checkout({
      preference: {
        id: '<?php echo $preference->id; ?>'
      },
      render: {
        container: '.cho-container', // Class container
        label: 'Pagar', // Botón de pago
      }
    });
  </script>

</body>
</html>
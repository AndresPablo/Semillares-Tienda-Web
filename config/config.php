<?php

define("TOKEN_MP", "TEST-2201111208646800-111318-a4f836fb220b257ac19c45656d760d73-521156782");
define("PUBLIC_KEY_MP", "TEST-37621760-87a1-41e5-86c6-0956594e0489");
define("KEY_TOKEN", "ABC.12345-000*");
define("MONEDA", "$");

session_start();

$num_cart = 0; 
if(isset($_SESSION['carrito']['productos'])) {
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>
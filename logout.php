<?php 

require 'config/config.php';

// Borra las variables del cleinte, no del carrito
unset($_SESSION['user_id']);       
unset($_SESSION['user_name']);       
unset($_SESSION['user_cliente']);       
//session_destroy();



// Redirige al indice
header("Location: index.php");
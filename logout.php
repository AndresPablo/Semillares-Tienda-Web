<?php 

require 'config/config.php';

// Borra las variables del cleinte, no del carrito
unset($_SESSION['user_id']);       
unset($_SESSION['user_name']);       
unset($_SESSION['user_cliente']);       
unset($_SESSION['user_mail']);       
//session_destroy();

// Redirige al indice
header("Location: index.php");
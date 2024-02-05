<?php

require 'config/config.php';
require 'config/database.php';
require 'config/clienteFunciones.php';

$db = new Database();
$con = $db->conectar();

print_r($_SESSION);
$idCliente = $_SESSION['user_cliente'];

$sqlProd = $con->prepare("SELECT id_transaccion, fecha, status, total FROM compra WHERE id_cliente=? ORDER BY DATE(fecha) DESC");
$sqlProd->execute([$idCliente]);

?>
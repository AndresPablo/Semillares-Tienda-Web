<?php

require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = file_get_contents($json, true);

$payment = $_GET['payment_id'];
$status = $_GET['status'];
$payment_type = $_GET['payment_type'];
$order_id = $_GET['merchant_order_id'];

echo "<h3> Pago exitoso! </h3>";
echo $payment.'<br>';
echo $status.'<br>';
echo $payment_type.'<br>';
echo $order_id.'<br>';

unset($_SESSION['carrito']);

if(is_array($datos)){

    //$sql = $con->prepare("INSERT INTO compra ()");
    //$sql->execute();
    $id = $con->lastInsertId();
    // 
    // timestamp
    // https://youtu.be/fRYErum_xkY?list=PL-Mlm_HYjCo-Odv5-wo3CCJ4nv0fNyl9b&t=1527
}
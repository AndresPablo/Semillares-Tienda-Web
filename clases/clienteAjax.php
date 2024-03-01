<?php

require_once '../config/database.php';
require_once 'clienteFunciones.php';

$datos = [];

if(isset($_POST['action']))
{
    $action = $_POST['action'];

    if($action == 'existeUsuario')
    {
        $db = new Database();
        $con = $db->conectar();    
        usuarioExiste($_POST['usuario'], $con);
    }
}

echo json_enconde($datos);
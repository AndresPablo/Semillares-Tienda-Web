<?php
    require 'config/database.php';
    $db=new Database();
    $con=$db->conectar();
    
    $sql=$con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
    $sql->execute();
    $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE php>
<html lang="es-AR">


</html>
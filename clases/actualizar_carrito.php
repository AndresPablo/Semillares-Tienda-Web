<?php

require '../config/config.php';
require '../config/database.php';

if(isset($_POST['action']))
{
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if($action == 'agregar')
    {
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($id, $cantidad);
        if($respuesta>0)
        {
            // devuelve
            $datos['ok'] = true;
        }else {
            $datos['ok'] = false;
        }
        $datos['sub'] = MONEDA . number_format($respuesta, 2, '.', ',');
    }else if($action == 'eliminar') {
        $datos['ok'] = eliminar($id);
    } else {
        $datos['ok'] = false;
    }
}else
{
    $datos['ok'] = false;
}

echo json_encode($datos);

function agregar($id, $cantidad)
{
    $res = 0;
    if($id > 0 && $cantidad > 0 && is_numeric(($cantidad)))
    {
        if(isset($_SESSION['carrito']['productos'][$id]))
        {
            $_SESSION['carrito']['productos'][$id] = $cantidad;
            $db = new Database();
            $con = $db->conectar();
            $sql = $con->prepare("SELECT precio, descuento FROM productos WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            $res = $cantidad * $precio_desc;
                // Inicializar el total de la sesión si no existe
                if (!isset($_SESSION['carrito']['total'])) {
                    $_SESSION['carrito']['total'] = 0;
                }
    
                // Actualizar el total de la sesión
                $_SESSION['carrito']['total'] += $res;
            return $res;
        }
    }else {
        return $res;
    }
}

function eliminar($id)
{
    if($id > 0)
    {
        if(isset($_SESSION['carrito']['productos'][$id]))
        {
            // Elimina el producto del carrito
            unset ($_SESSION['carrito']['productos'][$id]);
            
            // Obtener el precio y descuento del producto eliminado
            $db = new Database();
            $con = $db->conectar();
            $sql = $con->prepare("SELECT precio, descuento FROM productos WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
            // Restar el valor del producto eliminado al total del carrito
            if (isset($_SESSION['carrito']['total'])) {
                $_SESSION['carrito']['total'] -= $precio_desc;
            }
            return true;
        }else
        {
            return false;
        }
    }
}

?>
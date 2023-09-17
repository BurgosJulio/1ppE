<?php

session_start();

require '../config/config.php';
require '../config/database.php';

$datos = array();

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    if ($action == 'agregar') {
        $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
        $respuesta = agregar($id, $cantidad);
        if ($respuesta > 0) {
            $datos['ok'] = true;
        } else {
            $datos['ok'] = false;
        }

        $datos['sub'] = MONEDA . number_format($respuesta, 2, '.', ',');
    } else {
        $datos['ok'] = false;
    }
} else {
    $datos['ok'] = false;
}
echo json_encode($datos);

function agregar($id, $cantidad)
{
    $res = 0;
    if ($id > 0 && $cantidad > 0 && is_numeric($cantidad)) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array('productos' => array(), 'subtotal' => array());
        }

        $_SESSION['carrito']['productos'][$id] = $cantidad;

        $db = new Database();
        $con = $db->conectar();

        $sql = "SELECT precio, descuento FROM productos WHERE id=? AND activo = 1 LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - ($precio * $descuento) / 100;

            // Recalcula el subtotal del producto en base a la nueva cantidad
            $subtotal = $cantidad * $precio_desc;

            // Actualiza el subtotal en el carrito
            $_SESSION['carrito']['subtotal'][$id] = $subtotal;

            // Calcula el total sumando todos los subtotales
            $total = array_sum($_SESSION['carrito']['subtotal']);

            return $total;
        }
    }
    return $res;
}

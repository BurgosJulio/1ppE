<?php

define("CLIENT_ID","jabc.WQC-*AC");//HAY QUE AGREGAR EL ID QUE NOS DA PAYPAL,SON MUCHOS NUMEROS Y LETRAS
define("CURRENCY","USD");
define("KEY_TOKEN","jabc.WQC-*AC");
define("MONEDA","$");

session_start();
$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])) {
    $num_cart = count($_SESSION['carrito']['productos']);
}


?>
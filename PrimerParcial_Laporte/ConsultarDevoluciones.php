<?php
/* ConsultasDevoluciones.php:
a- Listar las devoluciones con cupones.
b- Listar solo los cupones y su estado.
c- Listar devoluciones y sus cupones y si fueron usados */

include_once "Clases\\CuponDeDescuento.php";
include_once "Clases\\Devolucion.php";

$_arrayDevoluciones = LeerDatosJSON("devoluciones.json");
$_arrayCupones = LeerDatosJSON("cupones.json");
$_arrayCuponesUsados = array();

foreach($_arrayCupones as $cupon){
    if (!strcasecmp($cupon->_estado, "usado"))
        array_push($_arrayCuponesUsados, $cupon);
}

if(!empty($_arrayDevoluciones)){
    echo "a- Lista de devoluciones con cupones:\n";
    foreach ($_arrayDevoluciones as $devolucion) {
        echo MostrarDevolucion($devolucion) . "\n";
    }
}else{
    echo "a- No hay ninguna devolución.\n";
}

if(!empty($_arrayCupones)){
    echo "b- Lista de cupones:\n";
    foreach ($_arrayCupones as $cupon) {
        echo MostrarCupon($cupon) . "\n";
    }
}else{
    echo "b- No hay ningún cupón.\n";
}

if(!empty($_arrayCuponesUsados)){
    echo "c- Lista de cupones usados:\n";
    foreach ($_arrayCuponesUsados as $cuponUsado) {
        echo MostrarCupon($cuponUsado) . "\n";
    }
}else{
    echo "c- No hay ningún cupón usado.\n";
}

function MostrarDevolucion($devolucion)
{
    return "Devolución N°$devolucion->_id del pedido N°$devolucion->_numeroDePedido, por \"$devolucion->_causa\". Otorgamos el cupón N°$devolucion->_idCupon.\n";
}

function MostrarCupon($cupon)
{
    return "Cupón N°$cupon->_id por un $cupon->_porcentajeDescuento% de descuento.\nNotas: \"$cupon->_causa\" Estado: $cupon->_estado\n";
}

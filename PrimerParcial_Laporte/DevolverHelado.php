<?php
/* 6-
Guardar en el archivo (devoluciones.json y cupones.json):
a- Se ingresa el número de pedido y la causa de la devolución. El número de pedido debe existir, se ingresa una
foto del cliente enojado,esto debe generar un cupón de descuento(id, devolucion_id, porcentajeDescuento,
estado[usado/no usadol]) con el 10% de descuento para la próxima compra.

Laporte Marcos*/

include_once "Venta.php";
include_once "CuponDeDescuento.php";
include_once "Devolucion.php";

$_arrayVentas = LeerDatosJSON("ventas.json");
$_arrayCupones = LeerDatosJSON("cupones.json");
$_arrayDevoluciones = LeerDatosJSON("devoluciones.json");

$_numeroPedido = $_POST['numeroDePedido'];
$indexVenta = Venta::BuscarVenta($_arrayVentas, $_numeroPedido);
$indexDevolucion = Devolucion::BuscarDevolucion($_arrayDevoluciones, $_numeroPedido);

if ($indexVenta != -1) {
    if ($indexDevolucion == -1) {
        CuponDeDescuento::GuardarImagenClienteEnojado($_arrayVentas[$indexVenta]);

        $cupon = new CuponDeDescuento($_POST['causa']);
        array_push($_arrayCupones, $cupon);
        GuardarDatosJSON($_arrayCupones, "cupones.json");

        $devolucion = new Devolucion($cupon->_causa, $_numeroPedido, $cupon->_id);
        array_push($_arrayDevoluciones, $devolucion);
        GuardarDatosJSON($_arrayDevoluciones, "devoluciones.json");

        echo "Queja anotada! Tome un cupón de descuento para su próxima compra:\n";
        echo "---------------------------------\n";
        echo $cupon->MostrarCupon();
        echo "---------------------------------\n";
    } else {
        echo "Ya se realizó una devolución por esta venta!\n";
    }
} else {
    echo "No nos quiera cagar! Ese pedido no existe!\n";
}

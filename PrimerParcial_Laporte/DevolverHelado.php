<?php
/* 6-
Guardar en el archivo (devoluciones.json y cupones.json):
a- Se ingresa el número de pedido y la causa de la devolución. El número de pedido debe existir, se ingresa una
foto del cliente enojado,esto debe generar un cupón de descuento(id, devolucion_id, porcentajeDescuento,
estado[usado/no usadol]) con el 10% de descuento para la próxima compra.

Laporte Marcos*/

include_once "Clases\\Venta.php";
include_once "Clases\\CuponDeDescuento.php";
include_once "Clases\\Devolucion.php";

$_arrayVentas = LeerDatosJSON("ventas.json");
$_arrayCupones = LeerDatosJSON("cupones.json");
$_arrayDevoluciones = LeerDatosJSON("devoluciones.json");

$numPedido = empty($datos['numeroDePedido']) ? 0 : $datos['numeroDePedido'];
$indexVenta = Venta::BuscarVenta($_arrayVentas, $numPedido);
$indexDevolucion = Devolucion::BuscarDevolucion($_arrayDevoluciones, $numPedido);

if ($indexVenta != -1) {
    if ($indexDevolucion == -1) {
        echo CuponDeDescuento::GuardarImagenClienteEnojado($_arrayVentas[$indexVenta]) ? "La imagen fue guardada con éxito!\n" : "La imagen no pudo guardarse.\n";

        $cupon = new CuponDeDescuento($_POST['causa']);
        array_push($_arrayCupones, $cupon);
        GuardarDatosJSON($_arrayCupones, "cupones.json");

        $devolucion = new Devolucion($cupon->_causa, $numPedido, $cupon->_id);
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
    echo "No existe una venta activa con número de pedido N°$numPedido.\n";
    echo "Los disponibles son:\n";
    foreach ($arrayVentas as $venta) {
        if($venta->_activo)
            echo '~ ' . $venta->_numeroPedido . "\n";
    }
}

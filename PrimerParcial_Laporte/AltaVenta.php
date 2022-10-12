<?php
/* AltaVenta.php: (por POST) se recibe el email del usuario y el Sabor, Tipo y Stock, si el ítem existe en
heladeria.json, y hay stock guardar en la base de datos( con la fecha, número de pedido y id autoincremental ) .
Se debe descontar la stock vendida del sto

Laporte Marcos*/

include_once "Helado.php";
include_once "Venta.php";

$_arrayVentas = LeerDatosJSON("ventas.json");
$_arrayVentas = AddVenta(LeerDatosJSON("heladeria.json"), $_arrayVentas);
GuardarDatosJSON($_arrayVentas, "ventas.json");


function AddVenta(array $arrayHelados, array $arrayVentas){
    $heladoPedido = new Helado($_POST['sabor'], 0, $_POST['tipo'], $_POST['stock']);
    $auxHelados = $arrayHelados;
    $auxVentas = $arrayVentas;
    $indexHelado = Helado::BuscarHelado($auxHelados, $heladoPedido);

    if($indexHelado != -1){
        if($auxHelados[$indexHelado]->_stock > 0){
            if($auxHelados[$indexHelado]->_stock - $_POST['stock'] > 0){
                $stock = $heladoPedido->_stock;
            }else{
                $stock = $auxHelados[$indexHelado]->_stock;
                echo "Tan solo tenemos " . $auxHelados[$indexHelado]->_stock . "unidades de esa helado\n";
            }
            $venta = new Venta($_POST['mail'], $heladoPedido->_sabor, $heladoPedido->_tipo, $stock, $_POST['fechaPedido']);
            array_push($auxVentas, $venta);
            $auxHelados[$indexHelado]->_stock -= $stock;
            GuardarDatosJSON($auxHelados, "heladeria.json");
            echo "Se realizó el pedido!\n";
            $venta->GuardarImagenVenta();
        }else{
            echo "No hay suficiente stock para realizar el pedido.\n";
        }
    }else{
        echo "No existe tal helado.\n";
    }
    
    return $auxVentas;
}

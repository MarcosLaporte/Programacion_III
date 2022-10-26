<?php
/* AltaVenta.php: (por POST) se recibe el email del usuario y el Sabor, Tipo y Stock, si el ítem existe en
heladeria.json, y hay stock guardar en la base de datos( con la fecha, número de pedido y id autoincremental ) .
Se debe descontar la stock vendida del stock

Laporte Marcos*/

include_once "Clases\\Helado.php";
include_once "Clases\\Venta.php";

$_arrayVentas = LeerDatosJSON("ventas.json");
$_arrayVentas = AddVenta(LeerDatosJSON("heladeria.json"), $_arrayVentas);
GuardarDatosJSON($_arrayVentas, "ventas.json");


function AddVenta(array $arrayHelados, array $arrayVentas){
    $heladoPedido = new Helado($_POST['sabor'], 0, $_POST['tipo'], $_POST['cantidad']);
    $auxHelados = $arrayHelados;
    $auxVentas = $arrayVentas;
    $indexHelado = Helado::BuscarHelado($auxHelados, $heladoPedido);
    $nuevoStock = 0;

    if($indexHelado != -1){
        if($auxHelados[$indexHelado]->_stock > 0){
            if($auxHelados[$indexHelado]->_stock - $_POST['cantidad'] > 0){
                $nuevoStock = $heladoPedido->_stock;
            }else{
                $nuevoStock = $auxHelados[$indexHelado]->_stock;
                echo "Cargaremos solo " . $auxHelados[$indexHelado]->_stock . " unidades, ya que es lo que tenemos de ese helado.\n";
            }
            $venta = new Venta($_POST['mail'], $heladoPedido->_sabor, $heladoPedido->_tipo, $nuevoStock, $_POST['fechaPedido']);
            array_push($auxVentas, $venta);
            $auxHelados[$indexHelado]->_stock -= $nuevoStock;
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

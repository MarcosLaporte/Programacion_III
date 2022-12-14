<?php
/*3A- Laporte Marcos */

include_once "Venta.php";
include_once "Pizza.php";

/* AltaVenta.php: (por POST)se recibe el email del usuario y el sabor,tipo y cantidad. */

$arrayVentas = LeerDatosJSON("Ventas.json");
$arrayVentas = AddVenta(LeerDatosJSON("Pizza.json"), $arrayVentas);
GuardarDatosJSON($arrayVentas, "Ventas.json");

/* Si el ítem existe en Pizza.json y hay stock, guardar en el archivo (con la fecha, número de pedido y id autoincremental) */

function AddVenta(array $arrayPizzas, array $arrayVentas){
    $pizzaPedido = new Pizza($_POST['sabor'], 0, $_POST['tipo'], $_POST['cantidad']);
    $auxPizzas = $arrayPizzas;
    $auxVentas = $arrayVentas;
    $indexPizza = Pizza::BuscarPizza($auxPizzas, $pizzaPedido);

    if($indexPizza != -1){
        if($auxPizzas[$indexPizza]->_cantidad > 0){
            if($auxPizzas[$indexPizza]->_cantidad - $_POST['cantidad'] > 0){
                $cantidad = $pizzaPedido->_cantidad;
            }else{
                $cantidad = $auxPizzas[$indexPizza]->_cantidad;
                echo "Tan solo tenemos " . $auxPizzas[$indexPizza]->_cantidad . "unidades de esa pizza\n";
            }
            $venta = new Venta($_POST['mail'], $pizzaPedido->_sabor, $pizzaPedido->_tipo, $cantidad, $_POST['fechaPedido']);
            array_push($auxVentas, $venta);
            /* y se debe descontar la cantidad vendida del stock.*/
            $auxPizzas[$indexPizza]->_cantidad -= $cantidad;
            GuardarDatosJSON($auxPizzas, "Pizza.json");
            echo "Se realizó el pedido!\n";
            $venta->GuardarImagenVenta();
        }else{
            echo "No hay suficiente stock para realizar el pedido.\n";
        }
    }else{
        echo "No existe tal pizza.\n";
    }
    
    return $auxVentas;
}


?>
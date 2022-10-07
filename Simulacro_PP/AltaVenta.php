<?php
/*3A- Laporte Marcos */

include_once "Venta.php";

/* AltaVenta.php: (por POST)se recibe el email del usuario y el sabor,tipo y cantidad. */

$arrayVentas = LeerDatos("Ventas.json");
$arrayVentas = AddVenta(LeerDatos("Pizza.json"), $arrayVentas);
GuardarDatos($arrayVentas, "Ventas.json");

/* Si el ítem existe en Pizza.json y hay stock, guardar en el archivo (con la fecha, número de pedido y id autoincremental) */

function AddVenta(array $arrayPizzas, array $arrayVentas){
    $pizzaPedido = new Pizza($_POST['sabor'], 0, $_POST['tipo'], $_POST['cantidad']);
    $auxPizzas = $arrayPizzas;
    $auxVentas = $arrayVentas;
    $indexPizza = Pizza::BuscarPizza($auxPizzas, $pizzaPedido);

    if($indexPizza != -1){
        if($auxPizzas[$indexPizza]->_cantidad > 0){
            $venta = new Venta($_POST['mail'], $pizzaPedido->_sabor, $pizzaPedido->_tipo, $pizzaPedido->_cantidad, $_POST['fechaPedido']);
            array_push($auxVentas, $venta);
            /* y se debe descontar la cantidad vendida del stock.*/
            $auxPizzas[$indexPizza]->_cantidad -= $_POST['cantidad'];
            GuardarDatos($auxPizzas, "Pizza.json");
            echo "Se realizó el pedido!\n";
        }else{
            echo "No hay suficiente stock para realizar el pedido.\n";
        }
    }else{
        echo "No existe tal pizza.\n";
    }
    
    return $auxVentas;
}


?>
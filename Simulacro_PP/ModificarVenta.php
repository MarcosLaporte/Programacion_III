<?php
/* 6- ModificarVenta.php(por PUT), debe recibir el número de pedido, el email del usuario, el sabor,tipo y
cantidad, si existe se modifica , de lo contrario informar.

Laporte Marcos */

include_once "Venta.php";
include_once "Pizza.php";

$arrayVentas = ModVenta(LeerDatosJSON("Ventas.json"), LeerDatosJSON("Pizza.json"));
GuardarDatosJSON($arrayVentas, "Ventas.json");


function ModVenta(array $arrayVentas, array $arrayPizzas){
    parse_str(file_get_contents("php://input"), $datos);
    $auxVentas = $arrayVentas;
    $auxPizzas = $arrayPizzas;
    
    $indexVenta = Venta::BuscarVenta($arrayVentas, $datos['numeroDePedido']);
    if($indexVenta != -1){
        $fotoNombreViejo = getcwd().'\\ImagenesDeLaVenta\\'.$auxVentas[$indexVenta]->_tipoPizza.'_'.$auxVentas[$indexVenta]->_saborPizza.'_'.explode("@", $auxVentas[$indexVenta]->_mailUsuario)[0].'_'.$auxVentas[$indexVenta]->_fechaPedido.'.jpg';
        $auxVentas[$indexVenta]->_mailUsuario = ModMail($auxVentas[$indexVenta], $datos['mail']);
        
        //Verifico que el sabor y el tipo ingresado existan
        if(!empty($datos['sabor']) && !empty($datos['tipo'])){
            $auxPizza = new Pizza($datos['sabor'], 0, $datos['tipo'], 0);
        }else{
            $auxPizza = $auxVentas[$indexVenta];
        }
        
        $indexPizza = Pizza::BuscarPizza($auxPizzas, $auxPizza);
        
        if($indexPizza != -1){
            $fotoNombreNuevo = getcwd().'\\ImagenesDeLaVenta\\'.$datos['tipo'].'_'.$datos['sabor'].'_'.explode("@", $auxVentas[$indexVenta]->_mailUsuario)[0].'_'.$auxVentas[$indexVenta]->_fechaPedido.'.jpg';
            
            //Si el sabor y el tipo no existen, se quedan igual
            $auxVentas[$indexVenta]->_saborPizza = $datos['sabor'];
            $auxVentas[$indexVenta]->_tipoPizza = $datos['tipo'];
            
            //Verifico que la cantidad sea distinta, para no realizar cambios sin sentido.
            if($auxVentas[$indexVenta]->_cantidadPizza != $datos['cantidad']){
                //Si se modifica la cantidad, tomo las pizzas existentes y le sumo la cant de la venta original y luego le resto el nuevo valor.
                $stockActualizado = $auxPizzas[$indexPizza]->_cantidad + $auxVentas[$indexVenta]->_cantidadPizza - $datos['cantidad'];
                if($stockActualizado > 0){
                    $auxPizzas[$indexPizza]->_cantidad = $stockActualizado;
                    $auxVentas[$indexVenta]->_cantidad = $datos['cantidad'];
                    echo "La cantidad del pedido ha sido actualizada a " . $datos['cantidad'] . ".\n";
                }else{
                    echo "No alcanzan las pizzas. Seguiremos con la cantidad original.\n";
                }
            }
            GuardarDatosJSON($auxPizzas, "Pizza.json");
            echo "La venta N°" . $datos['numeroDePedido'] . " fue modificada!\n";
        }else{
            echo "No contamos con esa pizza específica.";
        }

        rename($fotoNombreViejo, $fotoNombreNuevo);

    }else{
        echo "No existe una venta con número de pedido N°" . $datos['numeroDePedido'] . ".\n";
        echo "Los disponibles son:\n";
        foreach($arrayVentas as $ventas){
            echo '~ ' . $ventas->_numeroPedido . "\n";
        }
    }

    return $auxVentas;
}

function ModMail($venta, string $mail){
    $auxMail = strtolower($mail);
    return Venta::MailValido($auxMail) ? $auxMail : $venta->_mailUsuario;
}
?>
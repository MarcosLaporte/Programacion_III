<?php
/*PizzaConsultar.php: (por POST)Se ingresa Sabor,Tipo, si coincide con algún registro del archivo Pizza.json,
retornar “Si Hay”. De lo contrario informar si no existe el tipo o el sabor.

Laporte Marcos*/

include_once "Pizza.php";

$_sabor = strtolower($_POST['sabor']);
$_tipo = strtolower($_POST['tipo']);
$str = "";

Pizza::BuscarPizza(LeerDatosJSON("Pizza.json"), new Pizza($_sabor, 1, $_tipo, 1)) != -1 ?
    $str="La pizza $_tipo de $_sabor existe en el stock.\n" : $str="No existe la pizza $_tipo de $_sabor.\n";

echo $str;


?>
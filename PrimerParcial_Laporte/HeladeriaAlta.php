<?php
/* HeladeriaAlta.php: (por POST) se ingresa Sabor, Precio, Tipo (“agua” o “crema”), Stock(unidades).
Se guardan los datos en en el archivo de texto heladeria.json, tomando un id autoincremental como
identificador(emulado) .Sí el nombre y tipo ya existen , se actualiza el precio y se suma al stock existente.
completar el alta con imagen del helado, guardando la imagen con el sabor y tipo como identificación en la
carpeta /ImagenesDeHelados

Laporte Marcos*/

include_once "Helado.php";

$_arrayHelados = LeerDatosJSON("heladeria.json");
$_arrayHelados = AddHelado($_arrayHelados);
GuardarDatosJSON($_arrayHelados, "heladeria.json");


function AddHelado(array $arrayHelados){
    $helado = new Helado($_POST['sabor'], $_POST['precio'], $_POST['tipo'], $_POST['stock']);
    $auxArray = $arrayHelados;
    $indexHelado = Helado::BuscarHelado($arrayHelados, $helado);
    if($indexHelado != -1){
        $heladoEncontrado = $auxArray[$indexHelado];
        $heladoEncontrado->_precio = $helado->_precio;
        $heladoEncontrado->_stock += $helado->_stock;
        echo "Se actualizó el stock!:\n";
        echo $heladoEncontrado->_stock . ' helado/s sabor ' . $heladoEncontrado->_sabor . ' tipo ' . $auxArray[$indexHelado]->_tipo . ' por $' . $auxArray[$indexHelado]->_precio . "\n";
    }else{
        array_push($auxArray, $helado);
        echo "Se agregó una helado!:\n";
        echo $helado->_stock . ' helado/s sabor ' . $helado->_sabor . ' de ' . $helado->_tipo . ' por $' . $helado->_precio . "\n";
        $helado->GuardarImagenHelado();
    }

    return $auxArray;
}


?>
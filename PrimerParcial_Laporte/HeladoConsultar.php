<?php

/* HeladoConsultar.php: (por POST) Se ingresa Sabor y Tipo, si coincide con algún registro del archivo
heladeria.json, retornar “existe”. De lo contrario informar si no existe el tipo o el nombre

Laporte Marcos*/

include_once "Clases\\Helado.php";

$_sabor = $_POST['sabor'];
$_tipo = $_POST['tipo'];
$str = "";

$_arrayHelados = LeerDatosJSON("heladeria.json");
if (!empty(trim($_sabor)) && !empty(trim($_tipo))) {
        if (Helado::BuscarHelado($_arrayHelados, new Helado($_sabor, 1, $_tipo, 1)) != -1) {
                $str = "El helado de $_sabor de $_tipo existe\n";
        } else {
                $str = "No existe el helado de $_sabor de $_tipo.\n";
        }
} else {
        echo "Revise los datos ingresados!\n";
}

echo $str;

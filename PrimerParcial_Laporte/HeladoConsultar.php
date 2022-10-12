<?php

/* HeladoConsultar.php: (por POST) Se ingresa Sabor y Tipo, si coincide con algún registro del archivo
heladeria.json, retornar “existe”. De lo contrario informar si no existe el tipo o el nombre

Laporte Marcos*/

include_once "Helado.php";

$_sabor = strtolower($_POST['sabor']);
$_tipo = strtolower($_POST['tipo']);
$str = "";

Helado::BuscarHelado(LeerDatosJSON("heladeria.json"), new Helado($_sabor, 1, $_tipo, 1)) != -1 ?
        $str="existe\n" : $str="No existe el helado de $_sabor de $_tipo.\n";

echo $str;
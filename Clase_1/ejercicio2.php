<?php
/*
Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del año es. Utilizar una estructura selectiva múltiple.

Ejercicio 2

Laporte Marcos
*/

$dd = date("d");
$MM = date("m");
$aa = date("Y");
$fecha_ddMMaa = "$dd/$MM/$aa";

$DD = date("D");
$AA = date("y");
$fecha_DDMMAA = "$DD/$MM/$AA";
$estacion = "";

$dia_int = intval($dd);
$mes_int = intval($MM);

switch ($mes_int){
    case 1:
    case 2:
        $estacion = "Verano";
        break;
    case 3:
        if($dia_int < 21)
            $estacion = "Verano";
        else
            $estacion = "Otoño";
        break;
    case 4:
    case 5:
        $estacion = "Otoño";
        break;
    case 6:
        if($dia_int < 21)
            $estacion = "Otoño";
        else
            $estacion = "Invierno";
        break;
        case 7:
    case 8:
        $estacion = "Invierno";
        break;
    case 9:
        if($dia_int < 21)
            $estacion = "Invierno";
        else
            $estacion = "Primavera";
            break;
    case 10:
    case 11:
        $estacion = "Primavera";
        break;
    case 12:
        if($dia_int < 21)
            $estacion = "Primavera";
        else
            $estacion = "Verano";
    break;
}

echo "Hoy es $fecha_ddMMaa  -  $fecha_DDMMAA.<br>";
echo "Y estamos en $estacion.";


?>
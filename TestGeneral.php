<?php

/* if(!strcmp("hola", "hola")){
    echo "Se puede negar el strcmp para verificar si retorna 0.\n";
} */
############################################################################

// echo !strcmp('hola', 'hola') && !strcmp('chau', 'chau');
############################################################################

/* $dt = new DateTime('now');
$aux = $dt > new DateTime('08/05/2003') ? 'true' : 'false';
echo $aux; */
############################################################################

/* $auxMail = 'a@@@@.@';
$str = strpos($auxMail, '@') && strpos($auxMail, '.') ? $auxMail : 'michelangelo@tmnt.com';
echo $str; */
############################################################################

/* function MailValido(string $mail){
    $arrobaCont = 0;
    $puntoCont = 0;
    $letraCont = 0;

    for($i = 0; $i < strlen($mail); $i++){
        if($mail[$i] == '@'){
            $arrobaCont++;
            if($arrobaCont > 1) return false;
        }else if($mail[$i] == '.'){
            $puntoCont++;
            if($puntoCont > 1) return false;
        }else if(ctype_alnum($mail[$i])){
            $letraCont++;
        }
    }
    return ($arrobaCont == 1 && $puntoCont == 1 && $letraCont >= 3);
                                                //Al menos 3 letras (a@a.a)
}

echo MailValido('felipe@gmail.com') ? "true<br>" : "false<br>";
echo MailValido('f@g.c') ? "true<br>" : "false<br>";
echo MailValido('@.cm') ? "true<br>" : "false<br>";
echo MailValido('') ? "true<br>" : "false<br>";
echo MailValido('@.') ? "true<br>" : "false<br>"; */
############################################################################

/* $fecha = new DateTime($_POST['fecha']);
echo $fecha->format('d/m/Y'); */
############################################################################

/* $fecha = DateTime::createFromFormat('d/m/Y', null) ?  : new DateTime('now');
echo $fecha->format('d/m/Y'); */
############################################################################

/* $fecha1 = new DateTime('now');
$fecha2 = new DateTime('now');
$fecha3 = new DateTime('now');
var_dump($fecha1);
echo "<br>";
var_dump($fecha2);
echo "<br>";
var_dump($fecha3);
echo "<br>"; */
############################################################################

/* // var_dump(new DateTime('today')>=new DateTime('today') && new DateTime('today')<=new DateTime('today'));
var_dump(date_add(new DateTime('today'), date_interval_create_from_date_string("1 day")));
// var_dump(date_add(new DateTime('today'), '1 day')); //No funciona
// var_dump(new DateTime('today')); */
############################################################################

/* // is_dir('files_class/MiCarpeta') ? : mkdir('files_class/MiCarpeta');
echo getcwd(); //C:\xampp\htdocs\Programacion_III
echo __FILE__; //C:\xampp\htdocs\Programacion_III\TestGeneral.php
echo dirname(__FILE__); //C:\xampp\htdocs\Programacion_III */
############################################################################

/* is_dir(getcwd() . '/MisImagenes') ?: mkdir(getcwd() . '/MisImagenes');
$archivo = 'archivo';
$destino = "MisImagenes/" . $archivo . ".jpg";
$tmpName = $_FILES["imagen"]["tmp_name"];

if (move_uploaded_file($tmpName, $destino)) {
    echo "La foto se guardó correctamente.\n";
} else {
    echo "La foto no pudo guardarse.\n";
} */
############################################################################

/* // var_dump(json_decode(file_get_contents("php://input"), true)); //Retorna NULL
parse_str(file_get_contents("php://input"), $datos);
// var_dump($datos);
echo $datos['numero'] . "\n";
echo $datos['letra']; */
############################################################################

?>
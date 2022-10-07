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

$fecha = DateTime::createFromFormat('d/m/Y', null) ?  : new DateTime('now');
echo $fecha->format('d/m/Y');
############################################################################

?>
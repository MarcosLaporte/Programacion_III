<?php

/*
Escribir un programa que use la variable $operador que pueda almacenar los símbolos
matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras $op1 y $op2. De acuerdo al
símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
resultado por pantalla.

Ejercicio 4

Laporte Marcos
*/

$operador = '*';
$op1 = 104;
$op2 = -4;

switch ($operador){
    case '+':
        echo "$op1 + $op2 = " . $op1+$op2;
        break;
    case '-':
        echo "$op1 - $op2 = " . $op1-$op2;
        break;
    case '/':
        if($op2 != 0)
            echo "$op1 / $op2 = " . $op1/$op2;
        else
            echo 'No se puede dividir por 0!';
        break;
    case '*':
        echo "$op1 * $op2 = " . $op1*$op2;
        break;
}

?>
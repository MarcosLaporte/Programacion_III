<?php
/*
Recibe los datos del usuario(nombre, clave, mail) por POST ,
crear un objeto y utilizar sus métodos para poder hacer el alta,
guardando los datos en usuarios.csv. retorna si se pudo agregar o no.
Cada usuario se agrega en un renglón diferente al anterior.
Hacer los métodos necesarios en la clase usuario

Ejercicio 20 BIS

Laporte Marcos
*/

require_once "registro.php";

$miUsuario = new Usuario($_POST['nombre'], $_POST['clave'], $_POST['mail']);

if(Usuario::AltaUsuario($miUsuario)){
    echo 'El usuario ' . $miUsuario->getNombre() . ' fue dado de alta.<br>';
}else{
    echo 'El usuario no fue dado de alta.<br>';
}

?>
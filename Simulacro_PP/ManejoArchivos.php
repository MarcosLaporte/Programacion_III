<?php

function GuardarDatos(array $datos, string $nombreArchivo){
    $refArchivo = fopen($nombreArchivo, "w+");
    if($refArchivo){
        fwrite($refArchivo, json_encode($datos));
    }
    
    return fclose($refArchivo);
}

function LeerDatos(string $nombreArchivo){
    $refArchivo = fopen($nombreArchivo, "a+");
    
    if($refArchivo){
        $textoArchivo = fgets($refArchivo);
        json_decode($textoArchivo, false) != null ? $decode = json_decode($textoArchivo, false) : $decode = array();
    }
    fclose($refArchivo);
    
    return $decode;
}

?>
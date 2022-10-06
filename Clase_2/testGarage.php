<?php
require_once "ejercicio18.php";

$garage = new Garage("La Cocherita", 175);
$autos = array(
    $_auto1 = new Auto("Ford", "Rojo", rand(100000, 1000000)),
    $_auto2 = new Auto("Chevrolet", "Negro", rand(100000, 750000)),
    $_auto3 = new Auto("Renault", "Blanco", 200000),
    $_auto4 = new Auto("Chevrolet", "Plateado", rand(100000, 750000)),
    $_auto5 = new Auto("Renault", "Blanco", 200000),
    $_auto6 = new Auto("Ferrari", "Verde", 125000000, new DateTime("05/08/03"))
);

for($i = 0; $i < count($autos); $i++){
    if($garage->Add($autos[$i])){
        echo 'El auto ' . $autos[$i]->GetMarca().' '.$autos[$i]->GetColor() . ' ha sido agregado al garage!<br>';
    }else{
        echo 'El auto ' . $autos[$i]->GetMarca().' '.$autos[$i]->GetColor() . ' ya existe en el garage!<br>';
    }
}

echo $garage->MostrarGarage();
echo '----------------------------------------------<br>';

if($garage->Remove($autos[1])){
    echo 'El auto ' . $autos[1]->GetMarca().' '.$autos[1]->GetColor() . ' fue removido.<br>';
}else{
    echo 'Ese auto no existe!<br>';
}

echo $garage->MostrarGarage();

?>
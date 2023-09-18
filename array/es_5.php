<?php

$array=[];
$nElementi=10;

for($i=0;$i<$nElementi;$i++){
    echo "inserire il"+ $i +"° numero all'interno dell'array: ";
    $array[$i]=readline();
    echo "\n";
}

$ricerca;

echo  "inserire un numero da ricercare all'interno dell'array";
$ricerca=readline();
for($i=0;$i<count($array);$i++){
    if($array[$i]==$ricerca){
        echo "il numero "+ $ricerca + "è stato trovato in posizione "+ $i;
    }
}
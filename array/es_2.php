<?php

$array=[];
$nElementi=5;

for($i=0;$i<$nElementi;$i++){
    echo "inserire il"+ $i +"° numero all'interno dell'array: ";
    $array[$i]=readline();
    echo "\n";
}

echo "\nl'array contiene i seguenti numeri: ";
for($i=count($array);$i>0;$i--){
    echo  $array[$i]+"\n";
}



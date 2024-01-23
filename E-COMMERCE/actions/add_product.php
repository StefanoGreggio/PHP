<?php

session_start();

require '../models/Classes.php';


$marca = $_POST['marca'];
$nome = $_POST['nome'];
$prezzo = $_POST['prezzo'];
$newProduct = Product::Create(['nome' => $nome, 'prezzo' => $prezzo, 'marca' => $marca]);

header("location: ../views/products/index.php");
exit();
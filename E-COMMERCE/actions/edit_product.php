<?php

require_once '../models/classes.php';

session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prodotto_id = $_POST['product_id'];
    $marca = $_POST['marca'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];

    $product = Product::Find($prodotto_id);

    $params['nome'] = $nome;
    $params['prezzo'] = $prezzo;
    $params['marca'] = $marca;

    $success = $product->update($params);

    if ($success) {
        header("location: ../views/products/index.php");
        exit();
    } else {
        echo "Si è verificato un errore durante la modifica del prodotto.";
    }
}
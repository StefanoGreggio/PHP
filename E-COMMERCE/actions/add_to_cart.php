<?php

require '../models/Classes.php';

session_start();

if(!isset($_SESSION['current_user'])){
    header("location: ../views/login.php");
    exit();
}

$user = $_SESSION['current_user'];
$cart = Cart::Find($user->GetID());

$params = [
    'product_id' => $_POST['product_id'],
    'quantita' => $_POST['quantita']
];

if (!$cart) {
    $cart->updateProduct($params);
} else {
    $cart->addProduct($params);
}

header('Location: ../views/products/index.php');
exit();
?>

<?php

require '../models/classes.php';

session_start();
$params['email'] = $_POST["email"];
$params['password'] = hash('sha256', $_POST["password"]);

$pdo = DbManager::Connect("ecommerce");

$user = User::Find_by_Credential($params);

if (!$user) {
    header('location: ../views/login.php');
    exit;
} else {
    $_SESSION['current_user'] = $user;
    $params = array('ip' => $_SERVER["REMOTE_ADDR"], 'data_login' => date('d/m/y H:i'), 'user_id' => $user->getId());
    Session::Create($params);
    header('location:../views/products/index.php');
    exit;
}

?>
<?php

require '../models/classes.php';

session_start();

$user = $_SESSION['current_user'];
$session = Session::Find($user->getId());

if ($user) {
    $_SESSION['current_user'] = null;
    $session->Delete();
    header('location: /E-COMMERCE/views/login.php');
    exit;
}
<?php

require '../models/classes.php';

session_start();

$user = $_SESSION['current_user'];


if ($user) {
    $_SESSION['current_user'] = null;
    header('location: /E-COMMERCE/views/login.php');
    exit;
}
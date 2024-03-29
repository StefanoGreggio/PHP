<?php

require '../models/classes.php';

session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['password-confirmation'];


if (strcmp($password, $password_confirmation) != 0) {
    header('Location:../views/signup.php');
    exit;
}

$password = hash('sha256', $password);

$pdo = DbManager::Connect("ecommerce");

$stmt = $pdo->prepare("select id from ecommerce.users where email=:email limit 1");
$stmt->bindParam(":email", $email);
$stmt->execute();
$user = $stmt->fetchObject("user");


if (!$user) {
    $params['email'] = $email;
    $params['password'] = $password;
    $user = User::Create($params);

    if ($user) {
        $_SESSION['current_user'] = $user;
        $params = array('ip' => $_SERVER["REMOTE_ADDR"], 'data_login' => date('d/m/y H:i'), 'user_id' => $user->getId());
        Session::Create($params);
        Cart::create($user->GetID());
        header('Location: ../views/products/index.php');
        exit();
    } else {
        header('Location:../views/signup.php');
        exit();
    }

} else {
    header('Location:../views/login.php');
    exit();
}
?>



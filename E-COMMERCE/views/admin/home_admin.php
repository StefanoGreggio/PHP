<?php

require_once '../../models/classes.php';

session_start();

$user = $_SESSION['current_user'];

if (!isset($user) || $user->getRoleId()!=2) {
    header('Location: ../errors/401.php');
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello Admin</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
<h2>Pannello Admin</h2>
<form action="products/create.php" method="POST">
    <h3>Aggiungi un prodotto</h3>
    <button type="submit">Vai a Creare Prodotto</button>
</form>

<form action="products/update.php" method="POST">
    <h3>Modifica un prodotto</h3>
    <label for="product_id">Product ID:</label>
    <input type="number" id="product_id" name="product_id" required>

    <button type="submit">Submit</button>
</form>

<a href="../products/index.php">Vai ai prodotti</a>
<?php include '../navbar.php'; ?>


</body>

</html>

<?php

require_once '../../../models/classes.php';

session_start();

$user = $_SESSION['current_user'];

if (!isset($user) || $user->getRoleId() != 2) {
    header('Location: ../../errors/401.php');
    exit();
}


if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    $product = Product::Find($product_id);

    if (!$product) {
        echo "Prodotto non trovato.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Prodotto</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 20px;
            max-width: 400px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        a {
            color: #3498db;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Modifica Prodotto</h2>


<form action="../../../actions/edit_product.php" method="POST">

    <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">

    <label for="marca">Marca:</label>
    <input type="text" name="marca" value="<?php echo $product->getMarca(); ?>" required><br>

    <label for="nome">Nome:</label>
    <input type="text" name="nome" value="<?php echo $product->getNome(); ?>" required><br>

    <label for="prezzo">Prezzo:</label>
    <input type="number" step="0.01" name="prezzo" value="<?php echo $product->getPrezzo(); ?>" required><br>

    <input type="submit" value="Modifica Prodotto">
</form>

<a href="../../products/index.php">Vai ai prodotti</a>
<?php include '../../navbar.php'; ?>

</body>
</html>
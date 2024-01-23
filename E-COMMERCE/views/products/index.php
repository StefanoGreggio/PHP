<?php

require '../../models/classes.php';

session_start();

$products = Product::fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo Prodotti</title>
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
        }

        ul {
            list-style: none;
            padding: 10px;
            margin: 10px 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        li {
            margin-bottom: 5px;
        }

        form {
            margin-top: 10px;
            text-align: center;
        }

        input {
            padding: 5px;
            margin-right: 5px;
        }

        a {
            margin: 10px 0;
            text-decoration: none;
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
<h1>Elenco Prodotti</h1>


<?php foreach ($products as $product) { ?>
    <ul>
        <li>Marca: <?php echo $product->getMarca() ?></li>
        <li>Nome: <?php echo $product->getNome() ?></li>
        <li>Prezzo: <?php echo $product->getPrezzo() ?></li>
    </ul>

    <form action="../../actions/add_to_cart.php" method="POST">
        <input type="number" name="quantita" placeholder="Quantità">
        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
        <input type="submit" value="Aggiungi al carrello">
    </form>
<?php } ?>

<?php if (isset($_SESSION["current_user"])) { ?>
    <?php $user = User::Find($_SESSION['current_user']->getId()) ?>
    <?php if ($user->getRoleId() == 2) { ?>
        <a href="../admin/home_admin.php">pagina admin</a>
    <?php } ?>
<?php } ?>

<?php include '../navbar.php'; ?>

<a href="../carts/index.php">Vai al carrello</a>
</body>

</html>
<?php

require '../../models/Classes.php';

session_start();
if(!isset($_SESSION['current_user'])){
    header("location: ../login.php");
    exit();
}

$user = $_SESSION['current_user'];
$carrello = Cart::Find($user->GetID());

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
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

        header {
            background-color: #3498db;
            padding: 10px;
            text-align: center;
            color: #fff;
        }

        nav {
            margin: 10px 0;
        }

        nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 10px;
        }

        form {
            margin-top: 10px;
        }

        input {
            padding: 5px;
            margin-right: 5px;
        }

        hr {
            border: 1px solid #ddd;
        }

        p {
            margin-top: 10px;
            color: #333;
        }
    </style>
</head>

<body>

<header>
    <h1>Carrello</h1>
</header>
<nav>
    <a href="../products/index.php">Vai ai prodotti</a>
    <?php include '../navbar.php'; ?>
</nav>

<?php if ($carrello) : ?>

    <h2>Contenuto del carrello</h2>

    <ul>
        <?php
        $productsInCart = $carrello->getProducts();
        ?>
        <?php foreach ($productsInCart as $productInCart) : ?>
            <?php if ($productInCart['quantita'] != 0) { ?>
                <?php $prodotto = Product::Find($productInCart['product_id']); ?>
                <li>Marca: <?php echo $prodotto->getMarca(); ?></li>
                <li>Nome: <?php echo $prodotto->getNome(); ?></li>
                <li>Prezzo: <?php echo $prodotto->getPrezzo(); ?></li>
                <li>Quantità: <?php echo $productInCart['quantita']; ?></li>
                <li>Totale: <?php echo $productInCart['quantita'] * $prodotto->getPrezzo(); ?></li>

                <form action="../../actions/edit_cart.php" method="POST">
                    <label for="quantita">Modifica quantità:</label>
                    <input type="number" name="quantita" value="<?php echo $productInCart['quantita']; ?>">
                    <input type="hidden" name="product_id" value="<?php echo $prodotto->getId(); ?>">
                    <input type="submit" name="update" value="Aggiorna quantità">
                </form>

                <form action="../../actions/edit_cart.php" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $prodotto->getId(); ?>">
                    <input type="hidden" name="quantita" value="0">
                    <input type="submit" name="remove" value="Rimuovi dal carrello">
                </form>

                <hr>
            <?php } ?>
        <?php endforeach; ?>
    </ul>

    <p>Totale carrello: <?php echo $carrello->getTotal(); ?></p>


<?php else : ?>
    <p>Il carrello è vuoto.</p>
<?php endif; ?>

</body>

</html>

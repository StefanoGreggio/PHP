<?php

require '../../models/Classes.php';

session_start();

$current_user = $_SESSION['current_user'];
$carrello = Cart::Find($current_user->GetID());

?>

<html>
<head>
    <title>Carrello</title>
</head>

<body>

<?php include '../navbar.php'; ?>
<a href="../products/index.php">Vai ai prodotti</a>

<?php if ($carrello) : ?>
    <h2>Contenuto del carrello</h2>

    <ul>
        <?php
        $productsInCart = $carrello->getProducts();
        ?>
        <?php foreach ($productsInCart as $productInCart) : ?>
            <?php if ($productInCart['quantita'] != 0) { ?>
                <?php $prodotto = Product::Find($productInCart['product_id']); ?>
                <li><?php echo $prodotto->getMarca(); ?></li>
                <li><?php echo $prodotto->getNome(); ?></li>
                <li><?php echo $prodotto->getPrezzo(); ?></li>
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

    <form action="../../actions/edit_cart.php" method="POST">
        <input type="number" name="quantita" value="<?php echo $carrello->getQuantita(); ?>">
        <input type="hidden" name="id" value="<?php echo $carrello->getId(); ?>">
        <input type="submit" value="submit">
    </form>

<?php else : ?>
    <p>Il carrello è vuoto.</p>
<?php endif; ?>

</body>

</html>
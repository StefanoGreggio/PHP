<?php

require '../../models/classes.php';

session_start();

$products = Product::fetchAll();
?>

<html>
<head>
    <title>Catalogo Prodotti</title>
</head>

<body>

<?php foreach ($products as $product) { ?>
    <ul>
        <li><?php echo $product->getMarca() ?></li>
        <li><?php echo $product->getNome() ?></li>
        <li><?php echo $product->getPrezzo() ?></li>
    </ul>

    <form action="../../actions/add_to_cart.php" method="POST">
        <input type="number" name="quantita" placeholder="quantita">
        <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
        <input type="submit" value="Aggiungi al carrello">
    </form>

<?php } ?>

<?php include '../navbar.php'; ?>

<a href="../carts/index.php">Vai al carrello</a>
<?php $user = User::Find($_SESSION['current_user']->getId()) ?>
<?php if($user->getRoleId()==2){?>

    <a href="../admin/products/create.php">Aggiungi un nuovo prodotto</a>
    <p></p>
    <form action="../admin/products/update.php" method="POST">
        <label for="selected_product_id">Seleziona un prodotto:</label>
        <input type="number" name="product_id">
        <input type="submit" value="Modifica Prodotto">
    </form>

<?php }?>
</body>

</html>
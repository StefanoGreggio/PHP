<?php
session_start();
require_once '../../../models/classes.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id = $_POST['product_id'];


    $product = Product::Find($product_id);

    if (!$product) {
        echo "Prodotto non trovato.";?>
        <a href="../../products/index.php">Vai ai prodotti</a>
        <?php exit();
    }


    if (isset($_POST['marca']) && isset($_POST['nome']) && isset($_POST['prezzo'])) {

        $new_params = [
            'nome' => $_POST['nome'],
            'prezzo' => $_POST['prezzo'],
            'marca' => $_POST['marca']
        ];


        $success = $product->update($new_params);

        if ($success) {
            echo "Prodotto aggiornato con successo!";
        } else {
            echo "Si è verificato un errore durante l'aggiornamento del prodotto.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Prodotto</title>
</head>
<body>

<h2>Modifica Prodotto</h2>

<form action="" method="POST">

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

</body>
</html>
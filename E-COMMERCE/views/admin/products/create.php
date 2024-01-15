<?php
session_start();

require_once '../../../models/classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca = $_POST['marca'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];

    try {
        $newProduct = Product::Create(['nome' => $nome, 'prezzo' => $prezzo, 'marca' => $marca]);

        if ($newProduct) {
            echo "Prodotto creato con successo!";
        } else {
            echo "Si è verificato un errore durante la creazione del prodotto.";
        }
    } catch (PDOException $e) {
        echo "Errore nella connessione al database: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crea Prodotto</title>
</head>
<body>

<h2>Crea un nuovo prodotto</h2>

<form action="" method="POST">
    <label for="marca">Marca:</label>
    <input type="text" name="marca" required><br>

    <label for="nome">Nome:</label>
    <input type="text" name="nome" required><br>

    <label for="prezzo">Prezzo:</label>
    <input type="number" step="0.01" name="prezzo" required><br>

    <input type="submit" value="Crea Prodotto">
</form>
<a href="../../products/index.php">Vai ai prodotti</a>
</body>
</html>
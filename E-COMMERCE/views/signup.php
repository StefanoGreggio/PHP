<?php ?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIGN UP</title>
</head>

<body>
<form action="../actions/signup.php" method="post">
    <h2>Sign Up</h2>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password-confirmation" placeholder="Conferma Password" required>
    <input type="submit" value="Invio">
</form>
</body>

</html>
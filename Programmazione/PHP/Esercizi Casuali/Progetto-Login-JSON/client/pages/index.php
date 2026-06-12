<?php
  session_start();

  if (isset($_POST['user'])) {
    header('Location: mostra.php');
  }
?>

<!DOCTYPE html>
<html lang = "en">
  <head>
    <meta charset = "UTF-8" />
    <title>Login</title>
  </head>

  <body>
    <h1>Login</h1>

    <?php if (isset($_GET['error'])): ?>
      <p>Credenziali Errate o utente non Attivo</p>
    <?php endif; ?>

    <form action = "login.php" method = "post">
      <label>Username (Nome): <input type = "text" name = "user" required></label>
      <label>Password: <input type = "text" name = "psw" required></label>
      <button type = "submit">Accedi</button>
    </form>
    <p><a href = "regista.php">Registrati</a></p>
  </body>
</html>
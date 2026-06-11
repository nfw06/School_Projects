<?php 
  declare(strict_types = 1);
  session_start();

  if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
  }

  $user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang = "en">
  <head>
    <meta charset = "UTF-8" />
    <title>Profilo</title>
  </head>

  <body>
    <h1>Benvenuto <?= $user->nome ?></h1>
    <p>ID: <?= $user->id ?></p>
    <p>Nome: <?= $user->nome ?></p>
    <p>Cognome: <?= $user->cognome ?></p>
    <p>Email: <?= $user->email ?></p>
    <p>Password: <?= $user->password ?></p>
    <p>Eta: <?= $user->eta ?></p>
    <p>attivo <?= $user->attivo ?></p>
    <p>Ruoli <?= implode(', ', $user->ruoli)?></p>

    <?php if (in_array('admin', $user->ruoli)): ?>
      <a href = "utenti.php">Visualizza Tutti gli Utenti</a>
    <?php endif; ?>

    <a href = "regista.php">Aggiungi Utente</a>
    <a href = "logout.php">Logout</a>
    
  </body>
</html>
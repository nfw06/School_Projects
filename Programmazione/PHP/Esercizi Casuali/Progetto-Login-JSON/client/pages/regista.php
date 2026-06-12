<?php
  declare(strict_types = 1);
  session_start();
  require_once __DIR__ . '/../../config.php';

  if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
  }

  $error = '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $file = file_get_contents(JSON_PATH);
    if ($file === false) {
      $error = 'Errore di Lettura del Database';
      header('Location: index.php?error=1');
      exit();
    }

    $json = json_decode($file);

    $maxID = 0;
    foreach ($json->utenti as $utente) {
      if ($utente->id > $maxID) $maxID = $utente->id;
    }


    $nuovo = new stdClass();
    $nuovo->id = $maxID + 1;
    $nuovo->nome = trim($_POST['user']);
    $nuovo->cognome = trim($_POST['cognome']);
    $nuovo->email = $_POST['email'];
    $nuovo->password = $_POST['psw'];
    $nuovo->eta = (int)$_POST['eta'];
    $nuovo->attivo = true;
    $nuovo->ruoli = ['user'];

    $json->utenti[] = $nuovo;
    $newJSON = json_encode($json, JSON_PRETTY_PRINT);
    if (file_put_contents(JSON_PATH, $newJSON) === false) {
      $error = 'Errore nel Salvataggio del Nuovo Utente';
    } else {
      header('Location: mostra.php');
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang = "en">
  <head>
    <meta charset = "UTF-8" />
    <title>Registrazione</title>
  </head>

  <body>
    <h1>Regista un Nuovo Utente</h1>

    <?php if ($error): ?>
      <p><?= $error ?></p>
    <?php endif; ?>

    <form method = "post">
      <label>Nome: <input type = "text" name = "user" required></label>
      <label>Cognome: <input type = "text" name = "cognome" required></label>
      <label>Email: <input type = "email" name = "email" required></label>
      <label>Password: <input type = "text" name = "psw" required></label>
      <label>Eta: <input type = "number" name = "eta" required></label>
      <button type = "submit">Crea</button>
      <button type = "reset">Clear</button>
    </form>
    <a href = "mostra.php">Annulla</a>
  </body>
</html>
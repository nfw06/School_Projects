<?php
  session_start();
  require_once __DIR__ . '/../../config.php';

  if (!isset($_SESSION['user']) || !in_array('admin', $_SESSION['user']->ruoli)) {
    header('Location: index.php');
    exit();
  }

  $json = json_decode(file_get_contents(JSON_PATH));
?>

<!DOCTYPE html>
<html lang = "en">
  <head>
    <meta charset = "UTF-8" />
    <title>Tutti gli Utenti</title>
  </head>

  <body>
    <h1>Lista Utenti</h1>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Cognome</th>
          <th>Email</th>
          <th>Password</th>
          <th>Eta</th>
          <th>Attivo</th>
          <th>Ruoli</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($json->utenti as $user): ?>
        <tr>
          <td><?= $user->id ?></td>
          td><?= $user->nome ?></td>
          td><?= $user->cognome ?></td>
          td><?= $user->email ?></td>
          td><?= $user->eta ?></td>
          td><?= $user->attivo  ? 'Si' : 'No' ?></td>
          td><?= implode(', ', $user->ruoli) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    < a href = "mostra.php">Torna al Profilo</a>
  </body>
</html>


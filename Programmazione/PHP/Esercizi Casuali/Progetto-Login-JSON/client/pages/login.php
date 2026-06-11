<?php
  declare(strict_types = 1);
  session_start();
  require_once __DIR__ . '/../../config.php';

  $username = $_POST['username'];
  $psw = $_POST['psw'];

  $json = json_decode(file_get_contents(JSON_PATH));
  $user = null;

  foreach($json->utente as $utente) {
    if (($utente->nome == $username) && ($utente->password == $psw) && ($utente->attivo)) {
      $user = $utente;
      break;
    }
  }

  if ($user) {
    $_SESSION['user'] = $user;
    header('Location: mostra.php');
  } else {
    header('Location: index.php?error=1');
  }
  exit();
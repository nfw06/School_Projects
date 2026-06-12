<?php
  declare(strict_types = 1);
  session_start();
  require_once __DIR__ . '/../../config.php';

  if (!isset($_POST['user'], $_POST['psw'])) {
    header('Location: index.php?error=1');
    exit();
  }

  $username = trim($_POST['user']);
  $psw = $_POST['psw'];

  $file = file_get_contents(JSON_PATH);
  if ($file === false) {
    header('Location: index.php?error=1');
    exit();
  }
  
  $json = json_decode($file);
  $user = null;

  foreach($json->utenti as $utente) {
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
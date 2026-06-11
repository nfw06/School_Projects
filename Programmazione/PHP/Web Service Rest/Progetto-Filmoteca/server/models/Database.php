<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../config/config.php';

  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  class Database {
    private static ?Database $instance = null;
    private mysqli $connection;

    private function __construct() {
      try {
        $this->connection = new mysqli(HOST, USERNAME, PASSWORD, DB);
      } catch (Exception $error) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella connessione al Database Musica',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }

    private function __clone() {}

    public static function getInstance(): self {
      if (self::$instance === null) { self::$instance = new self(); }
      return self::$instance;
    }

    public function getConnection(): mysqli { return $this->connection; }
  }
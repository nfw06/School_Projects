<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./Database.php';

  class Collana {
    private mysqli $connection;

    public function __construct() {
      $this->connection = Database::getInstance()->getConnection();
    }

    public function getByIdLibro(int $id): ?array {
      $query = "
        SELECT c.*
        FROM collana AS c
        INNER JOIN appartiene AS a ON a.idCollana = c.idCollana
        INNER JOIN libro AS l ON l.idLibro = a.idLibro
        WHERE l.idLibro = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel getByIdLibro() di Collana',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }

    public function getById(int $id): ?array {
      $query = "
        SELECT c.*, l.*, a.*, g.*
        FROM collana AS c
        INNER JOIN appartiene AS app ON app.idCollana = c.idCollana
        INNER JOIN libro AS l ON l.idLibro = app.idLibro
        INNER JOIN autore AS a ON a.idAutore = l.idAutore
        INNER JOIN genere AS g ON g.idGenere = l.idGenere
        WHERE c.idCollana = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel getById() di Collana',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }
  }
<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./Database.php';

  class Raccolta {
    private mysqli $connection;

    public function __construct() {
      $this->connection = Database::getInstance()->getConnection();
    }

    public function getByIdFilm(int $id): ?array {
      $query = "
        SELECT DISTINCT r.*
        FROM raccolta AS r
        INNER JOIN include AS i ON i.idRaccolta = r.idRaccolta
        INNER JOIN film AS f ON f.idFilm = i.idFilm
        WHERE r.idRaccolta = ?
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
          'message' => 'Errore nel getByIdFilm() di Raccolta',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }
  }
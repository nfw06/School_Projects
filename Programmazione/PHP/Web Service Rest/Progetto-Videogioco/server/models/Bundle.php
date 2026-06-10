<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./Database.php';

  class Bundle {
    private mysqli $connection;

    public function __construct() {
      $this->connection = Database::getInstance()->getConnection();
    }

    public function getByIdVideogioco(int $id): ?array {
      $query = "
        SELECT b.*
        FROM bundle AS b
        INNER JOIN composizione AS c ON c.idBundle = b.idBundle
        INNER JOIN videogioco AS v ON v.idVideogioco = c.idVideogioco
        WHERE v.idVideogioco = ?
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
          'message' => 'Errore nel getByIdVideogioco() di Bundle',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }
  }
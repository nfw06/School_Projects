<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./Database.php';

  class Disco {
    private mysqli $connection;

    public function __construct() {
      $this->connection = Database::getInstance()->getConnection();
    }

    public function getByIdCanzone(int $id): ?array {
      $query = "
        SELECT disc.*
        FROM disco AS disc
        INNER JOIN contiene AS cont ON cont.nroSerieDisco = disc.nroSerie
        INNER JOIN canzone AS canz ON canz.idCanzone = cont.codiceReg
        WHERE canz.idCanzone = ?
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
          'message' => 'Errore nel getById() di Canzone',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }

    public function getById(int $id): ?array {
      $query = "
        SELECT disc.*, canz.*, aut.*, cant.*
        FROM disco AS disc
        INNER JOIN contiene AS cont ON cont.nroSerieDisco = disc.nroSerie
        INNER JOIN canzone AS canz ON canz.idCanzone = cont.codiceReg
        INNER JOIN autore AS aut ON aut.idAutore = canz.idAutore
        INNER JOIN cantante AS cant ON cant.idCantante = canz.idCantante
        WHERE disc.nroSerie = ?
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
          'message' => 'Errore nel getById() di Canzone',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }
  }
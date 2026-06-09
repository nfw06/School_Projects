<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./Database.php';

  class Canzone {
    private mysqli $connection;

    public function __construct() {
      $this->connection = Database::getInstance()->getConnection();
    }

    public function getAll(): array {
      $query = "
        SELECT canz.*, aut.*, cant.*
        FROM canzone AS canz
        INNER JOIN autore AS aut ON aut.idAutore = canz.idAutore
        INNER JOIN cantante AS cant ON cant.idCantante = canz.idCantante
      ";
      try {
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella getAll() di Canzone',
          'error' => $error->getMessage()
        ]);
        exit;
      }
      
    }

    public function getById(int $id): ?array {
      $query = "
        SELECT canz.*, aut.*, cant.*
        FROM canzone AS canz
        INNER JOIN autore AS aut ON aut.idAutore = canz.idAutore
        INNER JOIN cantante AS cant ON cant.idCantante = canz.idCantante
        WHERE canz.idCanzone = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
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

    public function create(array $data): bool {
      $query = "
        INSERT INTO canzone (titoloCanz, anno, idCantante, idAutore)
        VALUES (?, ?, ?, ?)
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('siii', $data['titoloCanz'], $data['anno'], $data['idCantante'], $data['idAutore']);
        return $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel create() di Canzone',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }

    public function update(int $id, array $data): bool {
      $query = "
        UPDATE canzone
        SET titoloCanz = ?, anno = ?, idCantante = ?, idAutore = ?
        WHERE idCanzone = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('siiii', $data['titoloCanz'], $data['anno'], $data['idCantante'], $data['idAutore'], $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel update() di Canzone',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }

    public function delete(int $id): bool {
      $query = "
        DELETE FROM canzone
        WHERE idCanzone = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel delete() di Canzone',
          'error' => $error->getMessage()
        ]);
        exit;
      }      
    }
  }
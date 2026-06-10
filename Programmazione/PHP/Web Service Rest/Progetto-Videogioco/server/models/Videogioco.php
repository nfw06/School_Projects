<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./Database.php';

  class Videogioco {
    private mysqli $connection;

    public function __construct() {
      $this->connection = Database::getInstance()->getConnection();
    }

    public function getAll(): array {
      $query = "
        SELECT v.*, s.*, g.*
        FROM videogioco AS v
        INNER JOIN sviluppatore AS s ON s.idSviluppatore = v.idSviluppatore
        INNER JOIN genere AS g ON g.idGenere = v.idGenere
      ";
      try {
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella getAll() di Videogioco',
          'error' => $error->getMessage()
        ]);
        exit;
      }
      
    }

    public function getById(int $id): ?array {
      $query = "
        SELECT v.*, s.*, g.*
        FROM videogioco AS v
        INNER JOIN sviluppatore AS s ON s.idSviluppatore = v.idSviluppatore
        INNER JOIN genere AS g ON g.idGenere = v.idGenere
        WHERE v.idVideogioco = ?
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
          'message' => 'Errore nel getById() di Videogioco',
          'error' => $error->getMessage()
        ]);
        exit;
      }
      
    }

    public function create(array $data): bool {
      $query = "
        INSERT INTO videogioco (titoloGioco, anno, idSviluppatore, idGenere)
        VALUES (?, ?, ?, ?)
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('siii', $data['titoloGioco'], $data['anno'], $data['idSviluppatore'], $data['idGenere']);
        return $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel create() di Videogioco',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }

    public function delete(int $id): bool {
      $query = "
        DELETE FROM videogioco
        WHERE idVideogioco = ?
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
          'message' => 'Errore nel delete() di Videogioco',
          'error' => $error->getMessage()
        ]);
        exit;
      }      
    }
  }
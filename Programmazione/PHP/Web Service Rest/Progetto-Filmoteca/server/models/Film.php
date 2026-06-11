<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./Database.php';

  class Film {
    private mysqli $connection;

    public function __construct() {
      $this->connection = Database::getInstance()->getConnection();
    }

    public function getAll(): array {
      $query = "
        SELECT f.*, r.*, g.*
        FROM film AS f
        INNER JOIN regista AS r ON r.idRegista = f.idRegista
        INNER JOIN genere as g ON g.idGenere = f.idGenere
      ";
      try {
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella getAll() di Film',
          'error' => $error->getMessage()
        ]);
        exit;
      }
      
    }

    public function getById(int $id): ?array {
      $query = "
        SELECT f.*, r.*, g.*
        FROM film AS f
        INNER JOIN regista AS r ON r.idRegista = f.idRegista
        INNER JOIN genere as g ON g.idGenere = f.idGenere
        WHERE f.idFilm = ?
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
          'message' => 'Errore nel getById() di Film',
          'error' => $error->getMessage()
        ]);
        exit;
      }
      
    }

    public function create(array $data): bool {
      $query = "
        INSERT INTO film (titoloFilm, anno, idRegista, idGenere)
        VALUES (?, ?, ?, ?)
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('siii', $data['titoloFilm'], $data['anno'], $data['idRegista'], $data['idGenere']);
        return $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel create() di Film',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }
    public function delete(int $id): bool {
      $query = "
        DELETE FROM film
        WHERE idFilm = ?
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
          'message' => 'Errore nel delete() di Film',
          'error' => $error->getMessage()
        ]);
        exit;
      }      
    }
  }
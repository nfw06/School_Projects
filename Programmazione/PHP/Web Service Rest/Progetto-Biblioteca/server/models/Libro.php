<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./Database.php';

  class Libro {
    private mysqli $connection;

    public function __construct() {
      $this->connection = Database::getInstance()->getConnection();
    }

    public function getAll(): array {
      $query = "
        SELECT l.*, a.*, g.*
        FROM libro AS l
        INNER JOIN autore AS a ON a.idAutore = l.idAutore
        INNER JOIN genere AS g ON g.idGenere = l.idGenere
      ";
      try {
        $result = $this->connection->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella getAll() di Libro',
          'error' => $error->getMessage()
        ]);
        exit;
      }
      
    }

    public function getById(int $id): ?array {
      $query = "
        SELECT l.*, a.*, g.*
        FROM libro AS l
        INNER JOIN autore AS a ON a.idAutore = l.idAutore
        INNER JOIN genere AS g ON g.idGenere = l.idGenere
        WHERE l.idLibro = ?
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
          'message' => 'Errore nel getById() di Libro',
          'error' => $error->getMessage()
        ]);
        exit;
      }
      
    }

    public function create(array $data): bool {
      $query = "
        INSERT INTO libro (titoloLibro, annoPubbl, idAutore, idGenere)
        VALUES (?, ?, ?, ?)
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('siii', $data['titoloLibro'], $data['annoPubbl'], $data['idAutore'], $data['idGenere']);
        return $stmt->execute();
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel create() di Libro',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }

    public function update(int $id, array $data): bool {
      $query = "
        UPDATE libro
        SET titoloLibro = ?, annoPubbl = ?, idAutore = ?, idGenere = ?
        WHERE idLibro = ?
      ";
      try {
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param('siiii', $data['titoloLibro'], $data['annoPubbl'], $data['idAutore'], $data['idGenere'], $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
      } catch (Exception $error) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel update() di Libro',
          'error' => $error->getMessage()
        ]);
        exit;
      }
    }

    public function delete(int $id): bool {
      $query = "
        DELETE FROM libro
        WHERE idLibro = ?
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
          'message' => 'Errore nel delete() di Libro',
          'error' => $error->getMessage()
        ]);
        exit;
      }      
    }
  }
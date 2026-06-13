<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Libro.php';

  class ControllerLibro {
    private Libro $model;

    public function __construct() {
      $this->model = new Libro();
    }

    // GET - /libri
    public function index(): void {
      $result = $this->model->getAll();
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Non ci sono Libri',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Libri Trovati',
        'data' => $result
      ]);
    }

    // GET - /libri/{id}
    public function show(int $id): void {
      $result = $this->model->getById($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Libro non esiste',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Libro Trovato',
        'data' => $result
      ]);
    }

    // POST - /libri
    public function store(): void {
      $data = json_decode(file_get_contents('php://input'), true);
      $result = $this->model->create($data);
      if (!$result) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella creazione del Libro',
        ]);
        return;
      }
      http_response_code(201);
      echo json_encode([
        'success' => true,
        'message' => 'Libro creato con Successo'
      ]);
    }

    // PUT - /libri/{id}
    public function update(int $id): void {
      $data = json_decode(file_get_contents('php://input'), true);
      $result = $this->model->update($id, $data);
      if (!$result) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel Aggiornamento del Libro'
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Libro Aggiornato con Successo'
      ]);
    }

    // DELETE - /libri/{id}
    public function destroy(int $id): void {
      $result = $this->model->delete($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella Cancellazione di un Libro'
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Libro cancellato con Successo'
      ]);
    }
  }
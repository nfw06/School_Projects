<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Film.php';

  class ControllerFilm {
    private Film $model;

    public function __construct() {
      $this->model = new Film();
    }

    // GET - /film
    public function index(): void {
      $result = $this->model->getAll();
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Non ci sono Film',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Film Trovati',
        'data' => $result
      ]);
    }

    // GET - /film/{id}
    public function show(int $id): void {
      $result = $this->model->getById($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Film non esiste',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Film Trovato',
        'data' => $result
      ]);
    }

    // POST - /film
    public function store(): void {
      $data = json_decode(file_get_contents('php://input'), true);
      $result = $this->model->create($data);
      if (!$result) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella creazione del Film',
        ]);
        return;
      }
      http_response_code(201);
      echo json_encode([
        'success' => true,
        'message' => 'Film creato con Successo'
      ]);
    }

    // DELETE - /film/{id}
    public function destroy(int $id): void {
      $result = $this->model->delete($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella Cancellazione di un Film'
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Film cancellato con Successo'
      ]);
    }
  }
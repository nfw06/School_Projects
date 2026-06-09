<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Canzone.php';

  class ControllerCanzone {
    private Canzone $model;

    public function __construct() {
      $this->model = new Canzone();
    }

    // GET - /canzoni
    public function index(): void {
      $result = $this->model->getAll();
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Non ci sono Canzoni',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Canzoni Trovati',
        'data' => $result
      ]);
    }

    // GET - /canzoni/{id}
    public function show(int $id): void {
      $result = $this->model->getById($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Canzone non esiste',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Canzone Trovato',
        'data' => $result
      ]);
    }

    // POST - /canzoni
    public function store(): void {
      $data = json_decode(file_get_contents('php://input'), true);
      $result = $this->model->create($data);
      if (!$result) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella creazione della Canzone',
        ]);
        return;
      }
      http_response_code(201);
      echo json_encode([
        'success' => true,
        'message' => 'Canzone creato con Successo'
      ]);
    }

    // PUT - /canzoni/{id}
    public function update(int $id): void {
      $data = json_decode(file_get_contents('php://input'), true);
      $result = $this->model->update($id, $data);
      if (!$result) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nel Aggiornamento della Canzone'
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Canzone Aggiornato con Successo'
      ]);
    }

    // DELETE - /canzoni/{id}
    public function destroy(int $id): void {
      $result = $this->model->delete($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella Cancellazione di una Canzone'
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Canzone cancellato con Successo'
      ]);
    }
  }
<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Videogioco.php';

  class ControllerVideogioco {
    private Videogioco $model;

    public function __construct() {
      $this->model = new Videogioco();
    }

    // GET - /videogiochi
    public function index(): void {
      $result = $this->model->getAll();
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Non ci sono Videogiochi',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Videogiochi Trovati',
        'data' => $result
      ]);
    }

    // GET - /videogiochi/{id}
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

    // POST - /videogiochi
    public function store(): void {
      $data = json_decode(file_get_contents('php://input'), true);
      $result = $this->model->create($data);
      if (!$result) {
        http_response_code(500);
        echo json_encode([
          'success' => false,
          'message' => 'Errore nella creazione del Videogioco',
        ]);
        return;
      }
      http_response_code(201);
      echo json_encode([
        'success' => true,
        'message' => 'Canzone creato con Successo'
      ]);
    }

    // DELETE - /videogiochi/{id}
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
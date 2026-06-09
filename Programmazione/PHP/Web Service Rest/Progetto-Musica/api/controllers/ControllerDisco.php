<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Disco.php';

  class ControllerDisco {
    private Disco $model;

    public function __construct() {
      $this->model = new Disco();
    }

    // GET - /dischi?canzone={id}
    public function getByIdCanzone(int $id): void {
      $result = $this->model->getByIdCanzone($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Non ci sono Dischi',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Dischi Trovati',
        'data' => $result
      ]);
    }

    // GET - /dischi/{id}
    public function show(int $id): void {
      $result = $this->model->getById($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Disco non esiste',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Disco Trovato',
        'data' => $result
      ]);
    }
  }
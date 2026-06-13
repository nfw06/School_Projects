<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Collana.php';

  class ControllerCollana {
    private Collana $model;

    public function __construct() {
      $this->model = new Collana();
    }

    // GET - /collane?libro={id}
    public function getByIdCanzone(int $id): void {
      $result = $this->model->getByIdLibro($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Non ci sono Collone',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Collane Trovati',
        'data' => $result
      ]);
    }

    // GET - /collane/{id}
    public function show(int $id): void {
      $result = $this->model->getById($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Collana non esiste',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Collana Trovato',
        'data' => $result
      ]);
    }
  }
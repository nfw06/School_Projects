<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Bundle.php';

  class ControllerBundle {
    private Bundle $model;

    public function __construct() {
      $this->model = new Bundle ();
    }

    // GET - /dischi?canzone={id}
    public function getByIdVideogioco(int $id): void {
      $result = $this->model->getByIdVideogioco($id);
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
        'message' => 'Videogiochi Trovati',
        'data' => $result
      ]);
    }
  }
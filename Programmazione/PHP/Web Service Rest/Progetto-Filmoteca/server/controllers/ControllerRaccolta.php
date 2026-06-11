<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/../models/Raccolta.php';

  class ControllerRaccolta {
    private Raccolta $model;

    public function __construct() {
      $this->model = new Raccolta();
    }

    // GET - /dischi?canzone={id}
    public function getIdByFilm(int $id): void {
      $result = $this->model->getByIdFilm($id);
      if (!$result) {
        http_response_code(404);
        echo json_encode([
          'success' => false,
          'message' => 'Non ci sono Raccolte',
        ]);
        return;
      }
      http_response_code(200);
      echo json_encode([
        'success' => true,
        'message' => 'Raccolte Trovati',
        'data' => $result
      ]);
    }
  }
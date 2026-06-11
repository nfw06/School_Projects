<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./controllers/ControllerFilm.php';
  require_once __DIR__ . '/./controllers/ControllerRaccolta.php';
  
  header('Content-Type: application/json');


  class Router {
    public function handler(): void {
      $method = $_SERVER['REQUEST_METHOD'];
      $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $basePath = '/Progetto-Filmoteca/server/index.php';
      $uri = str_replace($basePath, '', $uri);
      $segments = explode('/', trim($uri, '/'));

      switch ($segments[0]) {
        case 'film':
          $this->handleFilm($method, $segments);
        break;

        case 'raccolte':
          $this->handleRaccolte($method);
        break;

        default:
          http_response_code(404);
          echo json_encode([
            'success' => false,
            'message' => 'End Point non Trovato'
          ]);
        break;
      }

    }

    private function handleFilm(string $method, array $segments): void {
      $controller = new ControllerFilm();
      $id = isset($segments[1]) ? (int)$segments[1] : null;
      switch ($method) {
        case 'GET':
          if ($id) {
            // GET - /film{id}
            $controller->show($id);
          } else {
            // GET - /film
            $controller->index();
          }
        break;

        case 'POST':
          // POST - /film
          $controller->store();
        break;

        case 'DELETE':
          // DELETE - /film/{id}
          if ($id) {
            $controller->destroy($id);
          } else {
            http_response_code(400);
            echo json_encode([
              'success' => false,
              'message' => 'ID Mancante'
            ]);
          }
        break;

        default:
          http_response_code(405);
          echo json_encode([
            'success' => false,
            'message' => 'Metodo non Permesso'
          ]);
        break;
      }
    }

  private function handleRaccolte(string $method): void {
      $controller = new ControllerRaccolta();
      switch ($method) {
        case 'GET':
          if (isset($_GET['film'])) {
            // GET - /raccolte?film={id}
            $controller->getIdByFilm((int)$_GET['film']);
          } else {
            http_response_code(400);
            echo json_encode([
              'success' => false,
              'message' => 'Parametro mancante'
            ]);
          }
        break;

        default:
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Metodo non Permesso'
          ]);
        break;
      }
    }
  }


<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./controllers/ControllerCanzone.php';
  require_once __DIR__ . '/./controllers/ControllerDisco.php';
  
  header('Content-Type: application/json');


  class Router {
    public function handler(): void {
      $method = $_SERVER['REQUEST_METHOD'];
      $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $basePath = '/Progetto-Musica/api/index.php';
      $uri = str_replace($basePath, '', $uri);
      $segments = explode('/', trim($uri, '/'));

      switch ($segments[0]) {
        case 'canzoni':
          $this->handleCanzoni($method, $segments);
        break;

        case 'dischi':
          $this->handleDischi($method, $segments);
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

    private function handleCanzoni(string $method, array $segments): void {
      $controller = new ControllerCanzone();
      $id = isset($segments[1]) ? (int)$segments[1] : null;
      switch ($method) {
        case 'GET':
          if ($id) {
            // GET - /canzoni{id}
            $controller->show($id);
          } else {
            // GET - /canzoni
            $controller->index();
          }
        break;

        case 'POST':
          // POST - /canzoni
          $controller->store();
        break;

        case 'PUT':
          if ($id) {
            // PUT - /canzoni/{id}
            $controller->update($id);
          } else {
            http_response_code(400);
            echo json_encode([
              'success' => false,
              'message' => 'ID Mancante'
            ]);
          }
        break;

        case 'DELETE':
          // DELETE - /canzoni/{id}
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

  private function handleDischi(string $method, array $segments): void {
      $controller = new ControllerDisco();
      switch ($method) {
        case 'GET':
          if (isset($segments[1])) {
            // GET - /dischi/{id}
            $id = (int)$segments[1];
            $controller->show($id);
          } elseif (isset($_GET['canzone'])) {
            // GET - /dischi?canzoni={id}
            $controller->getByIdCanzone((int)$_GET['canzone']);
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


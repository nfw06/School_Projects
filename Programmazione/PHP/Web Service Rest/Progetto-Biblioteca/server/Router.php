<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./controllers/ControllerLibro.php';
  require_once __DIR__ . '/./controllers/ControllerCollana.php';
  
  header('Content-Type: application/json');


  class Router {
    public function handler(): void {
      $method = $_SERVER['REQUEST_METHOD'];
      $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $basePath = '/Progetto-Biblioteca/server/index.php';
      $uri = str_replace($basePath, '', $uri);
      $segments = explode('/', trim($uri, '/'));

      switch ($segments[0]) {
        case 'libri':
          $this->handleLibri($method, $segments);
        break;

        case 'collane':
          $this->handleCollane($method, $segments);
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

    private function handleLibri(string $method, array $segments): void {
      $controller = new ControllerLibro();
      $id = isset($segments[1]) ? (int)$segments[1] : null;
      switch ($method) {
        case 'GET':
          if ($id) {
            // GET - /libri{id}
            $controller->show($id);
          } else {
            // GET - /libri
            $controller->index();
          }
        break;

        case 'POST':
          // POST - /libri
          $controller->store();
        break;

        case 'PUT':
          if ($id) {
            // PUT - /libri/{id}
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
          // DELETE - /libri/{id}
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

  private function handleCollane(string $method, array $segments): void {
      $controller = new ControllerCollana();
      switch ($method) {
        case 'GET':
          if (isset($segments[1])) {
            // GET - /collane/{id}
            $id = (int)$segments[1];
            $controller->show($id);
          } elseif (isset($_GET['libro'])) {
            // GET - /collane?libro={id}
            $controller->getByIdCanzone((int)$_GET['libro']);
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


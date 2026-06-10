<?php
  declare(strict_types = 1);

  require_once __DIR__ . '/./controllers/ControllerVideogioco.php';
  require_once __DIR__ . '/./controllers/ControllerBundle.php';
  
  header('Content-Type: application/json');


  class Router {
    public function handler(): void {
      $method = $_SERVER['REQUEST_METHOD'];
      $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
      $basePath = '/Progetto-Videogioco/server/index.php';
      $uri = str_replace($basePath, '', $uri);
      $segments = explode('/', trim($uri, '/'));

      switch ($segments[0]) {
        case 'videogiochi':
          $this->handleVideogiochi($method, $segments);
        break;

        case 'bundle':
          $this->handleBundle($method);
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

    private function handleVideogiochi(string $method, array $segments): void {
      $controller = new ControllerVideogioco();
      $id = isset($segments[1]) ? (int)$segments[1] : null;
      switch ($method) {
        case 'GET':
          if ($id) {
            // GET - /videogiochi{id}
            $controller->show($id);
          } else {
            // GET - /videogiochi
            $controller->index();
          }
        break;

        case 'POST':
          // POST - /canzoni
          $controller->store();
        break;

        case 'DELETE':
          // DELETE - /videogiochi/{id}
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

  private function handleBundle(string $method): void {
      $controller = new ControllerBundle();
      switch ($method) {
        case 'GET':
          if (isset($_GET['gioco'])) {
            // GET - /bundle?gioco={id}
            $controller->getByIdVideogioco((int)$_GET['gioco']);
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


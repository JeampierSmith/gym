<?php
require_once __DIR__ . '/Config/App/Autoload.php';
require_once __DIR__ . '/vendor/autoload.php';
header('Content-Type: application/json; charset=utf-8');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$jwt_secret = 'clave_secreta_super_segura';
$jwt_alg = 'HS256';

$requestUri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($requestUri, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));

if ($segments[0] === 'api' && $segments[1] === 'v1' && isset($segments[2])) {
    switch ($segments[2]) {
        case 'asistencias':
            $headers = function_exists('getallheaders') ? getallheaders() : [];
            $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
            $jwt = null;
            if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $jwt = $matches[1];
            }
            if (!$jwt) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado, token requerido']);
                exit;
            }
            try {
                $decoded = JWT::decode($jwt, new Key($jwt_secret, $jwt_alg));
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Token inválido', 'detalle' => $e->getMessage()]);
                exit;
            }
            require_once __DIR__ . '/Controllers/Asistencias.php';
            $controller = new Asistencias();
            if ($method === 'GET') {
                if (isset($segments[3])) {
                    $controller->apiEditar($segments[3]);
                } else {
                    $controller->apiListar();
                }
            } elseif ($method === 'POST') {
                $controller->apiRegistrar();
            } elseif ($method === 'PUT' && isset($segments[3])) {
                $controller->apiActualizar($segments[3]);
            } elseif ($method === 'DELETE' && isset($segments[3])) {
                $controller->apiEliminar($segments[3]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        case 'rutinas':
            $headers = function_exists('getallheaders') ? getallheaders() : [];
            $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
            $jwt = null;
            if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $jwt = $matches[1];
            }
            if (!$jwt) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado, token requerido']);
                exit;
            }
            try {
                $decoded = JWT::decode($jwt, new Key($jwt_secret, $jwt_alg));
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Token inválido', 'detalle' => $e->getMessage()]);
                exit;
            }
            require_once __DIR__ . '/Controllers/Rutinas.php';
            $controller = new Rutinas();
            if ($method === 'GET') {
                if (isset($segments[3])) {
                    $controller->apiEditar($segments[3]);
                } else {
                    $controller->apiListar();
                }
            } elseif ($method === 'POST') {
                $controller->apiRegistrar();
            } elseif ($method === 'PUT' && isset($segments[3])) {
                $controller->apiActualizar($segments[3]);
            } elseif ($method === 'DELETE' && isset($segments[3])) {
                $controller->apiEliminar($segments[3]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        case 'entrenador':
            $headers = function_exists('getallheaders') ? getallheaders() : [];
            $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
            $jwt = null;
            if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $jwt = $matches[1];
            }
            if (!$jwt) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado, token requerido']);
                exit;
            }
            try {
                $decoded = JWT::decode($jwt, new Key($jwt_secret, $jwt_alg));
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Token inválido', 'detalle' => $e->getMessage()]);
                exit;
            }
            require_once __DIR__ . '/Controllers/Entrenador.php';
            $controller = new Entrenador();
            if ($method === 'GET') {
                if (isset($segments[3])) {
                    $controller->apiEditar($segments[3]);
                } else {
                    $controller->apiListar();
                }
            } elseif ($method === 'POST') {
                $controller->apiRegistrar();
            } elseif ($method === 'PUT' && isset($segments[3])) {
                $controller->apiActualizar($segments[3]);
            } elseif ($method === 'DELETE' && isset($segments[3])) {
                $controller->apiEliminar($segments[3]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        case 'login':
            if ($method === 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['usuario']) && isset($data['password'])) {
                    require_once __DIR__ . '/Models/UsuariosModel.php';
                    $model = new UsuariosModel();
                    $usuario = $model->getByUsername($data['usuario']);
                    $claveValida = false;
                    if ($usuario) {
                        // Si la clave es hash SHA-256, comparar con hash
                        if (strlen($usuario['clave']) === 64 && preg_match('/^[a-f0-9]{64}$/', $usuario['clave'])) {
                            $claveValida = (hash('sha256', $data['password']) === $usuario['clave']);
                        } else if (strlen($usuario['clave']) > 30 && strpos($usuario['clave'], '$2y$') === 0) {
                            $claveValida = password_verify($data['password'], $usuario['clave']);
                        } else {
                            $claveValida = ($data['password'] === $usuario['clave']);
                        }
                    }
                    if ($usuario && $claveValida) {
                        $payload = [
                            'iat' => time(),
                            'exp' => time() + 3600,
                            'usuario' => $usuario['usuario'],
                            'id' => $usuario['id']
                        ];
                        $token = JWT::encode($payload, $jwt_secret, $jwt_alg);
                        http_response_code(200);
                        echo json_encode(['token' => $token]);
                    } else {
                        http_response_code(401);
                        echo json_encode(['error' => 'Credenciales inválidas']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Usuario y contraseña requeridos']);
                }
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        case 'usuarios':
            // Autenticación JWT para endpoints protegidos
            $headers = function_exists('getallheaders') ? getallheaders() : [];
            $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
            $jwt = null;
            if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $jwt = $matches[1];
            }
            if (!$jwt) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado, token requerido']);
                exit;
            }
            try {
                $decoded = JWT::decode($jwt, new Key($jwt_secret, $jwt_alg));
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Token inválido', 'detalle' => $e->getMessage()]);
                exit;
            }
            require_once __DIR__ . '/Controllers/Usuarios.php';
            $controller = new Usuarios();
            // Usar métodos exclusivos para la API
            if ($method === 'GET') {
                if (isset($segments[3])) {
                    $controller->apiEditar($segments[3]); // /api/v1/usuarios/{id}
                } else {
                    $controller->apiListar();
                }
            } elseif ($method === 'POST') {
                $controller->apiRegistrar();
            } elseif ($method === 'PUT' && isset($segments[3])) {
                $controller->apiActualizar($segments[3]);
            } elseif ($method === 'DELETE' && isset($segments[3])) {
                $controller->apiEliminar($segments[3]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        case 'clientes':
            $headers = function_exists('getallheaders') ? getallheaders() : [];
            $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
            $jwt = null;
            if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $jwt = $matches[1];
            }
            if (!$jwt) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado, token requerido']);
                exit;
            }
            try {
                $decoded = JWT::decode($jwt, new Key($jwt_secret, $jwt_alg));
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Token inválido', 'detalle' => $e->getMessage()]);
                exit;
            }
            require_once __DIR__ . '/Controllers/Clientes.php';
            $controller = new Clientes();
            if ($method === 'GET') {
                if (isset($segments[3])) {
                    $controller->get($segments[3]);
                } else {
                    $controller->getAll();
                }
            } elseif ($method === 'POST') {
                $controller->create(json_decode(file_get_contents('php://input'), true));
            } elseif ($method === 'PUT' && isset($segments[3])) {
                $controller->update($segments[3], json_decode(file_get_contents('php://input'), true));
            } elseif ($method === 'DELETE' && isset($segments[3])) {
                $controller->delete($segments[3]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        case 'planes':
            $headers = function_exists('getallheaders') ? getallheaders() : [];
            $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
            $jwt = null;
            if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $jwt = $matches[1];
            }
            if (!$jwt) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado, token requerido']);
                exit;
            }
            try {
                $decoded = JWT::decode($jwt, new Key($jwt_secret, $jwt_alg));
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Token inválido', 'detalle' => $e->getMessage()]);
                exit;
            }
            require_once __DIR__ . '/Controllers/Planes.php';
            $controller = new Planes();
            if ($method === 'GET') {
                if (isset($segments[3])) {
                    $controller->get($segments[3]);
                } else {
                    $controller->getAll();
                }
            } elseif ($method === 'POST') {
                $controller->create(json_decode(file_get_contents('php://input'), true));
            } elseif ($method === 'PUT' && isset($segments[3])) {
                $controller->update($segments[3], json_decode(file_get_contents('php://input'), true));
            } elseif ($method === 'DELETE' && isset($segments[3])) {
                $controller->delete($segments[3]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        case 'rutinas':
            $headers = function_exists('getallheaders') ? getallheaders() : [];
            $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
            $jwt = null;
            if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $jwt = $matches[1];
            }
            if (!$jwt) {
                http_response_code(401);
                echo json_encode(['error' => 'No autorizado, token requerido']);
                exit;
            }
            try {
                $decoded = JWT::decode($jwt, new Key($jwt_secret, $jwt_alg));
            } catch (Exception $e) {
                http_response_code(401);
                echo json_encode(['error' => 'Token inválido', 'detalle' => $e->getMessage()]);
                exit;
            }
            require_once __DIR__ . '/Controllers/Rutinas.php';
            $controller = new Rutinas();
            if ($method === 'GET') {
                if (isset($segments[3])) {
                    $controller->get($segments[3]);
                } else {
                    $controller->getAll();
                }
            } elseif ($method === 'POST') {
                $controller->create(json_decode(file_get_contents('php://input'), true));
            } elseif ($method === 'PUT' && isset($segments[3])) {
                $controller->update($segments[3], json_decode(file_get_contents('php://input'), true));
            } elseif ($method === 'DELETE' && isset($segments[3])) {
                $controller->delete($segments[3]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Método no permitido']);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint no encontrado']);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no válida']);
}

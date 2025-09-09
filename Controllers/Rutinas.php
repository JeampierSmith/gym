<?php

class Rutinas extends Controller
{    // Métodos exclusivos para la API
    public function apiListar() {
        require_once __DIR__ . '/../Models/RutinasModel.php';
        $model = new RutinasModel();
        $data = $model->getRutinas(1);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function apiEditar($id) {
        require_once __DIR__ . '/../Models/RutinasModel.php';
        $model = new RutinasModel();
        $data = $model->editar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function apiRegistrar() {
        require_once __DIR__ . '/../Models/RutinasModel.php';
        $model = new RutinasModel();
        $input = json_decode(file_get_contents('php://input'), true);
        $campos = ['dia', 'descripcion'];
        foreach ($campos as $campo) {
            if (empty($input[$campo])) {
                http_response_code(400);
                echo json_encode(["error" => "El campo $campo es obligatorio"]);
                die();
            }
        }
        $user = isset($input['user']) ? $input['user'] : null;
        $result = $model->registrar($input['dia'], $input['descripcion'], $user);
        if ($result === "ok") {
            echo json_encode(["success" => true, "message" => "Rutina registrada correctamente"]);
        } elseif ($result === "existe") {
            http_response_code(409);
            echo json_encode(["error" => "La rutina ya existe"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al registrar la rutina"]);
        }
        die();
    }

    public function apiActualizar($id) {
        require_once __DIR__ . '/../Models/RutinasModel.php';
        $model = new RutinasModel();
        $input = json_decode(file_get_contents('php://input'), true);
        $rutina = $model->editar($id);
        if (!$rutina) {
            http_response_code(404);
            echo json_encode(["error" => "Rutina no encontrada"]);
            die();
        }
        $camposPermitidos = ["dia", "descripcion"];
        $datosActualizar = [];
        foreach ($camposPermitidos as $campo) {
            if (array_key_exists($campo, $input)) {
                $datosActualizar[$campo] = $input[$campo];
            }
        }
        if (empty($datosActualizar)) {
            http_response_code(400);
            echo json_encode(["error" => "No se enviaron campos válidos para actualizar"]);
            die();
        }
        $datosFinales = [
            isset($datosActualizar['dia']) ? $datosActualizar['dia'] : $rutina['dia'],
            isset($datosActualizar['descripcion']) ? $datosActualizar['descripcion'] : $rutina['descripcion'],
            $id
        ];
        $result = $model->modificar(...$datosFinales);
        if ($result === "modificado") {
            echo json_encode(["success" => true, "message" => "Rutina actualizada correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar la rutina"]);
        }
        die();
    }

    public function apiEliminar($id) {
        require_once __DIR__ . '/../Models/RutinasModel.php';
        $model = new RutinasModel();
        $result = $model->accion(0, $id);
        if ($result == 1) {
            echo json_encode(["success" => true, "message" => "Rutina eliminada correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar la rutina"]);
        }
        die();
    }

    protected $user;
    public function __construct()
    {
        $isApi = (strpos($_SERVER['REQUEST_URI'], '/api/') !== false);
        if ($isApi) {
            // API: no sesión, no redirección
            $this->user = null;
        } else {
            session_start();
            if (empty($_SESSION['activo'])) {
                header("location: " . base_url);
            }
            $this->user = $_SESSION['id_usuario'];
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getRutinas(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
            $data[$i]['editar'] = '<button class="btn btn-outline-primary" type="button" onclick="btnEditarRut(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>';
            $data[$i]['eliminar'] = '<button class="btn btn-outline-danger" type="button" onclick="btnEliminarRut(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $dia = strClean($_POST['dia']);
        $descripcion = strClean($_POST['descripcion']);
        $id = strClean($_POST['id']);
        if (empty($dia) || empty($descripcion)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->registrar($dia, $descripcion, $this->user);
                if ($data == "ok") {
                    $msg = array('msg' => 'Rutina registrado con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'La rutina ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificar($dia, $descripcion, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Rutina modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar($id)
    {
        $data = $this->model->editar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        $data = $this->model->accion(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Rutina dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reingresar($id)
    {
        $data = $this->model->accion(1, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Rutina reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error la reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function inactivos()
    {
        $data['rutinas'] = $this->model->getRutinas(0);
        $this->views->getView($this, "inactivos", $data);
    }
}

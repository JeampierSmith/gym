<?php

class Entrenador extends Controller
{    // Métodos exclusivos para la API
    public function apiListar() {
        require_once __DIR__ . '/../Models/EntrenadorModel.php';
        $model = new EntrenadorModel();
        $data = $model->getEntrenador(1);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function apiEditar($id) {
        require_once __DIR__ . '/../Models/EntrenadorModel.php';
        $model = new EntrenadorModel();
        $data = $model->editar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function apiRegistrar() {
        require_once __DIR__ . '/../Models/EntrenadorModel.php';
        $model = new EntrenadorModel();
        $input = json_decode(file_get_contents('php://input'), true);
        $campos = ['nombre', 'apellido', 'telefono', 'direccion'];
        foreach ($campos as $campo) {
            if (empty($input[$campo])) {
                http_response_code(400);
                echo json_encode(["error" => "El campo $campo es obligatorio"]);
                die();
            }
        }
        $correo = isset($input['correo']) ? $input['correo'] : '';
        $result = $model->registrar($input['nombre'], $input['apellido'], $input['telefono'], $correo, $input['direccion']);
        if ($result === "ok") {
            echo json_encode(["success" => true, "message" => "Entrenador registrado correctamente"]);
        } elseif ($result === "existe") {
            http_response_code(409);
            echo json_encode(["error" => "El entrenador ya existe"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al registrar el entrenador"]);
        }
        die();
    }

    public function apiActualizar($id) {
        require_once __DIR__ . '/../Models/EntrenadorModel.php';
        $model = new EntrenadorModel();
        $input = json_decode(file_get_contents('php://input'), true);
        $entrenador = $model->editar($id);
        if (!$entrenador) {
            http_response_code(404);
            echo json_encode(["error" => "Entrenador no encontrado"]);
            die();
        }
        $camposPermitidos = ["nombre", "apellido", "telefono", "correo", "direccion"];
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
            isset($datosActualizar['nombre']) ? $datosActualizar['nombre'] : $entrenador['nombre'],
            isset($datosActualizar['apellido']) ? $datosActualizar['apellido'] : $entrenador['apellido'],
            isset($datosActualizar['telefono']) ? $datosActualizar['telefono'] : $entrenador['telefono'],
            isset($datosActualizar['correo']) ? $datosActualizar['correo'] : $entrenador['correo'],
            isset($datosActualizar['direccion']) ? $datosActualizar['direccion'] : $entrenador['direccion'],
            $id
        ];
        $result = $model->modificar(...$datosFinales);
        if ($result === "modificado") {
            echo json_encode(["success" => true, "message" => "Entrenador actualizado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar el entrenador"]);
        }
        die();
    }

    public function apiEliminar($id) {
        require_once __DIR__ . '/../Models/EntrenadorModel.php';
        $model = new EntrenadorModel();
        $result = $model->accion(0, $id);
        if ($result == 1) {
            echo json_encode(["success" => true, "message" => "Entrenador eliminado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el entrenador"]);
        }
        die();
    }

    public function __construct()
    {
        $isApi = (strpos($_SERVER['REQUEST_URI'], '/api/') !== false);
        if ($isApi) {
            // API: no sesión, no redirección
        } else {
            session_start();
            if (empty($_SESSION['activo'])) {
                header("location: " . base_url);
            }
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getEntrenador(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
            $data[$i]['editar'] = '<button class="btn btn-outline-primary" type="button" onclick="btnEditarEnt(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>';
            $data[$i]['eliminar'] = '<button class="btn btn-outline-danger" type="button" onclick="btnEliminarEnt(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $nombre = strClean($_POST['nombre']);
        $apellido = strClean($_POST['apellido']);
        $telefono = strClean($_POST['telefono']);
        $correo = strClean($_POST['correo']);
        $direccion = strClean($_POST['direccion']);
        $id = strClean($_POST['id']);
        if (empty($nombre) || empty($apellido)|| empty($telefono)|| empty($direccion)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($id == "") {
                $data = $this->model->registrar($nombre, $apellido, $telefono, $correo, $direccion);
                if ($data == "ok") {
                    $msg = array('msg' => 'Entrenador registrado con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'Entrenador ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificar($nombre, $apellido, $telefono, $correo, $direccion, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Entrenador modificado', 'icono' => 'success');
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
            $msg = array('msg' => 'Entrenador dado de baja', 'icono' => 'success');
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
            $msg = array('msg' => 'Entrenador reingresado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error la reingresar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function inactivos()
    {
        $data['entrenador'] = $this->model->getEntrenador(0);
        $this->views->getView($this, "inactivos", $data);
    }
}

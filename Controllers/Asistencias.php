<?php

class Asistencias extends Controller
{
    protected $user;
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
        $this->user = $_SESSION['id_usuario'];
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getAsistencias();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['status'] = '<span class="badge bg-danger">En Gym</span>';
                $data[$i]['editar'] = '<button class="btn btn-outline-primary" type="button" onclick="editarAsist(' . $data[$i]['id_asistencia'] . ');"><i class="fas fa-edit"></i></button>';
            } else {
                $data[$i]['editar'] = '';
                $data[$i]['status'] = '<span class="badge bg-success">Salido</span>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $fecha = date('Y-m-d');
        $entrada = date('H:i:s');
        $id_cli = strClean($_POST['id_cli']);
        $id_entrenador = strClean($_POST['id_entrenador']);
        $id_rutina = strClean($_POST['id_rutina']);
        if (empty($id_cli) || empty($id_entrenador)|| empty($id_rutina)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            $data = $this->model->registrar($fecha, $entrada, $id_cli, $id_entrenador, $id_rutina, $this->user);
            if ($data == "ok") {
                $msg = array('msg' => 'Asistencia registrado con éxito', 'icono' => 'success');
            } else if ($data == "existe") {
                $msg = array('msg' => 'La asistencia ya existe', 'icono' => 'warning');
            } else {
                $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function actualizar($id)
    {
        $salida = date('H:i:s');
        $data = $this->model->accion($salida, 0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Salida Registrado', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al registrar salida', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscarEntrenador()
    {
        if (isset($_GET['ent'])) {
            $data = $this->model->buscarEntrenador($_GET['ent']);
            $datos = array();
            foreach ($data as $row) {
                $data['id'] = $row['id'];
                $data['label'] = $row['nombre'] . ' - ' . $row['direccion'];
                $data['value'] = $row['nombre'];
                array_push($datos, $data);
            }
        }
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscarRutina()
    {
        if (isset($_GET['rut'])) {
            $data = $this->model->buscarRutina($_GET['rut']);
            $datos = array();
            foreach ($data as $row) {
                $data['id'] = $row['id'];
                $data['label'] = $row['dia'] . ' - ' . $row['descripcion'];
                $data['value'] = $row['descripcion'];
                array_push($datos, $data);
            }
        }
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        die();
    }
}

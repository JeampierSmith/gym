<?php

class Administracion extends Controller
{
    public function __construct()
    {
        session_start();
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        parent::__construct();
    }
    public function index()
    {
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $data['empresa'] = $this->model->getEmpresa();
        $this->views->getView($this, "index", $data);
        
    }
    public function home()
    {
        $data['planes'] = $this->model->getDatos('planes');
        $data['clientes'] = $this->model->getDatos('clientes');
        $data['usuarios'] = $this->model->getDatos('usuarios');
		$data['entrenador'] = $this->model->getDatos('entrenador');
        $this->views->getView($this, "home", $data);
    }
    public function modificar()
    {
        if ($_SESSION['rol'] != 1) {
            echo 'NO TIENES PERMISOS';
            exit;
        }
        $ruc = strClean($_POST['ruc']);
        $nombre = strClean($_POST['nombre']);
        $correo = strClean($_POST['correo']);
        $tel = strClean($_POST['telefono']);
        $dir = strClean($_POST['direccion']);
        $mensaje = strClean($_POST['mensaje']);
        $limite = strClean($_POST['limite']);
        $id = strClean($_POST['id']);
        $img = $_FILES['imagen'];
        $tmpName = $img['tmp_name'];
        if (empty($id) || empty($nombre)|| empty($correo) || empty($tel) || empty($dir) || empty($limite)) {
            $msg = array('msg' => 'Todo los campos son requeridos', 'icono' => 'warning');
        } else {
            $name = "logo.png";
            $destino = 'Assets/images/logo.png';
            $data = $this->model->modificar($ruc, $nombre, $correo, $tel, $dir, $mensaje, $name,$limite, $id);
            if ($data == 'ok') {
                if (!empty($img['name'])) {
                    $extension = pathinfo($img['name'], PATHINFO_EXTENSION);
                    $formatos_permitidos =  array('png');
                    $extension = pathinfo($img['name'], PATHINFO_EXTENSION);
                    if (!in_array($extension, $formatos_permitidos)) {
                        $msg = array('msg' => 'Imagen no permitido', 'icono' => 'warning');
                    } else {
                        move_uploaded_file($tmpName, $destino);
                        $msg = array('msg' => 'Datos modificado con éxito', 'icono' => 'success');
                    }
                } else {
                    $msg = array('msg' => 'Datos modificado con éxito', 'icono' => 'success');
                }
            } else {
                $msg = array('msg' => 'Error al modificar', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function actualizarGrafico($anio)
    {
        $desde = $anio . '-01-01';
        $hasta = $anio . '-12-31';
        $id_user = $_SESSION['id_usuario'];
        $data = $this->model->getproductosVendidos($desde, $hasta, $id_user);
        echo json_encode($data);
        die();
    }
    public function getVentas()
    {
        $id_user = $_SESSION['id_usuario'];
        $data = $this->model->getVentas($id_user);
        echo json_encode($data);
        die();
    }
    public function permisos()
    {
        $this->views->getView($this, "permisos");
    }
}

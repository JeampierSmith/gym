<?php
class Usuarios extends Controller{
    public function __construct() {
        session_start();
        
        parent::__construct();
    }
    public function index()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $data = $this->model->getUsuarios(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
            $data[$i]['eliminar'] = '';
            $data[$i]['editar'] = '<button class="btn btn-outline-primary" type="button" onclick="btnEditarUser(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>';
            $data[$i]['eliminar'] = '<button class="btn btn-outline-danger" type="button" onclick="btnEliminarUser(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>';
            if ($data[$i]['rol'] == 1) {
                $data[$i]['rol'] = '<span class="badge bg-info">Administrador</span>';
            } else {
                $data[$i]['rol'] = '<span class="badge bg-danger">Empleado</span>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
        
    }
    public function validar()
    {
        $usuario = strClean($_POST['usuario']);
        $clave = strClean($_POST['clave']);
        if (empty($usuario) || empty($clave)) {
            $msg = "Los campos estan vacios";
        }else{
            $hash = hash("SHA256", $clave);
            $data = $this->model->getUsuario($usuario, $hash);
            if ($data) {
                $_SESSION['id_usuario'] = $data['id'];
                $_SESSION['usuario'] = $data['usuario'];
                $_SESSION['nombre'] = $data['nombre'];
                $_SESSION['correo'] = $data['correo'];
                $_SESSION['rol'] = $data['rol'];
                $_SESSION['activo'] = true;
                $msg = "ok";
            }else{
                $msg = "Usuario o contraseña incorrecta";
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $usuario = strClean($_POST['usuario']);
        $nombre = strClean($_POST['nombre']);
        $correo = strClean($_POST['correo']);
        $telefono = strClean($_POST['telefono']);
        $clave = strClean($_POST['clave']);
        $confirmar = strClean($_POST['confirmar']);
        $rol = strClean($_POST['rol']);
        $id = strClean($_POST['id']);
        $hash = hash("SHA256", $clave);
        $fecha = date("YmdHis");
        if (empty($usuario) || empty($nombre) || empty($correo)|| empty($telefono) || empty($rol)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            if ($id == "") {
                if (!empty($clave) && !empty($confirmar)) {
                    if ($clave != $confirmar) {
                        $msg = array('msg' => 'Las contraseña no coinciden', 'icono' => 'warning');
                    } else {
                        $data = $this->model->registrarUsuario($usuario, $nombre, $correo, $telefono, $hash, $rol);
                        if ($data == "ok") {
                            $msg = array('msg' => 'Usuario registrado con éxito', 'icono' => 'success');
                        } else if ($data == "existe") {
                            $msg = array('msg' => 'El usuario ya existe', 'icono' => 'warning');
                        } else {
                            $msg = array('msg' => 'Error al registrar el usuario', 'icono' => 'error');
                        }
                    }
                } else {
                    $msg = array('msg' => 'La contraseña es requerido', 'icono' => 'warning');
                }
            } else {
                $imgDelete = $this->model->editarUser($id);
                if ($imgDelete['foto'] != 'avatar.svg') {
                    if (file_exists("Assets/img/users/" . $imgDelete['foto'])) {
                        unlink("Assets/img/users/" . $imgDelete['foto']);
                    }
                }
                $data = $this->model->modificarUsuario($usuario, $nombre, $correo, $telefono, $rol, $id);
                if ($data == "modificado") {
                    $msg = array('msg' => 'Usuario modificado con éxito', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar el usuario', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
        
    }
    public function editar($id)
    {
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $data = $this->model->editarUser($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $data = $this->model->accionUser(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Usuario dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el usuario', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function cambiarPass()
    {
        $actual = strClean($_POST['clave_actual']);
        $nueva = strClean($_POST['clave_nueva']);
        $confirmar = strClean($_POST['confirmar_clave']);
        if (empty($actual) || empty($nueva) || empty($confirmar)) {
            $mensaje = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        }else{
            if ($nueva != $confirmar) {
                $mensaje = array('msg' => 'Las contraseña no coinciden', 'icono' => 'warning');
            }else{
                $id = $_SESSION['id_usuario'];
                $hash = hash("SHA256", $actual);
                $data = $this->model->getPass($hash, $id);
                if(!empty($data)){
                    $verificar = $this->model->modificarPass(hash("SHA256", $nueva), $id);
                    if ($verificar == 1) {
                        $mensaje = array('msg' => 'Contraseña Modificada con éxito', 'icono' => 'success');
                    }else{
                        $mensaje = array('msg' => 'Error al modificar la contraseña', 'icono' => 'error');
                    }
                }else{
                    $mensaje = array('msg' => 'La contraseña actual incorrecta', 'icono' => 'warning');
                }
            }
        }
        echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function perfil()
    {
        if (empty($_SESSION['activo'])) {
            header("location: " . base_url);
        }
        $this->views->getView($this, "perfil");
    }
    public function salir()
    {
        session_destroy();
        header("location: " . base_url);
    }
    public function inactivos()
    {
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $data['usuarios'] = $this->model->getUsuarios(0);
        $this->views->getView($this, "inactivos", $data);
    }
}
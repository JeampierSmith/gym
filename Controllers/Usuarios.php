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
        // Devuelve datos con campos extra para DataTables (web)
        $data = $this->model->getUsuarios(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
            $data[$i]['editar'] = '<button class="btn btn-outline-primary" type="button" onclick="btnEditarUser(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>';
            $data[$i]['eliminar'] = '<button class="btn btn-outline-danger" type="button" onclick="btnEliminarUser(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>';
            $data[$i]['rol'] = $data[$i]['rol'] == 1 ? '<span class="badge bg-info">Administrador</span>' : '<span class="badge bg-danger">Empleado</span>';
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
        public function get($id) {
            require_once __DIR__ . '/../Models/UsuariosModel.php';
            $model = new \Models\UsuariosModel();
            return $model->find($id);
        }

        public function getAll() {
            require_once __DIR__ . '/../Models/UsuariosModel.php';
            $model = new \Models\UsuariosModel();
            return $model->all();
        }

        public function create($data) {
            require_once __DIR__ . '/../Models/UsuariosModel.php';
            $model = new \Models\UsuariosModel();
            return $model->create($data);
        }

        public function update($id, $data) {
            require_once __DIR__ . '/../Models/UsuariosModel.php';
            $model = new \Models\UsuariosModel();
            return $model->update($id, $data);
        }

        public function delete($id) {
            require_once __DIR__ . '/../Models/UsuariosModel.php';
            $model = new \Models\UsuariosModel();
            return $model->delete($id);
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

    public function apiListar()
{
    $data = $this->model->getUsuarios(1);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

public function apiEditar($id)
{
    $data = $this->model->getUsuarioById($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
}

public function apiRegistrar()
{
    $input = json_decode(file_get_contents('php://input'), true);
    $result = $this->model->registrarUsuarioApi($input);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}

public function apiActualizar($id)
{
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input) || empty($input)) {
        http_response_code(400);
        echo json_encode(["error" => "No se recibieron datos para actualizar"]);
        return;
    }
    $usuario = $this->model->getUsuarioById($id);
    if (!$usuario) {
        http_response_code(404);
        echo json_encode(["error" => "Usuario no encontrado"]);
        return;
    }
    $camposPermitidos = ["usuario", "nombre", "correo", "telefono", "clave", "rol"];
    $datosActualizar = [];
    foreach ($camposPermitidos as $campo) {
        if (array_key_exists($campo, $input)) {
            $datosActualizar[$campo] = $input[$campo];
        }
    }
    if (empty($datosActualizar)) {
        http_response_code(400);
        echo json_encode(["error" => "No se enviaron campos válidos para actualizar"]);
        return;
    }
    $result = $this->model->actualizarUsuarioApi($id, $datosActualizar);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}

public function apiEliminar($id)
{
    $result = $this->model->eliminarUsuario($id);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}
}
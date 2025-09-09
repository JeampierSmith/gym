<?php

class Planes extends Controller {
    // Métodos CRUD para la API
    public function get($id) {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $data = $model->editarPlan($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function getAll() {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $data = $model->getPlanes(1);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function create($data) {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $campos = ['nombre', 'descripcion', 'precio_plan', 'condicion'];
        foreach ($campos as $campo) {
            if (empty($data[$campo])) {
                http_response_code(400);
                echo json_encode(["error" => "El campo $campo es obligatorio"]);
                return;
            }
        }
        $imagen = isset($data['imagen']) ? $data['imagen'] : 'default.png';
        $id_user = isset($data['id_user']) ? $data['id_user'] : 1;
        $result = $model->registrarPlan($data['nombre'], $data['descripcion'], $data['precio_plan'], $data['condicion'], $imagen, $id_user);
        if ($result === "ok") {
            echo json_encode(["success" => true, "message" => "Plan registrado correctamente"]);
        } elseif ($result === "existe") {
            http_response_code(409);
            echo json_encode(["error" => "El plan ya existe"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al registrar el plan"]);
        }
    }

    public function update($id, $data) {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $plan = $model->editarPlan($id);
        if (!$plan) {
            http_response_code(404);
            echo json_encode(["error" => "Plan no encontrado"]);
            return;
        }
        $camposObligatorios = ["nombre", "descripcion", "precio_plan", "condicion", "imagen"];
        $datosFinales = [];
        foreach ($camposObligatorios as $campo) {
            if (array_key_exists($campo, $data)) {
                $valor = $data[$campo];
            } else {
                $valor = isset($plan[$campo]) ? $plan[$campo] : null;
            }
            if ($valor === null && $campo === "nombre") {
                http_response_code(400);
                echo json_encode(["error" => "El campo 'nombre' es obligatorio"]);
                return;
            }
            $datosFinales[] = $valor;
        }
        $datosFinales[] = $id;
        $result = $model->modificarPlan(...$datosFinales);
        if ($result === "modificado") {
            echo json_encode(["success" => true, "message" => "Plan actualizado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar el plan"]);
        }
    }

    public function delete($id) {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $result = $model->accionPlan(0, $id);
        if ($result == 1) {
            echo json_encode(["success" => true, "message" => "Plan eliminado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el plan"]);
        }
    }
    // Métodos exclusivos para la API
    public function apiListar() {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $data = $model->getPlanes(1);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function apiEditar($id) {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $data = $model->editarPlan($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function apiRegistrar() {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $input = json_decode(file_get_contents('php://input'), true);
        $campos = ['nombre', 'descripcion', 'precio_plan', 'condicion'];
        foreach ($campos as $campo) {
            if (empty($input[$campo])) {
                http_response_code(400);
                echo json_encode(["error" => "El campo $campo es obligatorio"]);
                return;
            }
        }
        $imagen = isset($input['imagen']) ? $input['imagen'] : 'default.png';
        $id_user = isset($input['id_user']) ? $input['id_user'] : 1;
        $result = $model->registrarPlan($input['nombre'], $input['descripcion'], $input['precio_plan'], $input['condicion'], $imagen, $id_user);
        if ($result === "ok") {
            echo json_encode(["success" => true, "message" => "Plan registrado correctamente"]);
        } elseif ($result === "existe") {
            http_response_code(409);
            echo json_encode(["error" => "El plan ya existe"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al registrar el plan"]);
        }
    }

    public function apiActualizar($id) {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $input = json_decode(file_get_contents('php://input'), true);
        $plan = $model->editarPlan($id);
        if (!$plan) {
            http_response_code(404);
            echo json_encode(["error" => "Plan no encontrado"]);
            return;
        }
        $camposPermitidos = ["nombre", "descripcion", "precio_plan", "condicion", "imagen"];
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
        $datosFinales = [
            isset($datosActualizar['nombre']) ? $datosActualizar['nombre'] : $plan['nombre'],
            isset($datosActualizar['descripcion']) ? $datosActualizar['descripcion'] : $plan['descripcion'],
            isset($datosActualizar['precio_plan']) ? $datosActualizar['precio_plan'] : $plan['precio_plan'],
            isset($datosActualizar['condicion']) ? $datosActualizar['condicion'] : $plan['condicion'],
            isset($datosActualizar['imagen']) ? $datosActualizar['imagen'] : $plan['imagen'],
            $id
        ];
        $result = $model->modificarPlan(...$datosFinales);
        if ($result === "modificado") {
            echo json_encode(["success" => true, "message" => "Plan actualizado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar el plan"]);
        }
    }

    public function apiEliminar($id) {
        require_once __DIR__ . '/../Models/PlanesModel.php';
        $model = new PlanesModel();
        $result = $model->accionPlan(0, $id);
        if ($result == 1) {
            echo json_encode(["success" => true, "message" => "Plan eliminado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el plan"]);
        }
    }
    protected $user;
    public function __construct()
    {
        $isApi = (strpos($_SERVER['REQUEST_URI'], '/api/') !== false);
        if ($isApi) {
            $this->user = 1;
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
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $data = $this->model->getPlanes(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . base_url . "Assets/images/planes/" . $data[$i]['imagen'] . '" width="50">';
            $data[$i]['editar'] = '<button class="btn btn-outline-primary" type="button" onclick="btnEditarPlan(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>';
            $data[$i]['eliminar'] = '<button class="btn btn-outline-danger" type="button" onclick="btnEliminarPlan(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $nombre = strClean($_POST['nombre']);
        $descripcion = strClean($_POST['descripcion']);
        $precio_plan = strClean($_POST['precio_plan']);
        $condicion = strClean($_POST['condicion']);
        $img = $_FILES['imagen'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $fecha = date("YmdHis");
        $id = strClean($_POST['id']);
        if (empty($nombre) || empty($descripcion) || empty($precio_plan)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            if (!empty($name)) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $formatos_permitidos =  array('png', 'jpeg', 'jpg');
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                if (!in_array($extension, $formatos_permitidos)) {
                    $msg = array('msg' => 'Archivo no permitido', 'icono' => 'warning');
                } else {
                    $imgNombre = $fecha . ".jpg";
                    $destino = "Assets/images/planes/" . $imgNombre;
                }
            } else if (!empty($_POST['foto_actual']) && empty($name)) {
                $imgNombre = $_POST['foto_actual'];
            } else {
                $imgNombre = "default.png";
            }
            if ($id == "") {
                $data = $this->model->registrarPlan($nombre, $descripcion, $precio_plan, $condicion, $imgNombre, $this->user);
                if ($data == "ok") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpname, $destino);
                    }
                    $msg = array('msg' => 'Plan registrado con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El plan ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
                }
            } else {
                $imgDelete = $this->model->editarPlan($id);
                if ($imgDelete['imagen'] != 'default.png') {
                    if (file_exists("Assets/images/planes/" . $imgDelete['imagen'])) {
                        unlink("Assets/images/planes/" . $imgDelete['imagen']);
                    }
                }
                $data = $this->model->modificarPlan($nombre, $descripcion, $precio_plan, $condicion, $imgNombre ,$id);
                if ($data == "modificado") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpname, $destino);
                    }
                    $msg = array('msg' => 'Plan modificado', 'icono' => 'success');
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
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $data = $this->model->editarPlan($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        if ($_SESSION['rol'] != 1) {
            header('Location: ' . base_url . 'administracion/permisos');
            exit;
        }
        $data = $this->model->accionPlan(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Plan dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrarPlanCliente()
    {
        $empresa = $this->model->getEmpresa();
        $id_cli = strClean($_POST['id_cli']);
        $id_plan = strClean($_POST['id_plan']);
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $consultaPlan = $this->model->editarPlan($id_plan);
        if ($consultaPlan == 'MENSUAL') {
            $fecha_venc = date("Y-m-d", strtotime($fecha . '+1 month'));
        }else {
            $fecha_venc = date("Y-m-d", strtotime($fecha . '+1 year'));  
        }
        $fecha_limite = date("Y-m-d",strtotime($fecha_venc. '+ ' . $empresa['limite'] . ' days'));
        if (empty($id_cli) || empty($id_plan)) {
            $msg = array('msg' => 'Todo los campos son obligatorios', 'icono' => 'warning');
        } else {
            $data = $this->model->registrarPlanCliente($id_cli, $id_plan, $fecha, $hora, $fecha_venc, $fecha_limite, $this->user);
            if ($data == "ok") {
                $msg = array('msg' => 'Plan registrado con éxito', 'icono' => 'success');
            } else if ($data == "existe") {
                $msg = array('msg' => 'El plan ya existe', 'icono' => 'warning');
            } else {
                $msg = array('msg' => 'Error al registrar', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function desactivar($id)
    {
        $data = $this->model->desactivarPlan(0, $id);
        if ($data == 'ok') {
            $msg = array('msg' => 'Plan desactivado con éxito', 'icono' => 'success');
        }else{
            $msg = array('msg' => 'Error al desactivar', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //registrar Pago Plan
    public function registrarPago($id)
    {
        if (!empty($id) || is_integer($id)) {
            $consultar = $this->model->consultarDetalle($id);
            $empresa = $this->model->getEmpresa();
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $consultaPlan = $this->model->editarPlan($consultar['id_plan']);
            if ($consultaPlan == 'MENSUAL') {
                $fecha_venc = date("Y-m-d", strtotime($consultar['fecha_venc'] . '+1 month'));
            } else {
                $fecha_venc = date("Y-m-d", strtotime($consultar['fecha_venc'] . '+1 year'));
            }
            $fecha_limite = date("Y-m-d", strtotime($fecha_venc . '+ ' . $empresa['limite'] . ' days'));
            $data = $this->model->registrarPago($fecha_venc, $fecha_limite, $id);
            if ($data == 'ok') {
                $detalle = $this->model->registrarDetallePago($id, $consultar['id_cliente'], $consultar['id_plan'], $consultar['precio_plan'], $fecha, $hora, $this->user);
                if ($detalle > 0) {
                    $mensaje = array('msg' => 'Pago Registrado', 'icono' => 'success', 'id_pago' => $detalle);
                }else{
                    $mensaje = array('msg' => 'Error al Registrar Detalle Pago', 'icono' => 'error');
                }
            }else{
                $mensaje = array('msg' => 'Error al Registrar el Pago', 'icono' => 'error');
            }
        }else{
            $mensaje = array('msg' => 'Error Fatal', 'icono' => 'error');
        }
        echo json_encode($mensaje);
        die();
    } 
}

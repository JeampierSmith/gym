<?php

use Luecano\NumeroALetras\NumeroALetras;

class Clientes extends Controller {
    // Métodos exclusivos para la API
    public function apiListar() {
        require_once __DIR__ . '/../Models/ClientesModel.php';
        $model = new \ClientesModel();
        $data = $model->getClientes(1);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function apiEditar($id) {
        require_once __DIR__ . '/../Models/ClientesModel.php';
        $model = new \ClientesModel();
        $data = $model->editarCli($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function apiRegistrar() {
        require_once __DIR__ . '/../Models/ClientesModel.php';
        $model = new \ClientesModel();
        $input = json_decode(file_get_contents('php://input'), true);
        // Validar campos requeridos
        $campos = ['dni', 'nombre', 'telefono', 'direccion'];
        foreach ($campos as $campo) {
            if (empty($input[$campo])) {
                http_response_code(400);
                echo json_encode(["error" => "El campo $campo es obligatorio"]);
                return;
            }
        }
        $foto = isset($input['foto']) ? $input['foto'] : 'default.png';
        $id_user = isset($input['id_user']) ? $input['id_user'] : 1;
        $result = $model->registrarCliente($input['dni'], $input['nombre'], $input['telefono'], $input['direccion'], $foto, $id_user);
        if ($result === "ok") {
            echo json_encode(["success" => true, "message" => "Cliente registrado correctamente"]);
        } elseif ($result === "existe") {
            http_response_code(409);
            echo json_encode(["error" => "El cliente ya existe"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al registrar el cliente"]);
        }
    }

    public function apiActualizar($id) {
        require_once __DIR__ . '/../Models/ClientesModel.php';
        $model = new \ClientesModel();
        $input = json_decode(file_get_contents('php://input'), true);
        $cliente = $model->editarCli($id);
        if (!$cliente) {
            http_response_code(404);
            echo json_encode(["error" => "Cliente no encontrado"]);
            return;
        }
        $camposPermitidos = ["dni", "nombre", "telefono", "direccion", "foto"];
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
        // Usar los datos actuales si no se envía algún campo
        $datosFinales = [
            isset($datosActualizar['dni']) ? $datosActualizar['dni'] : $cliente['dni'],
            isset($datosActualizar['nombre']) ? $datosActualizar['nombre'] : $cliente['nombre'],
            isset($datosActualizar['telefono']) ? $datosActualizar['telefono'] : $cliente['telefono'],
            isset($datosActualizar['direccion']) ? $datosActualizar['direccion'] : $cliente['direccion'],
            isset($datosActualizar['foto']) ? $datosActualizar['foto'] : $cliente['foto'],
            $id
        ];
        $result = $model->modificarCliente(...$datosFinales);
        if ($result === "modificado") {
            echo json_encode(["success" => true, "message" => "Cliente actualizado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar el cliente"]);
        }
    }

    public function apiEliminar($id) {
        require_once __DIR__ . '/../Models/ClientesModel.php';
        $model = new \ClientesModel();
        $result = $model->accionCli(0, $id);
        if ($result == 1) {
            echo json_encode(["success" => true, "message" => "Cliente eliminado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el cliente"]);
        }
    }
    protected $id_user;
    public function __construct()
    {
        $isApi = (strpos($_SERVER['REQUEST_URI'], '/api/') !== false);
        if ($isApi) {
            // API: no sesión, no redirección
            $this->id_user = 1;
        } else {
            // Web: requiere sesión y base_url
            session_start();
            if (empty($_SESSION['activo'])) {
                header("location: " . base_url);
            }
            $this->id_user = $_SESSION['id_usuario'];
        }
        parent::__construct();
    }
        public function get($id) {
    require_once __DIR__ . '/../Models/ClientesModel.php';
    $model = new ClientesModel();
    $data = $model->editarCli($id);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        public function getAll() {
    require_once __DIR__ . '/../Models/ClientesModel.php';
    $model = new ClientesModel();
    $data = $model->getClientes(1);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        public function create($data) {
        require_once __DIR__ . '/../Models/ClientesModel.php';
        $model = new ClientesModel();
        $campos = ['dni', 'nombre', 'telefono', 'direccion'];
        foreach ($campos as $campo) {
            if (empty($data[$campo])) {
                http_response_code(400);
                echo json_encode(["error" => "El campo $campo es obligatorio"]);
                return;
            }
        }
        $foto = isset($data['foto']) ? $data['foto'] : 'default.png';
        $id_user = isset($data['id_user']) ? $data['id_user'] : 1;
        $result = $model->registrarCliente($data['dni'], $data['nombre'], $data['telefono'], $data['direccion'], $foto, $id_user);
        if ($result === "ok") {
            echo json_encode(["success" => true, "message" => "Cliente registrado correctamente"]);
        } elseif ($result === "existe") {
            http_response_code(409);
            echo json_encode(["error" => "El cliente ya existe"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al registrar el cliente"]);
        }
        }

        public function update($id, $data) {
        require_once __DIR__ . '/../Models/ClientesModel.php';
        $model = new ClientesModel();
        $cliente = $model->editarCli($id);
        if (!$cliente) {
            http_response_code(404);
            echo json_encode(["error" => "Cliente no encontrado"]);
            return;
        }
        $camposPermitidos = ["dni", "nombre", "telefono", "direccion", "foto"];
        $datosActualizar = [];
        foreach ($camposPermitidos as $campo) {
            if (array_key_exists($campo, $data)) {
                $datosActualizar[$campo] = $data[$campo];
            }
        }
        if (empty($datosActualizar)) {
            http_response_code(400);
            echo json_encode(["error" => "No se enviaron campos válidos para actualizar"]);
            return;
        }
        $datosFinales = [
            isset($datosActualizar['dni']) ? $datosActualizar['dni'] : $cliente['dni'],
            isset($datosActualizar['nombre']) ? $datosActualizar['nombre'] : $cliente['nombre'],
            isset($datosActualizar['telefono']) ? $datosActualizar['telefono'] : $cliente['telefono'],
            isset($datosActualizar['direccion']) ? $datosActualizar['direccion'] : $cliente['direccion'],
            isset($datosActualizar['foto']) ? $datosActualizar['foto'] : $cliente['foto'],
            $id
        ];
        $result = $model->modificarCliente(...$datosFinales);
        if ($result === "modificado") {
            echo json_encode(["success" => true, "message" => "Cliente actualizado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar el cliente"]);
        }
        }

        public function delete($id) {
        require_once __DIR__ . '/../Models/ClientesModel.php';
        $model = new ClientesModel();
        $result = $model->accionCli(0, $id);
        if ($result == 1) {
            echo json_encode(["success" => true, "message" => "Cliente eliminado correctamente"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar el cliente"]);
        }
        }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    public function listar()
    {
        $data = $this->model->getClientes(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
            $data[$i]['foto'] = '<img class="img-thumbnail" src="' . base_url . "Assets/images/clientes/" . $data[$i]['foto'] . '" width="50">';
            $data[$i]['editar'] = '<button class="btn btn-outline-primary" type="button" onclick="btnEditarCli(' . $data[$i]['id'] . ');"><i class="fas fa-edit"></i></button>';
            $data[$i]['eliminar'] = '<button class="btn btn-outline-danger" type="button" onclick="btnEliminarCli(' . $data[$i]['id'] . ');"><i class="fas fa-trash-alt"></i></button>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registrar()
    {
        $dni = strClean($_POST['dni']);
        $nombre = strClean($_POST['nombre']);
        $telefono = strClean($_POST['telefono']);
        $direccion = strClean($_POST['direccion']);
        $img = $_FILES['foto'];
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $fecha = date("YmdHis");
        $id = strClean($_POST['id']);
        if (empty($nombre) || empty($telefono) || empty($direccion)) {
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
                    $destino = "Assets/images/clientes/" . $imgNombre;
                }
            } else if (!empty($_POST['foto_actual']) && empty($name)) {
                $imgNombre = $_POST['foto_actual'];
            } else {
                $imgNombre = "default.png";
            }
            if ($id == "") {
                $data = $this->model->registrarCliente($dni, $nombre, $telefono, $direccion,$imgNombre, $this->id_user);
                if ($data == "ok") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpname, $destino);
                    }
                    $msg = array('msg' => 'Cliente registrado con éxito', 'icono' => 'success');
                } else if ($data == "existe") {
                    $msg = array('msg' => 'El cliente ya existe', 'icono' => 'warning');
                } else {
                    $msg = array('msg' => 'Error al registrar el cliente', 'icono' => 'error');
                }
            } else {
                $data = $this->model->modificarCliente($dni, $nombre, $telefono, $direccion,$imgNombre, $id);
                if ($data == "modificado") {
                    if (!empty($name)) {
                        move_uploaded_file($tmpname, $destino);
                    }
                    $msg = array('msg' => 'Cliente modificado', 'icono' => 'success');
                } else {
                    $msg = array('msg' => 'Error al modificar el cliente', 'icono' => 'error');
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar($id)
    {
        $data = $this->model->editarCli($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function eliminar($id)
    {
        $data = $this->model->accionCli(0, $id);
        if ($data == 1) {
            $msg = array('msg' => 'Cliente dado de baja', 'icono' => 'success');
        } else {
            $msg = array('msg' => 'Error al eliminar el cliente', 'icono' => 'error');
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Pagos
    public function pagos()
    {
        $this->views->getView($this, "pagos");
    }
    public function listar_pagos()
    {
        $data = $this->model->getPagos();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['ver'] = '';
            $data[$i]['estado'] = '<span class="badge bg-success">Pagado</span>';
            $data[$i]['ver'] = '<a class="btn btn-outline-danger" href="' . base_url . 'clientes/pdfPago/' . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function verpagos($id)
    {
        $data['pagos'] = $this->model->ver_pagos($id);
        $this->views->getView($this, "ver_pagos", $data);
    }
    //Plan
    public function plan()
    {
        $this->views->getView($this, "plan");
    }
    public function buscarCliente()
    {
        if (isset($_GET['cli'])) {
            $data = $this->model->buscarCliente($_GET['cli']);
            $datos = array();
            foreach ($data as $row) {
                $data['id'] = $row['id'];
                $data['label'] = $row['nombre'] . ' - ' . $row['direccion'];
                $data['value'] = $row['nombre'];
                $data['direccion'] = $row['direccion'];
                array_push($datos, $data);
            }
        }
        if (isset($_GET['plan'])) {
            $data = $this->model->buscarPlanCliente($_GET['plan']);
            $datos = array();
            foreach ($data as $row) {
                $data['id'] = $row['id_detalle'];
                $data['label'] = $row['nombre'] . ' - ' . $row['plan'] . ' - ' . $row['precio_plan'];
                $data['value'] = $row['nombre'];
                $data['plan'] = $row['plan'];
                $data['precio'] = $row['precio_plan'];
                $data['vencimiento'] = $row['fecha_venc'];
                array_push($datos, $data);
            }
        }
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscarPlan($id)
    {
        $data = $this->model->buscarPlanes($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function buscar_planes()
    {
        if (isset($_GET['q'])) {
            $data = $this->model->buscar_planes($_GET['q']);
            $datos = array();
            foreach ($data as $row) {
                $data['id'] = $row['id'];
                $data['label'] = $row['plan'] . ' - ' . $row['precio_plan'];
                $data['value'] = $row['plan'];
                $data['precio_plan'] = $row['precio_plan'];
                array_push($datos, $data);
            }
            echo json_encode($datos, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function listar_plan_clientes()
    {
        $data = $this->model->getPlanCliente();
        $fecha = date('Y-m-d');
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['fecha_actual'] = $fecha;
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<span class="badge bg-success">Activo</span>';
                $data[$i]['accion'] = '<div>
                    <button class="btn btn-outline-primary" type="button" onclick="pagoPlan(' . $data[$i]['id'] . ');"><i class="fas fa-dollar-sign"></i></button>
                    <a class="btn btn-outline-danger" href="' . base_url . 'clientes/verpagos/' . $data[$i]['id_cliente'] . '"><i class="fas fa-eye"></i></a>
                    <button class="btn btn-outline-warning" type="button" onclick="desactivar(' . $data[$i]['id'] . ');"><i class="fas fa-ban"></i></button>
                </div>';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-danger">Desabilitado</span>';
                $data[$i]['accion'] = '<a class="btn btn-outline-danger" href="' . base_url . 'clientes/verpagos/' . $data[$i]['id_cliente'] . '"><i class="fas fa-eye"></i></a>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function ver($id)
    {
        $data = $this->model->ver($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function procesarPago($id)
    {
        if (!is_numeric($id)) {
            $msg = array('msg' => 'Error desconocido', 'icono' => 'warning');
        } else {
            $lista = $this->model->ver($id);
            $id_cli = $lista['id_cli'];
            $id_plan = $lista['id_plan'];
            $precio = $lista['precio_plan'];
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $data = $this->model->registrarPagoCliente($id, $id_cli, $id_plan, $precio, $fecha, $hora, $this->id_user);
            if ($data > 0) {
                $msg = array('msg' => 'Pago registrado con éxito', 'icono' => 'success', 'id_pago' => $data);
            } else {
                $msg = array('msg' => 'Error al realizar el pago', 'icono' => 'error');
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function pdfPago($id)
    {
        $empresa = $this->model->getEmpresa();
        $data = $this->model->getPdf($id);
        require('Libraries/fpdf/html2pdf.php');

        $pdf = new PDF_HTML('P', 'mm', array(80, 200));
        $pdf->AddPage();
        $pdf->SetMargins(1, 0, 0);
        $pdf->SetTitle('Reporte Pago');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(70, 8, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image('Assets/images/logo.png', 5, 5, 20, 20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, 'CI: ', 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 5, $empresa['ruc'], 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, utf8_decode('Teléfono: '), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 5, $empresa['telefono'], 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, utf8_decode('Dirección: '), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(40, 5, utf8_decode($empresa['direccion']), 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, 'Fecha: ', 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 5, $data['fecha'], 0, 1, 'L');
        //Encabezado
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 10, 'Datos del Cliente', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(78, 5, 'Documento: ' . $data['dni'], 0, 1, 'L');
        $pdf->MultiCell(78, 5, 'Nombre: ' . utf8_decode($data['nombre']), 0, 'L');
        $pdf->Cell(78, 5, utf8_decode('Direccion: ' . $data['direccion']), 0, 1, 'L');
        $pdf->MultiCell(78, 5, utf8_decode('Plan: ' . $data['plan']), 0, 'L');
        $pdf->Cell(78, 5, utf8_decode('Pago: ' . $data['precio_plan']), 0, 1, 'L');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(78, 5, utf8_decode('Vencimiento: ' . $this->formatoFecha($data['fecha_venc'])), 0, 1, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln();
        $pdf->WriteHtml(utf8_decode($empresa['mensaje']));

        $pdf->Output();
    }
    public function pdfPagos($id_cliente)
    {
        $empresa = $this->model->getEmpresa();
        $result = $this->model->getPdfCliente($id_cliente);
        require('Libraries/fpdf/html2pdf.php');

        $pdf = new PDF_HTML('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetMargins(10, 0, 0);
        $pdf->SetTitle('Reporte Pago');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(70, 8, utf8_decode($empresa['nombre']), 0, 1, 'C');
        $pdf->Image('Assets/images/logo.png', 5, 5, 20, 20);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, 'CI: ', 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 5, $empresa['ruc'], 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, utf8_decode('Teléfono: '), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 5, $empresa['telefono'], 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 5, utf8_decode('Dirección: '), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 5, utf8_decode($empresa['direccion']), 0, 1, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(240, 5, 'Fecha: ', 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 5, date('d/m/Y'), 0, 1, 'L');
        //Encabezado
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(260, 10, 'Datos del Cliente', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(20, 8, 'Documento', 0, 0, 'L', true);
        $pdf->Cell(50, 8, utf8_decode('Direccion'), 0, 0, 'L', true);
        $pdf->Cell(120, 8, 'Plan', 0, 0, 'L', true);
        $pdf->Cell(20, 8, 'Monto', 0, 0, 'L', true);
        $pdf->Cell(30, 8, 'Fecha', 0, 0, 'L', true);        
        $pdf->Cell(35, 8, utf8_decode('Vencimiento'), 0, 1, 'C', true);
        $pdf->SetTextColor(0, 0, 0);
        foreach ($result as $row) {
            $pdf->Cell(20, 8, $row['dni'], 1, 0, 'L');
            $pdf->Cell(50, 8, utf8_decode($row['direccion']), 1, 0, 'L');
            $pdf->Cell(120, 8, utf8_decode($row['plan']), 1, 0, 'L');
            $pdf->Cell(20, 8, utf8_decode($row['precio']), 1, 0, 'L');
            $pdf->Cell(30, 8, utf8_decode($row['fecha']), 1, 0, 'L');
            $pdf->Cell(35, 8, utf8_decode($this->formatoFecha($row['fecha_venc'])), 1, 1, 'C');
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln();
        $pdf->MultiCell(260, 8, utf8_decode($empresa['mensaje']), 0, 'C');

        $pdf->Output();
    }
    function formatoFecha($fecha)
    {

        $num = date("j", strtotime($fecha));

        $anno = date("Y", strtotime($fecha));

        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

        $mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];

        return $num . ' de ' . $mes . ' del ' . $anno;
    }
    public function pdfCredencial($id)
{
    $empresa = $this->model->getEmpresa();  // Obtener datos de la empresa
    $data = $this->model->ver($id);  // Obtener datos del cliente por su ID
    require('Libraries/fpdf/html2pdf.php');  // Incluir la librería FPDF

    $pdf = new PDF_HTML('P', 'mm', array(85, 120));  // Formato pequeño tipo credencial
    $pdf->AddPage();
    $pdf->SetMargins(5, 5, 5);
    $pdf->SetTitle('Credencial Cliente');
    
    // Logo de la empresa
    $pdf->Image('Assets/images/logo.png', 5, 5, 20, 20);
    
    // Encabezado: Nombre de la empresa
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, utf8_decode($empresa['nombre']), 0, 1, 'C');
    $pdf->Ln(5);

    // Foto del cliente
    $rutaFoto = 'Assets/images/clientes/' . ($data['foto'] ?? 'default.png');
    $pdf->Image($rutaFoto, 30, 25, 40, 40);  // Centrada en la parte superior

    $pdf->Ln(50);

    // Información del cliente
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, 'Nombre:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 8, utf8_decode($data['nombre']), 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, 'DNI:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 8, $data['dni'], 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, 'Teléfono:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 8, $data['telefono'], 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, utf8_decode('Dirección:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(40, 8, utf8_decode($data['direccion']), 0, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 8, 'Fecha:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 8, date('d/m/Y'), 0, 1, 'L');

    $pdf->Ln(10);

    // Pie de página: Mensaje de la empresa
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->MultiCell(0, 5, utf8_decode($empresa['mensaje']), 0, 'C');

    // Generar el PDF
    $pdf->Output();
}
}

<?php

use Luecano\NumeroALetras\NumeroALetras;
use PHPMailer\PHPMailer\PHPMailer;

class Home extends Controller
{
    public function __construct() {
        session_start();
        if (!empty($_SESSION['activo'])) {
            header("location: ".base_url. "administracion/home");
        }
        parent::__construct();
    }
    public function index()
    {
        $data['empresa'] = $this->model->getEmpresa();
        $data['planes'] = $this->model->getPlanes(1);
        $data['entrenador'] = $this->model->getDatos('entrenador');
        $data['clientes'] = $this->model->getDatos('clientes');
        $data['usuarios'] = $this->model->getUsuarios(1);
        $this->views->getView($this, "index", $data);
    }
    public function login()
    {
        $this->views->getView($this, "login");
    }
    public function salir()
    {
        session_destroy();
        header("location: " . base_url);
    }
    function formatoFecha($fecha)
    {

        $num = date("j", strtotime($fecha));

        $anno = date("Y", strtotime($fecha));

        $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

        $mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];

        return $num . ' de ' . $mes . ' del ' . $anno;
    }
}

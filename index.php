<?php
// Requiere el archivo de configuración que contiene las constantes y la URL base.
require_once 'Config/Config.php';

// Obtiene la ruta solicitada desde la URL, o asigna 'home/index' por defecto si no se especifica.
$ruta = !empty($_GET['url']) ? $_GET['url'] : "home/index";

// Divide la ruta en partes utilizando '/' como delimitador.
$array = explode("/", $ruta);

// El primer elemento de la ruta corresponde al controlador solicitado (capitalizado).
$controller = ucfirst($array[0]);

// Define el método a ejecutar; por defecto será 'index'.
$metodo = "index";

// Inicializa la variable para contener los parámetros opcionales.
$parametro = "";

// Verifica si hay un segundo segmento en la URL para el método.
if (!empty($array[1])) {
    if (!empty($array[1] != "")) {
        $metodo = $array[1];  // Asigna el método solicitado.
    }
}

// Verifica si existen más segmentos en la URL que actúan como parámetros.
if (!empty($array[2])) {
    if (!empty($array[2] != "")) {
        // Recorre los segmentos adicionales a partir del tercer elemento para concatenarlos como parámetros.
        for ($i = 2; $i < count($array); $i++) {
            $parametro .= $array[$i] . ",";  // Añade cada parámetro separado por comas.
        }
        $parametro = trim($parametro, ",");  // Elimina la coma final sobrante.
    }
}

// Carga los archivos necesarios para el autoload de clases y funciones auxiliares.
require_once 'Config/App/Autoload.php';
require_once 'Config/Helpers.php';

// Define la ruta del archivo del controlador correspondiente.
$dirControllers = "Controllers/" . $controller . ".php";

// Verifica si el archivo del controlador existe.
if (file_exists($dirControllers)) {
    require_once $dirControllers;  // Carga el archivo del controlador.

    // Crea una instancia del controlador.
    $controller = new $controller();

    // Verifica si el método solicitado existe en el controlador.
    if (method_exists($controller, $metodo)) {
        // Llama al método con los parámetros si existen.
        $controller->$metodo($parametro);
    } else {
        // Redirige a la página de errores si el método no existe.
        header('Location: ' . base_url . 'Errors');
    }
} else {
    // Redirige a la página de errores si el controlador no existe.
    header('Location: ' . base_url . 'Errors');
}
?>

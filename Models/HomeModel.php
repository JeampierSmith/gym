<?php
class HomeModel extends Query{
    public function __construct()
    {
        // Llamada al constructor de la clase padre para inicializar la conexión con la base de datos.
        parent::__construct();
    }

    // Método para obtener los planes que tienen un estado específico.
    public function getPlanes(int $estado)
    {
        // Consulta SQL para seleccionar todos los planes que coincidan con el estado dado.
        $sql = "SELECT * FROM planes WHERE estado = $estado";
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data; // Retorna los datos obtenidos.
    }

    // Método para obtener la configuración de la empresa.
    public function getEmpresa()
    {
        // Consulta SQL para seleccionar todos los registros de la tabla de configuración.
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql); // Ejecuta la consulta y devuelve el resultado.
        return $data; // Retorna los datos obtenidos.
    }

    // Método para obtener los usuarios que tienen un estado específico.
    public function getUsuarios(int $estado)
    {
        // Consulta SQL para seleccionar ciertos campos de los usuarios que coincidan con el estado dado.
        $sql = "SELECT nombre, correo, foto, estado FROM usuarios WHERE estado = $estado";
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data; // Retorna los datos obtenidos.
    }

    // Método genérico para obtener el conteo total de registros activos en una tabla específica.
    public function getDatos($table)
    {
        // Consulta SQL para contar los registros que tienen estado activo (estado = 1) en la tabla especificada.
        $sql = "SELECT COUNT(id) AS total FROM $table WHERE estado = 1";
        $data = $this->select($sql); // Ejecuta la consulta y devuelve el resultado.
        return $data; // Retorna el conteo de registros.
    }
}
?>

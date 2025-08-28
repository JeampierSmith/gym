<?php
class EntrenadorModel extends Query
{
    public function __construct()
    {
        // Llamada al constructor de la clase padre para inicializar la conexión con la base de datos.
        parent::__construct();
    }

    // Método para obtener los entrenadores que tienen un estado específico.
    public function getEntrenador($estado)
    {
        // Consulta SQL para seleccionar todos los entrenadores que coincidan con el estado dado.
        $sql = "SELECT * FROM entrenador WHERE estado = $estado";
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data; // Retorna los datos obtenidos.
    }

    // Método para registrar un nuevo entrenador en la base de datos.
    public function registrar($nombre, $apellido, $telefono, $correo, $direccion)
    {
        // Consulta para verificar si ya existe un entrenador con el mismo nombre.
        $verficar = "SELECT * FROM entrenador WHERE nombre = '$nombre'";
        $existe = $this->select($verficar); // Ejecuta la consulta para verificar existencia.
        if (empty($existe)) {
            // Si no existe, inserta un nuevo registro en la tabla de entrenadores.
            $sql = "INSERT INTO entrenador(nombre, apellido, telefono, correo, direccion) VALUES (?,?,?,?,?)";
            $datos = array($nombre, $apellido, $telefono, $correo, $direccion); // Datos para la inserción.
            $data = $this->save($sql, $datos); // Ejecuta la inserción y guarda el resultado.
            if ($data == 1) {
                $res = "ok"; // Respuesta si el registro fue exitoso.
            } else {
                $res = "error"; // Respuesta si hubo algún error.
            }
        } else {
            $res = "existe"; // Respuesta si ya existe un entrenador con ese nombre.
        }
        return $res; // Retorna el resultado de la operación.
    }

    // Método para modificar los datos de un entrenador existente.
    public function modificar($nombre, $apellido, $telefono, $correo, $direccion, $id)
    {
        // Consulta SQL para actualizar los datos de un entrenador específico basado en su ID.
        $sql = "UPDATE entrenador SET nombre = ?, apellido = ?, telefono = ?, correo = ?, direccion = ? WHERE id = ?";
        $datos = array($nombre, $apellido, $telefono, $correo, $direccion, $id); // Datos para la actualización.
        $data = $this->save($sql, $datos); // Ejecuta la actualización y guarda el resultado.
        if ($data == 1) {
            $res = "modificado"; // Respuesta si la modificación fue exitosa.
        } else {
            $res = "error"; // Respuesta si hubo algún error.
        }
        return $res; // Retorna el resultado de la operación.
    }

    // Método para obtener los datos de un entrenador específico por ID.
    public function editar($id)
    {
        // Consulta SQL para seleccionar un entrenador basado en su ID.
        $sql = "SELECT * FROM entrenador WHERE id = $id";
        $data = $this->select($sql); // Ejecuta la consulta y devuelve el resultado.
        return $data; // Retorna los datos obtenidos.
    }

    // Método para cambiar el estado de un entrenador (activar/desactivar).
    public function accion($estado, $id)
    {
        // Consulta SQL para actualizar el estado de un entrenador basado en su ID.
        $sql = "UPDATE entrenador SET estado = ? WHERE id = ?";
        $datos = array($estado, $id); // Datos para la actualización.
        $data = $this->save($sql, $datos); // Ejecuta la actualización y guarda el resultado.
        return $data; // Retorna el resultado de la operación.
    }
}
?>

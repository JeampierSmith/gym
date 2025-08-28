<?php
// Definición de la clase RutinasModel que hereda de Query.
class RutinasModel extends Query
{
    // Constructor que llama al constructor de la clase padre.
    public function __construct()
    {
        parent::__construct();
    }

    // Obtiene todas las rutinas según su estado (1: activas, 0: inactivas).
    public function getRutinas($estado)
    {
        $sql = "SELECT * FROM rutinas WHERE estado = $estado";
        $data = $this->selectAll($sql);  // Ejecuta la consulta para obtener múltiples resultados.
        return $data;  // Devuelve la lista de rutinas.
    }

    // Registra una nueva rutina si no existe ya una con el mismo día.
    public function registrar($dia, $descripcion, $user)
    {
        $verficar = "SELECT * FROM rutinas WHERE dia = '$dia'";
        $existe = $this->select($verficar);  // Verifica si ya existe una rutina para ese día.

        if (empty($existe)) {
            // Si no existe, inserta la nueva rutina.
            $sql = "INSERT INTO rutinas(dia, descripcion, id_user) VALUES (?,?,?)";
            $datos = array($dia, $descripcion, $user);
            $data = $this->save($sql, $datos);  // Guarda los datos.

            // Verifica si la operación fue exitosa.
            $res = $data == 1 ? "ok" : "error";
        } else {
            $res = "existe";  // Si la rutina ya existe, devuelve 'existe'.
        }
        return $res;  // Devuelve el resultado.
    }

    // Modifica una rutina existente.
    public function modificar($dia, $descripcion, $id)
    {
        $sql = "UPDATE rutinas SET dia = ?, descripcion = ? WHERE id = ?";
        $datos = array($dia, $descripcion, $id);
        $data = $this->save($sql, $datos);  // Guarda los cambios.

        // Verifica si la operación fue exitosa.
        $res = $data == 1 ? "modificado" : "error";
        return $res;  // Devuelve el resultado.
    }

    // Obtiene los datos de una rutina específica por su ID.
    public function editar($id)
    {
        $sql = "SELECT * FROM rutinas WHERE id = $id";
        $data = $this->select($sql);  // Ejecuta la consulta.
        return $data;  // Devuelve los datos de la rutina.
    }

    // Activa o desactiva una rutina cambiando su estado.
    public function accion($estado, $id)
    {
        $sql = "UPDATE rutinas SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);  // Guarda el nuevo estado.
        return $data;  // Devuelve el resultado de la operación.
    }
}
?>

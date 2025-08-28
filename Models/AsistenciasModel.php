<?php
class AsistenciasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las asistencias con información del cliente, entrenador y rutina
    public function getAsistencias()
    {
        $sql = "SELECT a.*, c.id, c.nombre, e.id, e.nombre AS entrenador, r.id, r.descripcion FROM asistencias a INNER JOIN clientes c ON c.id = a.id_cliente INNER JOIN entrenador e ON e.id = a.id_entrenador INNER JOIN rutinas r ON r.id = a.id_rutina";
        $data = $this->selectAll($sql);
        return $data;
    }

    // Registrar asistencia de un cliente, verificando que no exista otra asistencia en la misma fecha
    public function registrar($fecha, $entrada, $id_cliente, $id_entrenador, $id_rutina, $user)
    {
        $verficar = "SELECT * FROM asistencias WHERE fecha = '$fecha' AND id_cliente = $id_cliente AND estado = 1";
        $existe = $this->select($verficar);
        if (empty($existe)) {
            $sql = "INSERT INTO asistencias(fecha, hora_entrada, id_cliente, id_entrenador, id_rutina, id_usuario) VALUES (?,?,?,?,?,?)";
            $datos = array($fecha, $entrada, $id_cliente, $id_entrenador, $id_rutina, $user);
            $data = $this->save($sql, $datos);
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
        return $res;
    }

    // Actualizar la hora de salida y estado de una asistencia
    public function accion($salida, $estado, $id)
    {
        $sql = "UPDATE asistencias SET hora_salida=?, estado = ? WHERE id_asistencia = ?";
        $datos = array($salida, $estado, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    // Buscar entrenador por nombre
    public function buscarEntrenador($valor)
    {
        $sql = "SELECT id, nombre, direccion FROM entrenador WHERE nombre LIKE '%" . $valor . "%' AND estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    // Buscar rutina por día o descripción
    public function buscarRutina($valor)
    {
        $sql = "SELECT id, dia, descripcion FROM rutinas WHERE dia LIKE '%" . $valor . "%' AND estado = 1 OR descripcion LIKE '%" . $valor . "%' AND estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
}


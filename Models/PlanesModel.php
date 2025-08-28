<?php
// Definición de la clase PlanesModel que hereda de Query.
class PlanesModel extends Query
{
    // Constructor que llama al constructor de la clase padre.
    public function __construct()
    {
        parent::__construct();
    }

    // Obtiene todos los planes según su estado (1: activos, 0: inactivos).
    public function getPlanes($estado)
    {
        $sql = "SELECT * FROM planes WHERE estado = $estado";
        return $this->selectAll($sql);
    }

    // Registra un nuevo plan si no existe otro con el mismo nombre.
    public function registrarPlan($plan, $descripcion, $precio_plan, $condicion, $img, $user)
    {
        $verificar = "SELECT * FROM planes WHERE plan = '$plan'";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $sql = "INSERT INTO planes(plan, descripcion, precio_plan, condicion, imagen, id_user) VALUES (?,?,?,?,?,?)";
            $datos = array($plan, $descripcion, $precio_plan, $condicion, $img, $user);
            $data = $this->save($sql, $datos);
            return $data == 1 ? "ok" : "error";
        } else {
            return "existe";
        }
    }

    // Modifica un plan existente.
    public function modificarPlan($plan, $descripcion, $precio_plan, $condicion, $img, $id)
    {
        $sql = "UPDATE planes SET plan = ?, descripcion = ?, precio_plan = ?, condicion = ?, imagen = ? WHERE id = ?";
        $datos = array($plan, $descripcion, $precio_plan, $condicion, $img, $id);
        $data = $this->save($sql, $datos);
        return $data == 1 ? "modificado" : "error";
    }

    // Obtiene los datos de un plan específico por su ID.
    public function editarPlan($id)
    {
        $sql = "SELECT * FROM planes WHERE id = $id";
        return $this->select($sql);
    }

    // Cambia el estado de un plan (activar/desactivar).
    public function accionPlan($estado, $id)
    {
        $sql = "UPDATE planes SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        return $this->save($sql, $datos);
    }

    // Registra la suscripción de un cliente a un plan.
    public function registrarPlanCliente($id_cli, $id_plan, $fecha, $hora, $fecha_venc, $fecha_limite, $user)
    {
        $verificar = "SELECT * FROM detalle_planes WHERE id_cliente = $id_cli AND id_plan = $id_plan AND estado = 1";
        $existe = $this->select($verificar);

        if (empty($existe)) {
            $sql = "INSERT INTO detalle_planes(id_cliente, id_plan, fecha, hora, fecha_venc, fecha_limite, id_user) VALUES (?,?,?,?,?,?,?)";
            $datos = array($id_cli, $id_plan, $fecha, $hora, $fecha_venc, $fecha_limite, $user);
            $data = $this->save($sql, $datos);
            return $data == 1 ? "ok" : "error";
        } else {
            return "existe";
        }
    }

    // Obtiene la configuración de la empresa.
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        return $this->select($sql);
    }

    // Desactiva un plan específico.
    public function desactivarPlan($estado, $id)
    {
        $sql = "UPDATE detalle_planes SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);
        return $data == 1 ? "ok" : "error";
    }

    // Consulta los detalles de una suscripción específica.
    public function consultarDetalle($id)
    {
        $sql = "SELECT d.*, p.id, p.precio_plan 
                FROM detalle_planes d 
                INNER JOIN planes p ON p.id = d.id_plan 
                WHERE d.id = $id";
        return $this->select($sql);
    }

    // Actualiza las fechas de vencimiento y límite de una suscripción.
    public function registrarPago($fecha_venc, $fecha_limite, $id)
    {
        $sql = "UPDATE detalle_planes SET fecha_venc = ?, fecha_limite = ? WHERE id = ?";
        $datos = array($fecha_venc, $fecha_limite, $id);
        $data = $this->save($sql, $datos);
        return $data == 1 ? "ok" : "error";
    }

    // Registra el pago de una suscripción.
    public function registrarDetallePago($id_detalle, $id_cli, $id_plan, $precio, $fecha, $hora, $id_user)
    {
        $sql = "INSERT INTO pagos_planes (id_detalle, id_cliente, id_plan, precio, fecha, hora, id_user) VALUES (?,?,?,?,?,?,?)";
        $datos = array($id_detalle, $id_cli, $id_plan, $precio, $fecha, $hora, $id_user);
        $data = $this->insertar($sql, $datos);
        return $data ? $data : 0;
    }
}
?>

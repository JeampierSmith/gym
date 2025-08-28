<?php
class ClientesModel extends Query {
    public function __construct() {
        // Llamada al constructor de la clase padre para inicializar la conexión con la base de datos.
        parent::__construct();
    }

    // Método para obtener los datos de la empresa.
    public function getEmpresa() {
        $sql = "SELECT * FROM configuracion"; // Consulta SQL para obtener la configuración de la empresa.
        $data = $this->select($sql); // Ejecuta la consulta y devuelve el resultado.
        return $data;
    }

    // Método para obtener todos los clientes que tienen un estado específico.
    public function getClientes($estado) {
        $sql = "SELECT * FROM clientes WHERE estado = $estado"; // Consulta SQL para obtener clientes por estado.
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data;
    }

    // Método para buscar clientes según un valor, utilizado para agregar un plan.
    public function buscarCliente($valor) {
        $sql = "SELECT id, nombre, direccion FROM clientes WHERE nombre LIKE '%" . $valor . "%' AND estado = 1"; // Consulta para buscar clientes activos por nombre.
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data;
    }

    // Método para buscar planes de un cliente, utilizado para agregar un pago.
    public function buscarPlanCliente($valor) {
        $sql = "SELECT c.id, c.nombre, c.estado, d.id AS id_detalle, d.id_cliente, d.id_plan, d.fecha_venc, d.fecha_limite, p.id, p.plan, p.precio_plan FROM clientes c INNER JOIN detalle_planes d ON d.id_cliente = c.id INNER JOIN planes p ON p.id = d.id_plan WHERE c.nombre LIKE '%" . $valor . "%' AND c.estado = 1"; // Consulta para buscar planes asociados a un cliente activo por nombre.
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data;
    }

    // Método para buscar los planes de un cliente específico por su ID.
    public function buscarPlanes($id) {
        $sql = "SELECT d.id, d.id_cliente, d.id_plan, p.id AS id_, p.plan FROM detalle_planes d INNER JOIN planes p ON d.id_plan = p.id WHERE d.id_cliente = $id"; // Consulta para obtener los planes asociados a un cliente por su ID.
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data;
    }

    // Método para buscar planes por nombre.
    public function buscar_planes($valor) {
        $sql = "SELECT id, plan, precio_plan FROM planes WHERE plan LIKE '%" . $valor . "%' AND estado = 1"; // Consulta para buscar planes activos por nombre.
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data;
    }

    // Método para registrar un nuevo cliente.
    public function registrarCliente($dni, $nombre, $telefono, $direccion, $foto, $id_user) {
        $verficar = "SELECT * FROM clientes WHERE dni = '$dni'"; // Consulta para verificar si el cliente ya existe por su DNI.
        $existe = $this->select($verficar); // Ejecuta la consulta para verificar existencia.
        if (empty($existe)) {
            // Si no existe, inserta un nuevo registro en la tabla de clientes.
            $sql = "INSERT INTO clientes(dni, nombre, telefono, direccion, foto, id_user) VALUES (?,?,?,?,?,?)";
            $datos = array($dni, $nombre, $telefono, $direccion, $foto, $id_user); // Datos para la inserción.
            $data = $this->save($sql, $datos); // Ejecuta la inserción y guarda el resultado.
            if ($data == 1) {
                $res = "ok"; // Respuesta si el registro fue exitoso.
            } else {
                $res = "error"; // Respuesta si hubo algún error.
            }
        } else {
            $res = "existe"; // Respuesta si ya existe un cliente con ese DNI.
        }
        return $res; // Retorna el resultado de la operación.
    }

    // Método para modificar los datos de un cliente existente.
    public function modificarCliente($dni, $nombre, $telefono, $direccion, $foto, $id) {
        $sql = "UPDATE clientes SET dni = ?, nombre = ?, telefono = ?, direccion = ?, foto = ? WHERE id = ?"; // Consulta SQL para actualizar los datos de un cliente.
        $datos = array($dni, $nombre, $telefono, $direccion,$foto, $id); // Datos para la actualización.
        $data = $this->save($sql, $datos); // Ejecuta la actualización y guarda el resultado.
        if ($data == 1) {
            $res = "modificado"; // Respuesta si la modificación fue exitosa.
        } else {
            $res = "error"; // Respuesta si hubo algún error.
        }
        return $res; // Retorna el resultado de la operación.
    }

    // Método para obtener los datos de un cliente específico por ID.
    public function editarCli($id) {
        $sql = "SELECT * FROM clientes WHERE id = $id"; // Consulta SQL para seleccionar un cliente basado en su ID.
        $data = $this->select($sql); // Ejecuta la consulta y devuelve el resultado.
        return $data;
    }

    // Método para cambiar el estado de un cliente (activar/desactivar).
    public function accionCli($estado, $id) {
        $sql = "UPDATE clientes SET estado = ? WHERE id = ?"; // Consulta SQL para actualizar el estado de un cliente basado en su ID.
        $datos = array($estado, $id); // Datos para la actualización.
        $data = $this->save($sql, $datos); // Ejecuta la actualización y guarda el resultado.
        return $data; // Retorna el resultado de la operación.
    }

    // Método para obtener todos los pagos realizados.
    public function getPagos() {
        $sql = "SELECT p.*, c.nombre, pl.plan, pl.precio_plan FROM pagos_planes p INNER JOIN clientes c ON c.id = p.id_cliente INNER JOIN planes pl ON pl.id = p.id_plan"; // Consulta para obtener los pagos, incluyendo información del cliente y del plan.
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data;
    }

    // Método para obtener los planes asignados a clientes.
    public function getPlanCliente() {
        $sql = "SELECT d.*, p.plan, p.precio_plan, c.dni, c.nombre FROM detalle_planes d INNER JOIN planes p ON d.id_plan = p.id INNER JOIN clientes c ON d.id_cliente = c.id"; // Consulta para obtener los detalles de los planes y los clientes asociados.
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data;
    }

    // Método para ver detalles específicos de un plan asignado a un cliente.
    public function ver($id) {
        $sql = "SELECT d.*, p.id AS id_plan, p.plan, p.precio_plan, c.id AS id_cli, c.dni, c.nombre FROM detalle_planes d INNER JOIN planes p ON d.id_plan = p.id INNER JOIN clientes c ON d.id_cliente = c.id WHERE d.id = $id"; // Consulta para obtener los detalles específicos de un plan asignado a un cliente.
        $data = $this->select($sql); // Ejecuta la consulta y devuelve el resultado.
        return $data;
    }

    // Método para generar un PDF de un pago específico.
    public function getPdf($id) {
        $sql = "SELECT d.*, p.id AS id_plan, p.plan, p.precio_plan, c.id AS id_cli, c.dni, c.nombre, c.direccion, dp.id, dp.fecha_venc FROM pagos_planes d INNER JOIN planes p ON d.id_plan = p.id INNER JOIN clientes c ON d.id_cliente = c.id INNER JOIN detalle_planes dp ON dp.id = d.id_detalle WHERE d.id = $id"; // Consulta para obtener los detalles para generar un PDF de un pago específico.
        $data = $this->select($sql); // Ejecuta la consulta y devuelve el resultado.
        return $data;
    }

    // Método para generar un PDF de todos los pagos de un cliente específico.
    public function getPdfCliente($id) {
        $sql = "SELECT d.precio, d.fecha, d.hora, p.plan, c.dni, c.nombre, c.direccion, dp.id, dp.fecha_venc FROM pagos_planes d INNER JOIN planes p ON d.id_plan = p.id INNER JOIN clientes c ON d.id_cliente = c.id INNER JOIN detalle_planes dp ON dp.id = d.id_detalle WHERE d.id_cliente = $id"; // Consulta para obtener los detalles para generar un PDF de todos los pagos de un cliente.
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data;
    }

    // Método para registrar un nuevo pago para un cliente.
    public function registrarPagoCliente($id_detalle, $id_cli, $id_plan, $precio, $fecha, $hora, $user) {
        $sql = "INSERT INTO pagos_planes(id_detalle, id_cliente, id_plan, precio, fecha, hora, id_user) VALUES (?,?,?,?,?,?,?)"; // Consulta para insertar un nuevo pago en la base de datos.
        $datos = array($id_detalle, $id_cli, $id_plan, $precio, $fecha, $hora, $user); // Datos para la inserción.
        $data = $this->insertar($sql, $datos); // Ejecuta la inserción y guarda el resultado.
        if ($data > 0) {
            $res = $data; // Devuelve el ID del pago si fue exitoso.
        } else {
            $res = "error"; // Respuesta si hubo algún error.
        }
        return $res; // Retorna el resultado de la operación.
    }

    // Método para obtener todos los pagos realizados por un cliente específico.
    public function ver_pagos($id_cli) {
        $sql = "SELECT p.*, c.id AS id_cli, c.nombre, pl.id AS id_plan, pl.plan, pl.precio_plan FROM pagos_planes p INNER JOIN clientes c ON c.id = p.id_cliente INNER JOIN planes pl ON pl.id = p.id_plan WHERE p.id_cliente = $id_cli"; // Consulta para obtener todos los pagos realizados por un cliente específico.
        $data = $this->selectAll($sql); // Ejecuta la consulta y devuelve los resultados.
        return $data;
    }
}


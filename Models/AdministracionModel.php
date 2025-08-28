<?php
class AdministracionModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener la configuración de la empresa
    public function getEmpresa()
    {
        $sql = "SELECT * FROM configuracion";
        $data = $this->select($sql);
        return $data;
    }

    // Contar la cantidad de registros activos en una tabla específica
    public function getDatos($table)
    {
        $sql = "SELECT COUNT(*) AS total FROM $table WHERE estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    // Modificar los datos de la configuración de la empresa
    public function modificar($ruc, $nombre, $correo, $tel, $dir, $mensaje, $img, $limite, $id)
    {
        $sql = "UPDATE configuracion SET ruc=?, nombre = ?, correo=?, telefono =?, direccion=?, mensaje=?, logo = ?, limite=? WHERE id=?";
        $datos = array($ruc, $nombre, $correo, $tel, $dir, $mensaje, $img, $limite, $id);
        $data = $this->save($sql, $datos);
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        return $res;
    }

    // Obtener las ventas de productos por mes, filtrando por rango de fechas y usuario
    public function getproductosVendidos($desde, $hasta, $id_user)
    {
        $sql = "SELECT
            SUM(IF(MONTH(fecha) = 1,  precio, 0)) AS ene,
            SUM(IF(MONTH(fecha) = 2,  precio, 0)) AS feb,
            SUM(IF(MONTH(fecha) = 3,  precio, 0)) AS mar,
            SUM(IF(MONTH(fecha) = 4,  precio, 0)) AS abr,
            SUM(IF(MONTH(fecha) = 5,  precio, 0)) AS may,
            SUM(IF(MONTH(fecha) = 6,  precio, 0)) AS jun,
            SUM(IF(MONTH(fecha) = 7,  precio, 0)) AS jul,
            SUM(IF(MONTH(fecha) = 8,  precio, 0)) AS ago,
            SUM(IF(MONTH(fecha) = 9,  precio, 0)) AS sep,
            SUM(IF(MONTH(fecha) = 10, precio, 0)) AS oct,
            SUM(IF(MONTH(fecha) = 11, precio, 0)) AS nov,
            SUM(IF(MONTH(fecha) = 12, precio, 0)) AS dic
            FROM pagos_planes
            WHERE fecha BETWEEN '$desde' AND '$hasta' AND id_user = $id_user";
        $data = $this->select($sql);
        return $data;
    }

    // Obtener las ventas diarias agrupadas por plan, filtrando por usuario
    public function getVentas($id_user)
    {
        $sql = "SELECT d.id_plan, d.fecha, d.estado, d.id_user, p.id, p.plan, COUNT(*) AS total FROM detalle_planes d INNER JOIN planes p ON p.id = d.id_plan WHERE d.fecha = CURDATE() AND d.estado = 1 AND d.id_user = $id_user GROUP BY d.id_plan";
        $data = $this->selectAll($sql);
        return $data;
    }
}
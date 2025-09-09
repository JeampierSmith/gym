<?php
require_once __DIR__ . '/../Config/App/Conexion.php';
class Query {
    protected $conect;
    public function __construct() {
        $this->conect = (new Conexion())->conect();
    }

    // Ejecuta una consulta SELECT y retorna un solo resultado
    public function select($sql, $params = []) {
        $query = $this->conect->prepare($sql);
        $query->execute($params);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // Ejecuta una consulta SELECT y retorna todos los resultados
    public function selectAll($sql, $params = []) {
        $query = $this->conect->prepare($sql);
        $query->execute($params);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ejecuta una consulta INSERT/UPDATE/DELETE
    public function save($sql, $params = []) {
        $query = $this->conect->prepare($sql);
        return $query->execute($params);
    }
}

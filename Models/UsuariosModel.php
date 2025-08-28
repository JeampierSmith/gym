<?php
// Definición de la clase UsuariosModel que hereda de la clase Query
class UsuariosModel extends Query {
    
    // Constructor de la clase que llama al constructor de la clase padre
    public function __construct() {
        parent::__construct();
    }

    // Método para obtener un usuario específico validando el nombre de usuario y la clave
    public function getUsuario($usuario, $clave) {
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND clave = '$clave' AND estado = 1";
        $data = $this->select($sql);
        return $data;
    }

    // Método para obtener todos los usuarios según su estado (activo/inactivo)
    public function getUsuarios($estado) {
        $sql = "SELECT * FROM usuarios WHERE estado = $estado";
        $data = $this->selectAll($sql);
        return $data;
    }

    // Método para registrar un nuevo usuario en la base de datos
    public function registrarUsuario($usuario, $nombre, $correo, $telefono, $clave, $rol) {
        // Verifica si el usuario ya existe en la base de datos
        $vericar = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $existe = $this->select($vericar);
        
        // Si el usuario no existe, procede a registrarlo
        if (empty($existe)) {
            $sql = "INSERT INTO usuarios(usuario, nombre, correo, telefono, clave, rol) VALUES (?,?,?,?,?,?)";
            $datos = array($usuario, $nombre, $correo, $telefono, $clave, $rol);
            $data = $this->save($sql, $datos);
            
            // Verifica si la inserción fue exitosa
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            // Si el usuario ya existe, retorna un mensaje indicando esto
            $res = "existe";
        }
        
        return $res;
    }

    // Método para modificar los datos de un usuario existente
    public function modificarUsuario($usuario, $nombre, $correo, $telefono, $rol, $id) {
        $sql = "UPDATE usuarios SET usuario = ?, nombre = ?, correo=?, telefono=?, rol=? WHERE id = ?";
        $datos = array($usuario, $nombre, $correo, $telefono, $rol, $id);
        $data = $this->save($sql, $datos);
        
        // Verifica si la actualización fue exitosa
        if ($data == 1) {
            $res = "modificado";
        } else {
            $res = "error";
        }
        
        return $res;
    }

    // Método para obtener la información de un usuario específico por su ID
    public function editarUser($id) {
        $sql = "SELECT * FROM usuarios WHERE id = $id";
        $data = $this->select($sql);
        return $data;
    }

    // Método para validar la clave de un usuario específico
    public function getPass($clave, $id) {
        $sql = "SELECT * FROM usuarios WHERE clave = '$clave' AND id = $id";
        $data = $this->select($sql);
        return $data;
    }

    // Método para activar o desactivar el estado de un usuario
    public function accionUser($estado, $id) {
        $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
        $datos = array($estado, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    // Método para modificar la clave de un usuario específico
    public function modificarPass($clave, $id) {
        $sql = "UPDATE usuarios SET clave = ? WHERE id = ?";
        $datos = array($clave, $id);
        $data = $this->save($sql, $datos);
        return $data;
    }

    // Método para modificar ciertos datos de un usuario (usuario, nombre, correo) por su ID
    public function modificarDato($usuario, $nombre, $correo, $id) {
        $sql = "UPDATE usuarios SET usuario=?, nombre=?, correo=? WHERE id=?";
        $datos = array($usuario, $nombre, $correo, $id);
        $data = $this->save($sql, $datos);
        
        // Verifica si la actualización fue exitosa
        if ($data == 1) {
            $res = 1;
        } else {
            $res = 0;
        }
        
        return $res;
    }
}
?>
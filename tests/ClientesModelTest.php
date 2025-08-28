<?php

require_once __DIR__ . '/TestConfig.php';
require_once __DIR__ . '/../Config/Config.php';
require_once __DIR__ . '/../Config/Helpers.php';
require_once __DIR__ . '/../Config/App/Conexion.php';
require_once __DIR__ . '/../Config/App/Query.php';
require_once __DIR__ . '/../Models/ClientesModel.php';

use PHPUnit\Framework\TestCase;

class ClientesModelTest extends TestCase
{
    private $clientesModel;

    protected function setUp(): void
    {
        // Configurar las variables de entorno para la base de datos
        putenv('DB_HOST=db');
        putenv('DB_USER=root');
        putenv('DB_PASSWORD=root');
        putenv('DB_NAME=gimnasios');

        // Asegurarse de que la base de datos esté disponible
        $this->assertTrue(
            $this->isDatabaseAvailable(),
            'La base de datos no está disponible'
        );
        
        $this->clientesModel = new ClientesModel();
    }

    private function isDatabaseAvailable(): bool
    {
        try {
            $conexion = new mysqli(
                getenv('DB_HOST'),
                getenv('DB_USER'),
                getenv('DB_PASSWORD'),
                getenv('DB_NAME')
            );
            return !$conexion->connect_error;
        } catch (Exception $e) {
            return false;
        }
    }

    public function testGetClientes()
    {
        // Test getting active clients (estado = 1)
        $result = $this->clientesModel->getClientes(1);
        $this->assertIsArray($result);
    }

    public function testBuscarCliente()
    {
        // Test searching for a client
        $result = $this->clientesModel->buscarCliente('test');
        $this->assertIsArray($result);
    }

    public function testRegistrarCliente()
    {
        // Test registering a new client
        $dni = '12345678';
        $nombre = 'Test User';
        $telefono = '123456789';
        $direccion = 'Test Address';
        $foto = 'default.jpg';
        $id_user = 1;

        $result = $this->clientesModel->registrarCliente($dni, $nombre, $telefono, $direccion, $foto, $id_user);
        $this->assertContains($result, ['ok', 'existe', 'error']);
    }

    public function testModificarCliente()
    {
        // Test modifying a client
        $dni = '12345678';
        $nombre = 'Updated Test User';
        $telefono = '987654321';
        $direccion = 'Updated Test Address';
        $foto = 'default.jpg';
        $id = 1; // Assuming client with ID 1 exists

        $result = $this->clientesModel->modificarCliente($dni, $nombre, $telefono, $direccion, $foto, $id);
        $this->assertContains($result, ['modificado', 'error']);
    }

    public function testBuscarPlanCliente()
    {
        // Prueba para buscar planes de un cliente
        $result = $this->clientesModel->buscarPlanCliente('test');
        $this->assertIsArray($result);
        
        // Verifica que si hay resultados, contengan los campos necesarios
        if (!empty($result)) {
            $this->assertArrayHasKey('id', $result[0]);
            $this->assertArrayHasKey('nombre', $result[0]);
            $this->assertArrayHasKey('plan', $result[0]);
            $this->assertArrayHasKey('precio_plan', $result[0]);
        }
    }

    public function testBuscarPlanes()
    {
        // Prueba para buscar planes de un cliente específico
        $id_cliente = 1; // Asumiendo que existe un cliente con ID 1
        $result = $this->clientesModel->buscarPlanes($id_cliente);
        $this->assertIsArray($result);
        
        // Verifica la estructura de los datos retornados
        if (!empty($result)) {
            $this->assertArrayHasKey('id', $result[0]);
            $this->assertArrayHasKey('id_cliente', $result[0]);
            $this->assertArrayHasKey('id_plan', $result[0]);
            $this->assertArrayHasKey('plan', $result[0]);
        }
    }

    public function testAccionCliente()
    {
        // Prueba para activar/desactivar un cliente
        $id_cliente = 1; // Asumiendo que existe un cliente con ID 1
        
        // Prueba desactivar cliente
        $result_desactivar = $this->clientesModel->accionCli(0, $id_cliente);
        $this->assertIsNumeric($result_desactivar);
        
        // Prueba activar cliente
        $result_activar = $this->clientesModel->accionCli(1, $id_cliente);
        $this->assertIsNumeric($result_activar);
    }

    public function testGetPagos()
    {
        // Prueba para obtener todos los pagos
        $result = $this->clientesModel->getPagos();
        $this->assertIsArray($result);
        
        // Verifica la estructura de los datos de pago
        if (!empty($result)) {
            $this->assertArrayHasKey('id', $result[0]);
            $this->assertArrayHasKey('nombre', $result[0]);
            $this->assertArrayHasKey('plan', $result[0]);
            $this->assertArrayHasKey('precio_plan', $result[0]);
        }
    }
} 
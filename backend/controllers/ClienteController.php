<?php
require_once __DIR__ . '/../services/ClienteService.php';

// Arquivo de configuração de controllers, acionado pelo arquivo index.php
// Este por sua vez aciona o arquivo de Service

class ClienteController {
    private $service;

    public function __construct() {
        $this->service = new ClienteService();
    }

    public function handleRequest() {
        $method = $_SERVER['REQUEST_METHOD'];
        $input = json_decode(file_get_contents("php://input"), true);

        switch ($method) {
            case 'GET':
                $data = $this->service->listar();
                echo json_encode($data);
                break;

            case 'POST':
                echo json_encode(
                    $this->service->criar($input['nome'], $input['email'])
                );
                break;

            case 'PUT':
                echo json_encode(
                    $this->service->atualizar($input['id'], $input['nome'], $input['email'])
                );
                break;

            case 'DELETE':
                echo json_encode(
                    $this->service->deletar($input['id'])
                );
                break;
        }
    }
}
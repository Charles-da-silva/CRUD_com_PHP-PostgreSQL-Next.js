<?php

require_once __DIR__ . '/../controllers/ClienteController.php';

$path = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

$path = trim($path, '/');

$segments = explode('/', $path);

$method = $_SERVER['REQUEST_METHOD'];

$controller = new ClienteController();

if ($segments[0] === 'clientes') {

    $id = $segments[1] ?? null;

    switch ($method) {

        case 'GET':

            if ($id) {
                $controller->findById($id);
            } else {
                $controller->findAll();
            }

            break;

        case 'POST':
            $controller->create();
            break;

        case 'PUT':
            $controller->update($id);
            break;

        case 'DELETE':
            $controller->delete($id);
            break;

        default:

            http_response_code(405);

            echo json_encode([
                "success" => false,
                "message" => "Método não permitido"
            ]);
    }
}
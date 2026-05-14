<?php

require_once __DIR__ . '/../controllers/ClienteController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

/* Identificando o endereço acessado (parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH))
O servidor guarda o endereço completo digitado na variável global 
$_SERVER['REQUEST_URI']. Se você acessar 
http://localhost/clientes/15?cupom=desconto, o comando parse_url limpa 
a URL e isola apenas o caminho principal: /clientes/15.
 */
$path = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

/* trim($path, '/')
Esse comando remove as barras das pontas. O texto /clientes/15/ vira apenas 
clientes/15. Isso evita erros caso alguém digite uma barra a mais no final 
do endereço.
*/
$path = trim($path, '/');

/* explode('/', $path);
O comando explode quebra o texto toda vez que encontra uma barra / e 
transforma o resultado em uma lista (array).Se o endereço for clientes/15, 
a lista $segments vira:
    No índice 0: "clientes"
    No índice 1: "15"
*/
$segments = explode('/', $path);

$method = $_SERVER['REQUEST_METHOD'];

$controller = new ClienteController();
$authController = new AuthController();


// Verificando se o caminho é /register e o método é POST para acionar o 
// registro de usuário
if ($segments[0] === 'register') {

    if ($method === 'POST') {

        $authController->register();
    }
}


// Verificando se o caminho começa com /clientes para acionar as rotas de clientes
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
            /*
            observe que não passamos dados para o método create. Isso porque 
            os dados do novo cliente estão no corpo da requisição, e o método 
            create vai precisar ler esse corpo para descobrir quais são os dados 
            do cliente a ser criado:
                json_decode(file_get_contents("php://input"), true)
            */
            break;

        case 'PUT':
            $controller->update($id);
            break;

        case 'DELETE':
            $controller->delete($id);
            break;

        default:
            /*
            Se alguém tentar acessar a URL /clientes usando um método inválido 
            (como PATCH, OPTIONS ou HEAD), o código cai nessa proteção. Ele avisa
            o servidor para devolver o status HTTP 405 Method Not Allowed e 
            imprime uma mensagem limpa em formato JSON explicando o erro para 
            o desenvolvedor do front-end.
            */
            http_response_code(405);

            echo json_encode([
                "success" => false,
                "message" => "Método não permitido"
            ]);
    }
}
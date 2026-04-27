<?php
// require_once é usado para garantir que o arquivo seja incluído apenas uma vez, 
// evitando erros de redefinição de classes ou funções, o que poderia gerar um erro fatal (HTTP Code 500). 
// Se o arquivo já tiver sido incluído, ele não será incluído novamente.;
require_once 'db.php';  

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

  case 'GET':
    $stmt = $conn->query('SELECT * FROM clientes');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
    break;

  case 'POST':
    $data = json_decode(file_get_contents('php://input'), true);

    if (
      !$data ||
      !isset($data['nome']) ||
      !isset($data['email']) ||
      empty(trim($data['nome'])) ||
      !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
    ) {
      http_response_code(400);
      echo json_encode([
        "success" => false,
        "message" => "Erro ao criar cliente. Verifique os dados inseridos."]);
      exit;
    }

    $stmt = $conn->prepare('INSERT INTO clientes (nome, email) VALUES ( ?, ?)');
    $stmt->execute([$data['nome'], $data['email']]);
    echo json_encode([
      "success" => true,
      "message" => "Cliente criado com sucesso"]);
    break;

  case 'PUT':
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validação dos dados enviados no JSON
    if (
      !$data ||
      !isset($data['id']) ||
      !isset($data['nome']) ||
      !isset($data['email']) || 
      empty(trim($data['nome'])) ||
      !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
    ) {
      http_response_code(400);
      echo json_encode([
        "success" => false,
        "message" => "Erro ao atualizar cliente. Verifique os dados inseridos."
      ]);
      exit;
    }

    // Execução da query de atualização usando prepared statements para evitar SQL injection
    $stmt = $conn->prepare('UPDATE clientes SET nome = ?, email = ? WHERE id = ?');
    $stmt->execute([$data['nome'], $data['email'], $data['id']]);

    // Verificação se realmente atualizou
    if ($stmt->rowCount() === 0) {
      http_response_code(404);
      echo json_encode([
        "success" => false,
        "message" => "ID do cliente não encontrado."
      ]);
      exit;
    }
    else {
      echo json_encode([
        "success" => true,
        "message" => "Cliente atualizado"
      ]);
    }

    break;

  case 'DELETE':
    $data = json_decode(file_get_contents('php://input'), true);

    // Validação dos dados enviados no JSON
    if (
      !$data ||
      !isset($data['id'])
    ) {
      http_response_code(400);
      echo json_encode([
        "success" => false,
        "message" => "ID inválido."
      ]);
      exit;
    }

    $stmt = $conn->prepare('DELETE FROM clientes WHERE id = ?');
    $stmt->execute([$data['id']]);
    
    if ($stmt->rowCount() === 0) {
      http_response_code(404);
      echo json_encode([
        "success" => false,
        "message" => "Cliente não encontrado"
      ]);
      exit;
    }
    else {
      echo json_encode([
        "success" => true,
        "message" => "Cliente excluído"
      ]);
    }
    break;

  default:
    http_response_code(405);
    echo json_encode([
      "success" => false,
      "message" => "Method Not Allowed"
    ]);
}
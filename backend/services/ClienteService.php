<?php
require_once __DIR__ . '/../repositories/ClienteRepository.php';

// Arquivo com as regras de negócio do ambiente, acionado pelo arquivo Controller 
// Por sua vez aciona o arquivo ClienteRepository

class ClienteService {
    private $repo;

    public function __construct() {
        $this->repo = new ClienteRepository();
    }

    public function listar() {
        return $this->repo->findAll();
    }

    public function criar($nome, $email) {
        if (!$nome || !$email) {
            return ["success" => false, "message" => "Nome e email são obrigatórios"];
        }

        $this->repo->create($nome, $email);

        return ["success" => true, "message" => "Cliente criado com sucesso"];
    }

    public function atualizar($id, $nome, $email) {
        if (!$id || !$nome || !$email) {
            return ["success" => false, "message" => "Insira todas as informações do cliente"];
        }

        $affected = $this->repo->update($id, $nome, $email);

        if ($affected === 0) {
            return ["success" => false, "message" => "Cliente não encontrado"];
        }

        return ["success" => true, "message" => "Cliente atualizado"];
    }

    public function deletar($id) {
        if (!$id) {
            return ["success" => false, "message" => "ID é obrigatório"];
        }

        $affected = $this->repo->delete($id);

        if ($affected === 0) {
            return ["success" => false, "message" => "ID não encontrado"];
        }

        return ["success" => true, "message" => "Cliente deletado"];
    }
}
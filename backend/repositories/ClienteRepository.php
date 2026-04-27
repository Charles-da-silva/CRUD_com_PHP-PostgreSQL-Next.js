<?php
require_once __DIR__ . '/../config/db.php';

// Arquivo usado para acesso ao banco acionado via Service
// este por sua vez aciona o arquivo de banco db.php

class ClienteRepository {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function findAll() {
        $stmt = $this->conn->query("SELECT * FROM clientes ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nome, $email) {
        $stmt = $this->conn->prepare(
            "INSERT INTO clientes (nome, email) VALUES (:nome, :email)"
        );
        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email
        ]);
    }

    public function update($id, $nome, $email) {
        $stmt = $this->conn->prepare(
            "UPDATE clientes SET nome = :nome, email = :email WHERE id = :id"
        );
        
        $stmt->execute([
            ':id' => $id,
            ':nome' => $nome,
            ':email' => $email
        ]);

        return $stmt->rowCount();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM clientes WHERE id = :id"
        );
        
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount();
    }
}
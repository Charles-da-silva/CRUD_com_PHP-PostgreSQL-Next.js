<?php
require_once __DIR__ . '/../config/db.php';

// O Repository é acionado via Service e este por sua vez aciona o arquivo 
// db.php que possui a string de conexão com o banco 

class ClienteRepository {

    // criando a variável que irá receber a conexão PDO
    private $conn;

    // Método CONSTRUCTOR
    public function __construct() {

        // Cria conexão com banco
        $this->conn = Database::connect();
    }

    /*
    |--------------------------------------------------------------------------
    | FIND ALL
    |--------------------------------------------------------------------------
    */
    public function findAll() {

        // Criando a query SQL
        $sql = "SELECT * FROM clientes ORDER BY id";

        // Executa query
        $stmt = $this->conn->query($sql);

        // fetchAll -> retorna vários registros
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | FIND ALL
    |--------------------------------------------------------------------------
    | Busca todos os clientes
    */
    public function findById($id){

        // evitando SQL injection
        $sql = "SELECT *FROM clientes WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        // fetch -> retorna apenas um registro
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create($data) {

        $sql = "
            INSERT INTO clientes (nome, email) 
            VALUES (:nome, :email)
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':nome' => $data['nome'],
            ':email' => $data['email']
        ]);
    }

     /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update($id, $data) {

        $sql = "
            UPDATE clientes 
            SET nome = :nome, 
            email = :email 
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute([
            ':id' => $id,
            ':nome' => $data['nome'],
            ':email' => $data['email']
        ]);

        // Quantidade de linhas alteradas
        return $stmt->rowCount();
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function delete($id) {

        $sql = "
            DELETE FROM clientes 
            WHERE id = :id";
            
        $stmt = $this->conn->prepare($sql);
        
        $stmt->execute([':id' => $id]);

        return $stmt->rowCount();
    }
}
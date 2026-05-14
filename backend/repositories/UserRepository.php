<?php

require_once __DIR__ . '/../config/db.php';

class UserRepository {

    private $conn;

    public function __construct() {

        $this->conn = Database::connect();
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY EMAIL
    |--------------------------------------------------------------------------
    */
    public function findByEmail($email) {

        $sql = "
            SELECT *
            FROM users
            WHERE email = :email
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */

    public function create($data){
        $sql = "
            INSERT INTO users(
                name,
                email,
                password
            )
            VALUES (
                :name,
                :email,
                :password
            )
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $data['password']
        ]);
    }


}


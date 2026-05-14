<?php

require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../utils/Response.php';

class AuthService {
    
    private $repo;

    public function __construct() {

        $this->repo = new UserRepository();
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */
    public function register($data) {

        // VERIFICA EMAIL EXISTENTE

        $user = $this->repo->findByEmail (
            $data['email']
        );

        if ($user) {

            Response::error(
                "EMAIL_ALREADY_EXISTS",
                "Email já cadastrado",
                400
            );
        }

        // HASH PASSWORD

        $hashedPassword = password_hash(
            $data['password'],
            PASSWORD_DEFAULT

            /* o que é o PASSWORD_DEFAULT:
            
            O PHP escolhe automaticamente:

            - algoritmo seguro
            - custo adequado

            Normalmente:

                - bcrypt
            
            No banco você verá $2y$10$... e NÃO a senha original.
            */
        );

        $data['password'] = $hashedPassword;

        $this->repo->create($data);

        return true;
    }
}
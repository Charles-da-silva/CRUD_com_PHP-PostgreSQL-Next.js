<?php

require_once __DIR__ . '/../services/AuthService.php';
require_once __DIR__ . '/../utils/Response.php';

class AuthController {

    private $service;

    public function __construct() {

        $this->service = new AuthService();
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */
    public function register() {

        $input = json_decode(
            file_get_contents("php://input"),
            true
        );

        $this->service->register($input);
        
        Response::success(
            null,
            "Usuário registrado com sucesso",
            201
        );
    }
}
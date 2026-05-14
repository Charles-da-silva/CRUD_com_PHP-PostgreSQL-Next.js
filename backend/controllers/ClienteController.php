<?php

require_once __DIR__ . '/../services/ClienteService.php';
require_once __DIR__ . '/../utils/Response.php';

// Arquivo de configuração de controllers, acionado pelo arquivo index.php
// Este por sua vez aciona o arquivo de Service

class ClienteController {

    private $service;

    public function __construct() {

        $this->service = new ClienteService();
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL
    |--------------------------------------------------------------------------
    */

    public function findAll() {

        $clientes = $this->service->listar();

        Response::success(
            $clientes,
            null,
            200
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET BY ID
    |--------------------------------------------------------------------------
    */

    public function findById($id) {

        $cliente = $this->service->buscarPorId($id);

        Response::success(
            $cliente,
            null,
            200
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create() {

        /*
        Abrindo o corpo da requisição (php://input) e extraindo o JSON 
        (json_decode) enviado pelo front para descobrir os dados do novo cliente.
        */
        $input = json_decode(
            file_get_contents("php://input"),
            true
        );

        $this->service->criar($input);

        Response::success(
            null,
            "Cliente criado com sucesso",
            201
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update($id) {

        $input = json_decode(
            file_get_contents("php://input"),
            true
        );

        $this->service->atualizar($id, $input);

        Response::success(
            null,
            "Cliente atualizado",
            200
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete($id) {

        $this->service->deletar($id);

        Response::success(
            null,
            "Cliente deletado",
            200
        );
    }
}
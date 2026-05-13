<?php

require_once __DIR__ . '/../repositories/ClienteRepository.php';
require_once __DIR__ . '/../validators/ClienteValidator.php';
require_once __DIR__ . '/../utils/Response.php';

// Arquivo com as regras de negócio do ambiente, acionado pelo arquivo Controller 
// Por sua vez aciona o arquivo ClienteRepository

class ClienteService {

    private $repo;

    public function __construct() {
        $this->repo = new ClienteRepository();
    }


    /*
    |--------------------------------------------------------------------------
    | LISTAR
    |--------------------------------------------------------------------------
    */
    public function listar() {
        return $this->repo->findAll();
    }


    /*
    |--------------------------------------------------------------------------
    | BUSCAR POR ID
    |--------------------------------------------------------------------------
    */
    public function buscarPorId($id) {

        $cliente = $this->repo->findById($id);

        // Cliente não encontrado
        if (!$cliente) {

            Response::error(
                "NOT_FOUND",
                "Cliente não encontrado",
                404
            );
        }

        return $cliente;
    }


    /*
    |--------------------------------------------------------------------------
    | CRIAR
    |--------------------------------------------------------------------------
    */
    public function criar($data) {
        
        //VALIDAÇÃO
        $errors = ClienteValidator::validate($data);

        if (!empty($errors)) {

            Response::error(
                "VALIDATION_ERROR",
                $errors,
                400
            );
        }

        return $this->repo->create($data);
    }


     /*
    |--------------------------------------------------------------------------
    | ATUALIZAR
    |--------------------------------------------------------------------------
    */
    public function atualizar($id, $data) {

        $errors = ClienteValidator::validate($data);

        if (!empty($errors)) {

            Response::error(
                "VALIDATION_ERROR",
                $errors,
                400
            );
        }

        $affected = $this->repo->update($id, $data);

        // Nenhuma linha afetada
        if ($affected === 0) {

            Response::error(
                "NOT_FOUND",
                "Cliente não encontrado",
                404
            );
        }

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | DELETAR
    |--------------------------------------------------------------------------
    */
    public function deletar($id) {

        $affected = $this->repo->delete($id);

        if ($affected === 0) {

            Response::error(
                "NOT_FOUND",
                "Cliente não encontrado",
                404
            );
        }

        return true;
    }
}
<?php

// Responsável por validar dados antes de salvar.

class ClienteValidator {
    /*
    |--------------------------------------------------------------------------
    | VALIDATE
    |--------------------------------------------------------------------------
    | Recebe os dados do cliente
    | e retorna um array de erros.
    |
    | Se não houver erros:
    | retorna []
    */

    public static function validate($data) {

        $errors = [];

        /*
        |--------------------------------------------------------------------------
        | NOME
        |--------------------------------------------------------------------------
        */

        if (empty($data['nome'])) {

            $errors[] = "Nome é obrigatório";
        }

        /*
        |--------------------------------------------------------------------------
        | EMAIL
        |--------------------------------------------------------------------------
        */

        if (empty($data['email'])) {

            $errors[] = "Email é obrigatório";
        }

        /*
        |--------------------------------------------------------------------------
        | EMAIL VÁLIDO
        |--------------------------------------------------------------------------
        */

        if (
            !empty($data['email']) &&
            !filter_var(
                $data['email'],
                FILTER_VALIDATE_EMAIL
            )
        ) {

            $errors[] = "Email inválido";
        }

        return $errors;
    }
}
<?php


// Essa classe padroniza todas as respostas da API.


class Response {
    /*
    |--------------------------------------------------------------------------
    | SUCCESS RESPONSE
    |--------------------------------------------------------------------------
    | Retorna respostas de sucesso da API.
    |
    | Exemplo:
    | {
    |   "success": true,
    |   "data": [...],
    |   "message": "Cliente criado"
    | }
    */

    public static function success(
        $data = null,
        $message = null,
        $status = 200
    ) {

        // Define o HTTP STATUS CODE
        http_response_code($status);

        // Converte array PHP em JSON
        echo json_encode([
            "success" => true,
            "data" => $data,
            "message" => $message
        ]);

        // Encerra execução
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | ERROR RESPONSE
    |--------------------------------------------------------------------------
    | Retorna respostas de erro padronizadas.
    |
    | Exemplo:
    | {
    |   "success": false,
    |   "error": {
    |       "code": "NOT_FOUND",
    |       "message": "Cliente não encontrado"
    |   }
    | }
    */

    public static function error(
        $code,
        $message,
        $status = 400
    ){

        http_response_code($status);

        echo json_encode([
            "success" => false,
            "error" => [
                "code" => $code,
                "message" => $message
            ]
        ]);

        exit;
    }

}
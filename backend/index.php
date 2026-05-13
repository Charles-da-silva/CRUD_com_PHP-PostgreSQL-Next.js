<?php

// Arquivo de porta de entrada do PHP, qual é acionado pelo Front via Page.tsx.
// Este arquivo por usa vez aciona o arquivo de rotas

header("Content-Type: application/json");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// require_once é usado para garantir que o arquivo seja importado só uma vez 
require_once __DIR__ . '/routes/api.php';

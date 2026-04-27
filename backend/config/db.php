<?php

// Arquivo de configuração de acesso ao banco de dados, acionado pelo Repository
// Por sua vez aciona o banco de dados

class Database {
  public static function connect() {
    $host = 'localhost';
    $port = 5433;
    $db = 'crud_php_db';
    $user = 'postgres';
    $pass = '1234';

    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
  }
}



<?php

// função para conexão com o banco de dados
function conectarBD() {
    $host = 'localhost';
    $dbname = 'freelacapy';
    $user = 'root';
    $pass = 'Senai@118';

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $conn;
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }

}
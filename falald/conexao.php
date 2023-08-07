<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$bancoDados = 'comentario';

// Estabelecer conexão com o banco de dados
$conn = new mysqli($host, $usuario, $senha, $bancoDados);

// Verificar a conexão
if ($conn->connect_error) {
    die('Falha na conexão: ' . $conn->connect_error);
}
?>

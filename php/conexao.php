<?php
$servername = "localhost"; // Host do banco de dados
$username = "root"; // Usuário do banco de dados
$password = ""; // Senha do banco (vazio por padrão no XAMPP)
$dbname = "agendamentosala"; // Nome do banco de dados

// Criar conexão com o banco de dados usando mysqli
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verificar se houve erro na conexão
if ($mysqli->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->connect_error);
}
?>

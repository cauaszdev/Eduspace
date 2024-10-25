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

session_start();
$id_professor = $_SESSION['Idprof']; // Usando 'Idprof' com 'd' minúsculo

// Atualizar o banco de dados para remover a imagem
$sql = "UPDATE professor SET imagem = NULL WHERE Idprof = ?";
$stmt = $mysqli->prepare($sql);

// Verifica se a preparação do statement foi bem-sucedida
if ($stmt === false) {
    die("Erro ao preparar a consulta: " . $mysqli->error);
}

// Vincula os parâmetros e executa a consulta
$stmt->bind_param("i", $id_professor);

if ($stmt->execute()) {
    echo "Imagem removida com sucesso.";
} else {
    echo "Erro ao remover a imagem: " . $stmt->error;
}

// Redirecionar de volta para o perfil
header("Location: perfil.php");
exit(); // Sempre é bom usar exit após redirecionar
?>

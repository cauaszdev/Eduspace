<?php
// Configurações do banco de dados
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'cauasouza07';
$dbName = 'form-eduspace';

// Criar conexão com o banco de dados
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Verificar se a conexão foi bem-sucedida
if ($conexao->connect_errno) {
    echo "Erro ao conectar ao banco de dados: " . $conexao->connect_error;
    exit();
}

// Verificar se o formulário de login foi enviado
if (isset($_POST['login'])) {
    // Captura os dados do formulário
    $email = $_POST['email'];
    $senhaDigitada = $_POST['senha'];

    // Preparar a consulta SQL para buscar o usuário pelo email
    $stmt = $conexao->prepare("SELECT senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Verificar se o usuário existe
    if ($stmt->num_rows > 0) {
        // Obter o hash da senha armazenada no banco de dados
        $stmt->bind_result($hashArmazenado);
        $stmt->fetch();

        // Verificar se a senha digitada é válida
        if (password_verify($senhaDigitada, $hashArmazenado)) {
            // Redirecionar para a tela de boas-vindas
            header("Location: home.html");
            exit(); // Importante para garantir que o script pare aqui
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Email não encontrado.";
    }

    // Fechar a declaração
    $stmt->close();
}

// Fechar a conexão com o banco de dados
$conexao->close();
?>

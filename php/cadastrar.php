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

// Verificar se o formulário foi enviado
if (isset($_POST['submit'])) {
    // Captura os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    // Hash da senha antes de armazenar no banco de dados
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Preparar a consulta SQL
    $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha);

    // Executar a consulta
    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!<br>";
        echo "Nome: " . htmlspecialchars($nome) . "<br>";
        echo "Email: " . htmlspecialchars($email) . "<br>";
        
        // Redirecionar para a tela de login
        header("Location: login.html");
        exit();
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    // Fechar a declaração e a conexão
    $stmt->close();
}

// Fechar a conexão com o banco de dados
$conexao->close();
?>

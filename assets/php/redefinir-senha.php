<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamentosala";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$mensagem = "";
$token = $_GET['token'] ?? ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && $token) {
    $novaSenha = $_POST['nova_senha'] ?? '';

    $stmt = $conn->prepare("SELECT Email, token_expire FROM professor WHERE reset_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $tokenExpire = strtotime($row['token_expire']); 
        if (time() < $tokenExpire) {
            $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $updateStmt = $conn->prepare("UPDATE professor SET Password = ?, reset_token = NULL, token_expire = NULL WHERE reset_token = ?");
            $updateStmt->bind_param("ss", $novaSenhaHash, $token);
            $updateStmt->execute();

            $mensagem = "Senha alterada com sucesso!";
        } else {
            $mensagem = "O link de redefinição expirou.";
        }
    } else {
        $mensagem = "Token inválido.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Redefinir Senha</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: #ffffff;
    }

    body.dark-mode {
        background-color: #1a1a1a;
        color: #ffffff;
    }

    body.light-mode {
        background-color: #ffffff;
        color: #000000;
    }

    body .container {
        background-color: rgba(255, 255, 255, 0.9);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 20px;
    }

    input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }

    button {
        transition: background-color 0.3s, transform 0.3s;
    }

    button:hover {
        transform: scale(1.02);
    }

    input[type="password"], input[type="text"] {
        background-color: #ffffff;
        color: #000000;
        border: 1px solid #ddd;
        transition: background-color 0.3s, color 0.3s;
    }

    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert.success {
        background-color: #4CAF50;
        color: white;
    }

    .alert.error {
        background-color: #F44336;
        color: white;
    }

    .alert.info {
        background-color: #2196F3;
        color: white;
    }

    .alert .icon {
        margin-right: 10px;
    }
</style>

<body class="light-mode" id="body">

<div class="flex justify-center items-center h-screen">
    <div class="container max-w-md p-6">
        <img src="/tec/img/font.svg" alt="Eduspace" class="logo mx-auto mb-4">
        <p class="text-center mb-4">Proporcionamos agilidade no seu agendamento, de forma 100% gratuita.</p>

        <?php if ($mensagem): ?>
            <?php if (strpos($mensagem, 'sucesso') !== false): ?>
                <div class="alert success flex items-center">
                    <i class="fas fa-check-circle icon text-white"></i>
                    <p class="text-white"><?php echo $mensagem; ?></p>
                </div>
            <?php elseif (strpos($mensagem, 'erro') !== false): ?>
                <div class="alert error flex items-center">
                    <i class="fas fa-times-circle icon text-white"></i>
                    <p class="text-white"><?php echo $mensagem; ?></p>
                </div>
            <?php else: ?>
                <div class="alert info flex items-center">
                    <i class="fas fa-info-circle icon text-white"></i>
                    <p class="text-white"><?php echo $mensagem; ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm mb-1">Nova Senha</label>
                <input type="password" name="nova_senha" placeholder="Digite sua nova senha" class="w-full p-2 rounded border border-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-200 transition" required>
            </div>
            <button type="submit" class="w-full p-2 bg-blue-500 rounded text-white hover:bg-blue-600 transition">Alterar Senha</button>
        </form>
    </div>
</div>

</body>
</html>

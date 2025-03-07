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

$loggedInProfId = $_SESSION['IDprof'] ?? null;
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senhaAtual = $_POST['senha_atual'];
    $novaSenha = $_POST['nova_senha'];

    $stmt = $conn->prepare("SELECT Email, Password FROM professor WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($senhaAtual, $row['Password'])) {
            $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

            $updateStmt = $conn->prepare("UPDATE professor SET Password = ? WHERE Email = ?");
            $updateStmt->bind_param("ss", $novaSenhaHash, $email);

            if ($updateStmt->execute()) {
                $mensagem = "Senha atualizada com sucesso.";
            } else {
                $mensagem = "Erro ao atualizar a senha. Tente novamente.";
            }

            $updateStmt->close();
        } else {
            $mensagem = "A senha atual está incorreta.";
        }
    } else {
        $mensagem = "Email não encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="/assets/css/redefinir.css"> 
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container">
        <img src="/tec/img/font.svg" alt="Eduspace" class="logo">
        <h2>Redefinir Senha</h2>
        <p>Digite seu e-mail e a nova senha.</p>

        <form method="post" action="">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha_atual">Senha Atual:</label>
            <input type="password" id="senha_atual" name="senha_atual" required>

            <label for="nova_senha">Nova Senha:</label>
            <input type="password" id="nova_senha" name="nova_senha" required>

            <button type="submit">Alterar Senha</button>
        </form>
        
        <?php if ($mensagem): ?>
            <div class="popup" id="popup">
                <?php echo $mensagem; ?>
            </div>
            <script>
                $(document).ready(function() {
                    $("#popup").fadeIn().delay(3000).fadeOut();
                });
            </script>
        <?php endif; ?>
    </div>
</body>
</html>

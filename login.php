<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Eduspace</title>
    <link rel="stylesheet" href="css/login.css"> <!-- Certifique-se de que o CSS está no caminho correto -->
</head>
<div class="vector"></div>
<body>
    <div class="login-container">
        <img src="img/font.svg" alt="Eduspace" class="logo"> <!-- Substitua pelo caminho da sua logo -->
        <h2>Entrar com e-mail</h2>
        <p>Proporcionamos agilidade no seu agendamento, de forma 100% gratuita.</p>
        <form action="php/login.php" method="POST">
            <h2 class="emailtext">E-mail</h2>
            <input type="email" name="email" class="input-field" placeholder="@professor.enova.educacao.ba.gov.br" required>
            <h2 class="senhatext">Senha</h2>
            <input type="password" name="senha" class="input-field" required>
            <button type="submit" class="login-btn"  onclick="window.location.href='home.php'">Entrar</button>
        </form>
        <a href="redefinir.html" class="forgot-password">Esqueci minha senha</a>
    </div>
</body>
</html>

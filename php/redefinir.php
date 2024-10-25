<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci a Senha</title>
    <link rel="stylesheet" href="css/redefinir.css"> 
</head>
<body>
    <div class="container">
        <img src="img/font.svg" alt="Eduspace" class="logo">
        <h2>Esqueci a Senha</h2>
        <p>Digite seu e-mail e enviaremos um link para redefinir sua senha.</p>
        <form action="enviar_email.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Enviar Link</button>
        </form>
    </div>
</body>
</html>

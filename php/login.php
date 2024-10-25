<?php
include('conexao.php'); 

$mensagem = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    
    if (strlen($email) == 0) {
        $mensagem = "Preencha seu e-mail.";
    } elseif (strlen($senha) == 0) {
        $mensagem = "Preencha sua senha.";
    } else {
        
        $email = $mysqli->real_escape_string($email);
        $senha = $mysqli->real_escape_string($senha);

        
        $sql_code = "SELECT * FROM professor WHERE Email = '$email' AND Password = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Erro na consulta SQL: " . $mysqli->error);

        if ($sql_query->num_rows == 1) {
            $professor = $sql_query->fetch_assoc();
            session_start();
            $_SESSION['Idprof'] = $professor['IDprof'];
            $_SESSION['nome'] = $professor['Nome'];

            
            header("Location: home.php");
            exit();
        } else {
            $mensagem = "E-mail ou senha incorretos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/tec/css/login.css">
    <title>Login</title>
</head>
<body>
    <form action="" method="POST">
        <img src="/tec/img/font.svg" alt="Eduspace" class="logo"> 
        <p class="descricao">Proporcionamos agilidade no seu agendamento, de forma 100% gratuita.</p>

        
        <?php if ($mensagem): ?>
            <p class="erro"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <p>
            <label>E-mail</label>
            <input type="text" name="email" placeholder="@professor.enova.educacao.ba.gov.br">
        </p>
        <p>
            <label>Senha</label>
            <input type="password" name="senha">
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>
        <p>
            <a href="/tec/redefinir.php" class="botao-redefinir">Esqueceu sua senha?</a>
        </p>
    </form>
</body>
</html>

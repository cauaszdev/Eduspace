<?php
session_start();
require 'vendor/autoload.php'; 

use MailchimpMarketing\ApiClient;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamentosala";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$mensagem = ""; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io'; 
        $mail->SMTPAuth = true;
        $mail->Username = '7e8e0a215c6835'; 
        $mail->Password = 'fcf272a1aa707d'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@eduspace.com', 'Eduspace');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Redefinição de Senha - Eduspace';
        $body = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f7f7f7; }
                .container { width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
                h1 { color: #0073e6; text-align: center; }
                p { font-size: 16px; color: #333; line-height: 1.5; }
                a { color: #0073e6; text-decoration: none; font-weight: bold; }
                footer { text-align: center; margin-top: 20px; font-size: 12px; color: #aaa; }
                .footer-link { color: #0073e6; }
            </style>
        </head>
        <body>
            <div class="container">
                <h1>Redefinição de Senha</h1>
                <p>Olá,</p>
                <p>Recebemos um pedido para redefinir sua senha. Se você não solicitou essa alteração, por favor, ignore este e-mail.</p>
                <p>Para redefinir sua senha, clique no link abaixo:</p>
                <p><a href="http://localhost/tec/php/redefinir-senha.php?token=' . $token . '">Redefinir Senha</a></p>
                <footer>
                    <p>&copy; ' . date('Y') . ' Eduspace. Todos os direitos reservados.</p>
                    <p>Este é um e-mail automático, por favor, não responda.</p>
                    <p><a href="#" class="footer-link">Política de Privacidade</a> | <a href="#" class="footer-link">Termos de Serviço</a></p>
                </footer>
            </div>
        </body>
        </html>';

        $mail->Body = $body;

        $mail->send();
        return "E-mail enviado com sucesso!";
    } catch (Exception $e) {
        return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $stmt = $conn->prepare("SELECT Email FROM professor WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $token = bin2hex(random_bytes(50));
            $expiration = date("Y-m-d H:i:s", strtotime("+1 hour"));

            $updateStmt = $conn->prepare("UPDATE professor SET reset_token = ?, token_expire = ? WHERE Email = ?");
            $updateStmt->bind_param("sss", $token, $expiration, $email);
            $updateStmt->execute();

            $mensagem = enviarEmail($email, $token);
        } else {
            $mensagem = "E-mail não encontrado.";
        }
        $stmt->close();
    } 
    elseif (isset($_POST['nova_senha'], $_POST['token'])) {
        $novaSenha = $_POST['nova_senha'];
        $token = $_POST['token'];

        $stmt = $conn->prepare("SELECT Email, token_expire FROM professor WHERE reset_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['Email'];
            $tokenExpiracao = $row['token_expire'];

            if (strtotime($tokenExpiracao) > time()) {
                $novaSenhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE professor SET Password = ?, reset_token = NULL, token_expire = NULL WHERE Email = ?");
                $updateStmt->bind_param("ss", $novaSenhaHash, $email);
                $updateStmt->execute();
                $mensagem = "Senha alterada com sucesso!";
            } else {
                $mensagem = "O link de redefinição de senha expirou.";
            }
        } else {
            $mensagem = "Token inválido.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="/tec/css/redefinir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>
<body class="light-mode" id="body">
<div class="particles" id="particles-js"></div>

<div class="flex justify-center items-center h-screen">
    <div class="container max-w-md p-6 bg-white rounded shadow-lg">
        <img src="/tec/img/font.svg" alt="Eduspace" class="logo mx-auto mb-4" id="logo">
        <p class="text-center mb-4">Proporcionamos agilidade no seu agendamento, de forma 100% gratuita.</p>

        <h2 class="text-2xl text-center mb-4">Redefinir Senha</h2>

        <?php if (!isset($_GET['token'])) { ?>
            <form method="post" class="space-y-4">
                <div>
                    <label class="block text-sm mb-1">E-mail</label>
                    <input type="email" name="email" placeholder="Digite seu email" class="w-full p-2 rounded border border-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-200 transition" required>
                </div>
                <button type="submit" class="w-full p-2 bg-blue-500 rounded text-white hover:bg-blue-600 transition">Enviar Link</button>
            </form>
        <?php } else { ?>
            <form method="post" class="space-y-4">
                <div>
                    <label class="block text-sm mb-1">Nova Senha</label>
                    <input type="password" name="nova_senha" placeholder="Digite a nova senha" class="w-full p-2 rounded border border-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-200 transition" required>
                </div>
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                <button type="submit" class="w-full p-2 bg-blue-500 rounded text-white hover:bg-blue-600 transition">Alterar Senha</button>
            </form>
        <?php } ?>

        <div class="message mt-4">
            <?php if ($mensagem != ""): ?>
                <div class="alert <?php echo (strpos($mensagem, 'sucesso') !== false) ? 'alert-success' : 'alert-error'; ?>">
                    <i class="<?php echo (strpos($mensagem, 'sucesso') !== false) ? 'fa fa-check-circle' : 'fa fa-exclamation-circle'; ?> mr-2"></i>
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
<script>
    particlesJS("particles-js", {
        "particles": {
            "number": {
                "value": 20, 
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#3b82f6" 
            },
            "shape": {
                "type": "circle"
            },
            "opacity": {
                "value": 0.5
            },
            "size": {
                "value": 5,
                "random": true
            },
            "line_linked": {
                "enable": true,
                "distance": 150,
                "color": "#3b82f6",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 1
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "repulse"
                },
                "onclick": {
                    "enable": true,
                    "mode": "push"
                }
            }
        },
        "retina_detect": true
    });
</script>
</body>
</html>

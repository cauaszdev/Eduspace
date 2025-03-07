<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = htmlspecialchars($_POST['FirstName']);
    $email = htmlspecialchars($_POST['Email']);
    $phoneNumber = htmlspecialchars($_POST['PhoneNumber']);
    $opinion = htmlspecialchars($_POST['Opinion']);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'outlook.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'eduspaceceaat@outlook.com'; 
        $mail->Password = 'Eduspace2007'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587;

        // Configuração do e-mail
        $mail->setFrom('eduspaceceaat@outlook.com', 'Eduspace');
        $mail->addAddress('eduspaceceaat@outlook.com'); 

        $mail->Subject = 'Novo contato do formulário';
        $mail->Body = "Nome: $firstName\nEmail: $email\nNúmero: $phoneNumber\nOpinião: $opinion";

        // Enviar e-mail
        $mail->send();
        echo 'Mensagem enviada com sucesso!';
    } catch (Exception $e) {
        echo "Erro ao enviar a mensagem: {$mail->ErrorInfo}";
    }
}
?>

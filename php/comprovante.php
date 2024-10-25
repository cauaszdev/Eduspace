<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root"; // Altere para seu usuário
$password = ""; // Altere para sua senha
$dbname = "agendamentosala"; // Nome do seu banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recuperar ID do agendamento
$idAgendamento = $_GET['id'];

// Obter as informações do agendamento
$sqlComprovante = "SELECT a.IDagendamento, a.Data, a.Hora, a.Duracao, a.Tipoatividade AS Materia, s.Identificacao, s.Capacidade 
                   FROM agendamento a 
                   JOIN sala s ON a.IDsala = s.IDsala 
                   WHERE a.IDagendamento = $idAgendamento"; // Corrigido para IDagendamento
$result = $conn->query($sqlComprovante);
$comprovante = $result->fetch_assoc();
// Fechar conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Agendamento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Comprovante de Agendamento</h2>
    <?php if ($comprovante): ?>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Sala: <?php echo $comprovante['Identificacao']; ?></h5>
                <p class="card-text">Data: <?php echo $comprovante['Data']; ?></p>
                <p class="card-text">Hora: <?php echo $comprovante['Hora']; ?></p>
                <p class="card-text">Duração: <?php echo $comprovante['Duracao']; ?> minutos</p>
                <p class="card-text">Matéria: <?php echo $comprovante['Materia']; ?></p>
                <p class="card-text">Capacidade da Sala: <?php echo $comprovante['Capacidade']; ?></p>

                <!-- Botões para compartilhar e ver reservas -->
                <div class="mt-3">
                    <button class="btn btn-success" id="baixar-comprovante">Baixar Comprovante</button>
                    <a href="reservas.php" class="btn btn-info">Ver Minhas Reservas</a>
                    <button class="btn btn-primary" id="compartilhar-whatsapp">Compartilhar no WhatsApp</button>
                    <a href="home.php" class="btn btn-secondary">Voltar para Home</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p>Agendamento não encontrado.</p>
    <?php endif; ?>
</div>

<script>
    // Passando os dados do agendamento para o JavaScript
    const comprovante = <?php echo json_encode($comprovante); ?>;
</script>
<script src="/tec/java/comprovante.js"></script> <!-- Incluindo o arquivo JS separado -->
</body>
</html>

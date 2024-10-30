<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 

// Conectando ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Pegando o ID do agendamento da URL
$idAgendamento = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($idAgendamento > 0) { 
    $sql = "SELECT * FROM agendamento WHERE IDagendamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idAgendamento);
    $stmt->execute();
    $result = $stmt->get_result();

    $sqlComprovante = "SELECT a.IDagendamento, a.Data, a.Hora, m.Nome AS Materia, s.Identificacao, s.Capacidade, 
    d.Inicio, d.Fim 
    FROM agendamento a 
    JOIN sala s ON a.IDsala = s.IDsala 
    JOIN professor_materia pm ON a.IDprof = pm.IDprof 
    JOIN materia m ON pm.IDmateria = m.IDmateria 
    JOIN duracao d ON a.IDduracao = d.IDduracao 
    WHERE a.IDagendamento = ?";

    $stmtComprovante = $conn->prepare($sqlComprovante);
    $stmtComprovante->bind_param("i", $idAgendamento);
    $stmtComprovante->execute();
    $resultComprovante = $stmtComprovante->get_result();

    // Armazenando o resultado do comprovante
    $comprovante = $resultComprovante->fetch_assoc();
} else {
    $comprovante = null; 
}

// Fechando a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Eduspace Agendamento</title>
</head>

<style>
/* Estilos conforme o que você já possui */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(to right, #f0f4f8, #d9e4f5);
    margin: 0;
    padding: 20px;
    color: #333;
}

.container {
    max-width: 70%;
    margin: auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.container:hover {
    transform: scale(1.02);
}

h2 {
    text-align: center;
    color: #0056b3;
    margin-bottom: 20px;
    font-size: 2.5em;
    text-transform: uppercase;
}

.card-body {
    padding: 20px;
}

.card-title {
    font-size: 1.8em;
    color: #333;
}

.card-text {
    font-size: 1.1em;
    color: #555;
    margin: 5px 0;
}


.btn {
    display: inline-block;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 10px; 
    width: calc(45% - 20px); 
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-info {
    background-color: #17a2b8;
    color: white;
    text-decoration: none; 
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.button-container {
    display: flex;
    flex-wrap: wrap; 
    justify-content: center; 
}

@media (max-width: 450px) {
    .container {
        margin-top: 70px;
        padding: 15px;
    }

    h2 {
        font-size: 2em;
    }

    .card-title {
        font-size: 1.5em;
    }

    .card-text {
        font-size: 1em;
    }

    .btn {
        padding: 10px;
        font-size: 0.9em;
        width: calc(100% - 20px); 
    }
} 
</style>

<body>
    <div class="container">
        <h2>Comprovante de Agendamento</h2>
        <?php if ($comprovante): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sala: <?php echo $comprovante['Identificacao']; ?></h5>
                    <p><strong>ID Agendamento:</strong> <?php echo $comprovante['IDagendamento']; ?></p>
                    <p class="card-text">Data: <?php echo $comprovante['Data']; ?></p>
                    <p class="card-text">Início: <?php echo $comprovante['Inicio']; ?></p>
                    <p class="card-text">Fim: <?php echo $comprovante['Fim']; ?></p>
                    <p class="card-text">Matéria: <?php echo $comprovante['Materia']; ?></p>
    
                    <div class="button-container mt-3">
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    const { jsPDF } = window.jspdf;
    const comprovante = <?php echo json_encode($comprovante); ?>;

    document.getElementById('baixar-comprovante').onclick = function() {
        const doc = new jsPDF();

        doc.setFontSize(18);
        doc.text("Comprovante de Agendamento", 10, 10);
        doc.setFontSize(12);
        doc.text(`Sala: ${comprovante.Identificacao}`, 10, 20);
        doc.text(`Data: ${comprovante.Data}`, 10, 30);
        doc.text(`Início: ${comprovante.Inicio}`, 10, 40);
        doc.text(`Fim: ${comprovante.Fim}`, 10, 50);      
        doc.text(`Matéria: ${comprovante.Materia}`, 10, 60);

        doc.save('comprovante_agendamento.pdf');
    };

    document.getElementById('compartilhar-whatsapp').onclick = function() {
        const mensagem = encodeURIComponent(`Estou compartilhando meu comprovante de agendamento:\nSala: ${comprovante.Identificacao}\nData: ${comprovante.Data}\nInício: ${comprovante.Inicio}\nFim: ${comprovante.Fim}\nMatéria: ${comprovante.Materia}`);
        const urlWhatsApp = `https://api.whatsapp.com/send?text=${mensagem}`;
        window.open(urlWhatsApp, '_blank');
    };
</script>
</body>
</html>

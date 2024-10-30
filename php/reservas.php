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

function getReservations($status) {
    global $conn, $loggedInProfId;
    $today = date('Y-m-d');

    switch ($status) {
        case 'abertas':
            $sql = "SELECT a.IDagendamento, a.Data, d.Inicio, d.Fim, a.Status, 
                           s.Identificacao AS Sala, m.Nome AS Materia
                    FROM agendamento a
                    JOIN sala s ON a.IDsala = s.IDsala
                    JOIN professor_materia pm ON a.IDprof = pm.IDprof
                    JOIN materia m ON pm.IDmateria = m.IDmateria
                    JOIN duracao d ON a.IDduracao = d.IDduracao
                    WHERE a.Data >= '$today' AND a.IDprof = ?";
            break;

        case 'concluidas':
            $sql = "SELECT a.IDagendamento, a.Data, d.Inicio, d.Fim, a.Status, 
                           s.Identificacao AS Sala, m.Nome AS Materia
                    FROM agendamento a
                    JOIN sala s ON a.IDsala = s.IDsala
                    JOIN professor_materia pm ON a.IDprof = pm.IDprof
                    JOIN materia m ON pm.IDmateria = m.IDmateria
                    JOIN duracao d ON a.IDduracao = d.IDduracao
                    WHERE a.Data < '$today' AND a.IDprof = ?";
            break;

        case 'todas':
            $sql = "SELECT a.IDagendamento, a.Data, d.Inicio, d.Fim, a.Status, 
                           s.Identificacao AS Sala, m.Nome AS Materia, p.Nome AS Professor
                    FROM agendamento a
                    JOIN sala s ON a.IDsala = s.IDsala
                    JOIN professor_materia pm ON a.IDprof = pm.IDprof
                    JOIN professor p ON a.IDprof = p.IDprof
                    JOIN materia m ON pm.IDmateria = m.IDmateria
                    JOIN duracao d ON a.IDduracao = d.IDduracao";
            break;

        default:
            return [];
    }

    $stmt = $conn->prepare($sql);
    if ($status !== 'todas' && $loggedInProfId) {
        $stmt->bind_param("i", $loggedInProfId);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $reservas = [];
    while ($row = $result->fetch_assoc()) {
        $reservas[] = $row;
    }
    $stmt->close();
    return $reservas;
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $reservas = getReservations($status);
    echo json_encode($reservas);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['delete_id'] ?? null;

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM agendamento WHERE IDagendamento = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'ID inválido.']);
    }
    exit;
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Reservas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Minhas Reservas</h1>
        <div class="button-container text-center mb-4">
            <button class="reservas-button btn btn-primary mx-2" onclick="showReservations('abertas')">Minhas Reservas Abertas</button>
            <button class="reservas-button btn btn-success mx-2" onclick="showReservations('concluidas')">Minhas Reservas Concluídas</button>
            <button class="reservas-button btn btn-info mx-2" onclick="showReservations('todas')">Todas as Reservas</button>
        </div>

        <div id="infoText" class="info-text"></div>
    </div>

    <script src="/tec/java/reservas.js"></script>
</body>
</html>


<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


function getReservations($status) {
    global $conn;
    $today = date('Y-m-d');

    
    switch ($status) {
        case 'abertas':
            $sql = "SELECT * FROM agendamento WHERE Data >= '$today'";
            break;
        case 'concluidas':
            $sql = "SELECT * FROM agendamento WHERE Data < '$today'";
            break;
        case 'todas':
            $sql = "SELECT * FROM agendamento";
            break;
        default:
            return [];
    }

    $result = $conn->query($sql);
    $reservas = [];

    if ($result->num_rows > 0) {
        
        while ($row = $result->fetch_assoc()) {
            $reservas[] = $row;
        }
    }
    return $reservas;
}


if (isset($_GET['status'])) {
    $status = $_GET['status'];
    $reservas = getReservations($status);
    echo json_encode($reservas);
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
    <link rel="stylesheet" href="/tec/css/reservas.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Minhas Reservas</h1>
        <div class="button-container text-center mb-4">
            <button class="reservas-button btn btn-primary mx-2" onclick="showReservations('abertas')">Reservas Abertas</button>
            <button class="reservas-button btn btn-success mx-2" onclick="showReservations('concluidas')">Reservas Concluídas</button>
            <button class="reservas-button btn btn-info mx-2" onclick="showReservations('todas')">Todas as Reservas</button>
        </div>

        <div id="infoText" class="info-text"></div>
    </div>

    <script src="/tec/java/reservas.js"></script>
</body>
</html>


<?php
// Exemplo da função em reservas.php
function getReservations($status) {
    global $conn;
    $today = date('Y-m-d');

    // Verifica o tipo de reservas a serem buscadas
    switch ($status) {
        case 'abertas':
            $sql = "SELECT agendamento.*, sala.Identificacao AS sala FROM agendamento 
                    JOIN sala ON agendamento.IDsala = sala.IDsala 
                    WHERE agendamento.Data >= '$today'";
            break;
        case 'concluidas':
            $sql = "SELECT agendamento.*, sala.Identificacao AS sala FROM agendamento 
                    JOIN sala ON agendamento.IDsala = sala.IDsala 
                    WHERE agendamento.Data < '$today'";
            break;
        case 'todas':
            $sql = "SELECT agendamento.*, sala.Identificacao AS sala FROM agendamento 
                    JOIN sala ON agendamento.IDsala = sala.IDsala";
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

?>

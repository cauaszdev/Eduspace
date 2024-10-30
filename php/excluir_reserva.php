<?php
// Iniciar sessão para identificar o professor logado
session_start();
include('conexao.php'); // Conexão com o banco de dados

// Verificar se o ID da reserva foi enviado via POST
if (isset($_POST['IDagendamento']) && isset($_SESSION['IDprof'])) {
    $IDagendamento = intval($_POST['IDagendamento']);
    $IDprofessor = intval($_SESSION['IDprof']);

    // Verificar se a reserva pertence ao professor logado
    $query = "SELECT * FROM agendamento WHERE IDagendamento = ? AND IDprof = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $IDagendamento, $IDprofessor);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Excluir a reserva
        $deleteQuery = "DELETE FROM agendamento WHERE IDagendamento = ? AND IDprof = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("ii", $IDagendamento, $IDprofessor);
        
        if ($deleteStmt->execute()) {
            echo "Reserva excluída com sucesso.";
        } else {
            echo "Erro ao excluir a reserva.";
        }
    } else {
        echo "Reserva não encontrada ou não pertence ao professor.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acesso inválido.";
}
?>

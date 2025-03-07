<?php 
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agendamentosala";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Erro na conexão com o banco de dados.']));
}

$idProfessor = $_SESSION['IDprof'];
$sala_id = $_POST['sala'];
$data = $_POST['data'];
$materia = $_POST['materia'];
$duracao_id = $_POST['duracao']; 

$sqlVerificacao = "SELECT * FROM agendamento WHERE Data = ? AND IDsala = ? AND Tipoatividade = ?";
$stmtVerificacao = $conn->prepare($sqlVerificacao);
$stmtVerificacao->bind_param('sis', $data, $sala_id, $materia);
$stmtVerificacao->execute();
$resultVerificacao = $stmtVerificacao->get_result();

if ($resultVerificacao->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'A sala já está agendada neste horário. Por favor, escolha outra.']);
    exit; 
}

$inserir = "INSERT INTO agendamento (Data, Tipoatividade, IDprof, IDsala, Status, IDduracao) 
            VALUES (?, ?, ?, ?, 'Agendado', ?)";
$stmtInserir = $conn->prepare($inserir);

if ($stmtInserir) {
    $stmtInserir->bind_param('siiis', $data, $materia, $idProfessor, $sala_id, $duracao_id);

    if ($stmtInserir->execute()) {
        $IDagendamento = $conn->insert_id; 
        echo json_encode(['status' => 'success', 'message' => 'Agendamento realizado com sucesso!', 'IDagendamento' => $IDagendamento]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao agendar: ' . $conn->error]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao preparar a consulta: ' . $conn->error]);
}

$conn->close();
?>

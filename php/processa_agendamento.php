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
$idProfessor = 1; // ID do professor logado (substitua conforme sua lógica de autenticação)
$sala_id = $_POST['sala'];
$data = $_POST['data'];
$hora = $_POST['hora'];
$duracao = $_POST['duracao'];
$materia = $_POST['materia'];
$sqlVerificacao = "SELECT * FROM agendamento WHERE Data = '$data' AND Hora = '$hora' AND IDsala = '$sala_id'";
$resultVerificacao = $conn->query($sqlVerificacao);

if ($resultVerificacao->num_rows > 0) {
    echo "<p style='color: red;'>A sala já está agendada neste horário. Por favor, escolha outro.</p>";
} else {
    // Inserindo o novo agendamento
    $inserir = "INSERT INTO agendamento (Data, Hora, IDprof, IDsala, Tipoatividade, Status) 
                VALUES ('$data', '$hora', '$idProfessor', '$sala_id', '$materia', 'Agendado')";

    if ($conn->query($inserir) === TRUE) {
        header("Location: comprovante.php?id=" . $conn->insert_id);
    } else {
        echo "<p style='color: red;'>Erro ao agendar: " . $conn->error . "</p>";
    }
}

// Fechar conexão
$conn->close();
?>

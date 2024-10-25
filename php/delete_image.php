<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 


$mysqli = new mysqli($servername, $username, $password, $dbname);


if ($mysqli->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->connect_error);
}

session_start();
$id_professor = $_SESSION['Idprof']; 


$sql = "UPDATE professor SET imagem = NULL WHERE Idprof = ?";
$stmt = $mysqli->prepare($sql);


if ($stmt === false) {
    die("Erro ao preparar a consulta: " . $mysqli->error);
}


$stmt->bind_param("i", $id_professor);

if ($stmt->execute()) {
    echo "Imagem removida com sucesso.";
} else {
    echo "Erro ao remover a imagem: " . $stmt->error;
}


header("Location: perfil.php");
exit(); 
?>

<?php
session_start();
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->connect_error);
}

if (isset($_SESSION['IDprof'])) {
    $idprof = $_SESSION['IDprof'];
    $stmt = $mysqli->prepare("SELECT imagem FROM professor WHERE IDprof = ?");
    $stmt->bind_param("i", $idprof);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagemPath = $row['imagem'];

        if (file_exists($imagemPath)) {
            unlink($imagemPath);
        }

        
        $stmt = $mysqli->prepare("UPDATE professor SET imagem = NULL WHERE IDprof = ?");
        $stmt->bind_param("i", $idprof);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Imagem removida com sucesso.";
        } else {
            $_SESSION['message'] = "Erro ao remover a imagem do banco de dados.";
        }
        $stmt->close();
    } else {
        echo "Imagem não encontrada.";
    }
} else {
    echo "ID do professor não está definido.";
}

$mysqli->close();
header("Location: perfil.php");
exit();
?>

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagem'])) {
    $imagem = $_FILES['imagem'];
    $target_dir = "uploads/"; 
    $target_file = $target_dir . basename($imagem["name"]);

    
    if (getimagesize($imagem["tmp_name"]) === false) {
        die("O arquivo enviado não é uma imagem.");
    }

    
    if (move_uploaded_file($imagem["tmp_name"], $target_file)) {
        
        $sql = "UPDATE professor SET imagem = ? WHERE Idprof = ?";
        $stmt = $mysqli->prepare($sql);
        
        
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . $mysqli->error);
        }

        
        $stmt->bind_param("si", $target_file, $id_professor);
        
        if ($stmt->execute()) {
            
            echo "Imagem atualizada com sucesso.";
        } else {
            echo "Erro ao atualizar a imagem: " . $stmt->error;
        }
    } else {
        echo "Desculpe, houve um erro ao enviar sua imagem.";
    }
}


header("Location: perfil.php");
exit(); 
?>

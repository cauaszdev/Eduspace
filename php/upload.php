<?php
$servername = "localhost"; // Host do banco de dados
$username = "root"; // Usuário do banco de dados
$password = ""; // Senha do banco (vazio por padrão no XAMPP)
$dbname = "agendamentosala"; // Nome do banco de dados

// Criar conexão com o banco de dados usando mysqli
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Verificar se houve erro na conexão
if ($mysqli->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->connect_error);
}

session_start();
$id_professor = $_SESSION['Idprof'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagem'])) {
    $imagem = $_FILES['imagem'];
    $target_dir = "uploads/"; // Diretório para salvar as imagens
    $target_file = $target_dir . basename($imagem["name"]);

    // Verificar se a imagem é uma imagem real
    if (getimagesize($imagem["tmp_name"]) === false) {
        die("O arquivo enviado não é uma imagem.");
    }

    // Mover o arquivo para o diretório desejado
    if (move_uploaded_file($imagem["tmp_name"], $target_file)) {
        // Atualizar o banco de dados com o caminho da imagem
        $sql = "UPDATE professor SET imagem = ? WHERE Idprof = ?";
        $stmt = $mysqli->prepare($sql);
        
        // Verifica se a preparação do statement foi bem-sucedida
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . $mysqli->error);
        }

        // Vincula os parâmetros e executa a consulta
        $stmt->bind_param("si", $target_file, $id_professor);
        
        if ($stmt->execute()) {
            // Exibição de uma mensagem de sucesso se necessário
            echo "Imagem atualizada com sucesso.";
        } else {
            echo "Erro ao atualizar a imagem: " . $stmt->error;
        }
    } else {
        echo "Desculpe, houve um erro ao enviar sua imagem.";
    }
}

// Redirecionar de volta para o perfil
header("Location: perfil.php");
exit(); // Sempre é bom usar exit após redirecionar
?>

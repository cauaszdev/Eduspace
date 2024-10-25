<?php
session_start(); // Certifique-se de que a sessão está iniciada

// Conexão com o banco de dados
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 

// Criação da conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificação da conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifique se a ID do professor está definida na sessão
if (isset($_SESSION['Idprof'])) {
    $idprof = $_SESSION['Idprof'];

    // Prepare a consulta
    $stmt = $conn->prepare("SELECT * FROM professor WHERE Idprof = ?");
    $stmt->bind_param("i", $idprof);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifique se o professor foi encontrado
    if ($result->num_rows > 0) {
        $professor = $result->fetch_assoc();
    } else {
        echo "Professor não encontrado.";
    }
} else {
    echo "ID do professor não está definido.";
}

$conn->close(); // Feche a conexão
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Professor</title>
    <link rel="stylesheet" href="/tec/css/perfil.css"> <!-- Link para o seu CSS -->
</head>
<body>
    <div class="container">
        <?php if (isset($professor)): ?>
            <div class="imagem-container">
                <?php if (!empty($professor['imagem'])): ?>
                    <img src="<?php echo htmlspecialchars($professor['imagem']); ?>" alt="Imagem do Professor" id="imagemProf" />
                <?php else: ?>
                    <p>Imagem não disponível.</p>
                <?php endif; ?>
            </div>
            <h1>Perfil de <?php echo htmlspecialchars($professor['Nome']); ?></h1>
            <p class="email">Email: <?php echo htmlspecialchars($professor['Email']); ?></p>
            <p>Disponibilidade: <?php echo htmlspecialchars($professor['Disponibilidade']); ?></p>
            <p>Contato: <?php echo htmlspecialchars($professor['Contato']); ?></p>
            <div class="materias">
                <h2>Matérias Ensinadas</h2>
                <p><?php echo nl2br(htmlspecialchars($professor['Matérias Ensinadas'])); ?></p>
            </div>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label for="image">Adicionar/Remover Imagem:</label>
                <input type="file" name="imagem" id="image" accept="image/*"> <!-- Corrigido para 'imagem' -->
                <input type="submit" value="Enviar">
            </form>
        <?php else: ?>
            <p>Não há informações disponíveis.</p>
        <?php endif; ?>
    </div>
</body>
</html>
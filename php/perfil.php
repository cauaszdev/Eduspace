<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->connect_error);
}

session_start();

$professor = null; 

if (isset($_SESSION['IDprof'])) {
    $idprof = $_SESSION['IDprof'];

    $stmt = $mysqli->prepare("SELECT * FROM professor WHERE IDprof = ?");
    $stmt->bind_param("i", $idprof);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $professor = $result->fetch_assoc();
    } else {
        echo "Professor não encontrado.";
    }
} else {
    echo "ID do professor não está definido.";
}

$materias = [];
if ($professor) {
    $stmt = $mysqli->prepare("
        SELECT m.Nome 
        FROM materia AS m 
        JOIN professor_materia AS pm ON m.IDmateria = pm.IDmateria 
        WHERE pm.IDprof = ?
    ");
    $stmt->bind_param("i", $idprof);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $materias[] = $row['Nome'];
    }
}

$mysqli->close(); 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Professor</title>
    <link rel="stylesheet" href="/tec/css/perfil.css"> 
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert">
                <?php echo $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>
        <?php if ($professor): ?>
            <div class="imagem-container"> 
                <?php if (!empty($professor['imagem'])): ?>
                    <img src="<?php echo htmlspecialchars($professor['imagem']); ?>" alt="Imagem do Professor" id="imagemProf" />
                <?php else: ?>
                    <p>Nenhuma imagem enviada.</p>
                <?php endif; ?>
            </div>
            <h1>Perfil de <?php echo htmlspecialchars($professor['Nome']); ?></h1>
            <p class="email">Email: <?php echo htmlspecialchars($professor['Email']); ?></p>
            <p>Disponibilidade: <?php echo htmlspecialchars($professor['Disponibilidade']); ?></p>
            <p>Contato: <?php echo htmlspecialchars($professor['Contato']); ?></p>
            <div class="materias">
                <h2>Matérias Ensinadas</h2>
                <?php if (!empty($materias)): ?>
                    <ul>
                        <?php foreach ($materias as $materia): ?>
                            <li><?php echo htmlspecialchars($materia); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Nenhuma matéria registrada.</p>
                <?php endif; ?>
            </div>
            <form action="upload.php" method="post" enctype="multipart/form-data">
    <label for="upload" class="label-upload">Escolher Imagem</label>
    <input type="file" name="imagem" id="upload" required>
    <button type="submit" class="botao-enviar">Enviar</button>
</form>
    <form action="delete_image.php" method="post">
    <button type="submit" class="remover" onclick="return confirm('Tem certeza que deseja remover a imagem?');">
        Remover Imagem
    </button>
</form>
        <?php else: ?>
            <p>Não há informações disponíveis.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}


$sql = "SELECT * FROM sala WHERE Disponivel = 'Sim'";
$result = $conn->query($sql);


$salas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $salas[] = $row;
    }
}


$idProfessor = 1; 
$sqlMaterias = "SELECT `Matérias Ensinadas` FROM professor WHERE IDprof = $idProfessor";
$resultMaterias = $conn->query($sqlMaterias);
$materia = ($resultMaterias->num_rows > 0) ? $resultMaterias->fetch_assoc()['Matérias Ensinadas'] : '';


$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Agendamento</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Agendamento de Salas</h2>
    <form action="processa_agendamento.php" method="POST">
        <div class="form-group">
            <label for="sala">Selecione uma sala disponível:</label>
            <select class="form-control" id="sala" name="sala" required>
                <option value="">Escolha uma sala</option>
                <?php foreach ($salas as $sala): ?>
                    <option value="<?php echo $sala['IDsala']; ?>">
                        <?php echo $sala['Identificacao']; ?> - Capacidade: <?php echo $sala['Capacidade']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="materia">Selecione a matéria:</label>
            <input type="text" class="form-control" id="materia" name="materia" value="<?php echo $materia; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="data">Data:</label>
            <input type="date" class="form-control" id="data" name="data" required>
        </div>

        <div class="form-group">
            <label for="hora">Hora:</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
        </div>

        <div class="form-group">
            <label for="duracao">Duração (em minutos):</label>
            <input type="number" class="form-control" id="duracao" name="duracao" required>
        </div>

        <button type="submit" class="btn btn-primary">Agendar</button>
    </form>
</div>

</body>
</html>


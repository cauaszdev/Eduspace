<?php
session_start(); 

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (!isset($_SESSION['IDprof'])) {
    die("Acesso negado. Você não está logado."); 
}

$idProfessor = $_SESSION['IDprof'];

$sql = "SELECT * FROM sala WHERE Disponivel = 'Sim'";
$result = $conn->query($sql);

$salas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $salas[] = $row;
    }
}

$sqlMaterias = "
    SELECT m.IDmateria, m.Nome 
    FROM materia m 
    JOIN professor_materia pm ON m.IDmateria = pm.IDmateria 
    WHERE pm.IDprof = $idProfessor";
$resultMaterias = $conn->query($sqlMaterias);

$materias = [];
if ($resultMaterias->num_rows > 0) {
    while($row = $resultMaterias->fetch_assoc()) {
        $materias[] = $row;
    }
}

$sqlDuracao = "SELECT * FROM duracao";
$resultDuracao = $conn->query($sqlDuracao);

$duracoes = [];
if ($resultDuracao->num_rows > 0) {
    while($row = $resultDuracao->fetch_assoc()) {
        $duracoes[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eduspace Agendamento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="/tec/css/agendamento.css">
</head>
<body>

<div class="container">
    <h2>Agendamento de Salas</h2>
    <form id="formAgendamento" method="POST">
        <input type="hidden" name="idProfessor" value="<?php echo $idProfessor; ?>">
        
        <div class="form-group">
            <label for="sala" class="label-sala">Selecione uma sala disponível:</label>
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
            <select class="form-control" id="materia" name="materia" required>
                <option value="">Escolha uma matéria</option>
                <?php foreach ($materias as $materia): ?>
                    <option value="<?php echo $materia['IDmateria']; ?>">
                        <?php echo $materia['Nome']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="data">Data:</label>
            <input type="date" class="form-control" id="data" name="data" required>
        </div>

        <div class="form-group">
            <label for="duracao">Selecione a duração:</label>
            <select class="form-control" id="duracao" name="duracao" required>
                <option value="">Escolha uma duração</option>
                <?php foreach ($duracoes as $duracao): ?>
                    <option value="<?php echo $duracao['IDduracao']; ?>">
                        <?php echo $duracao['Inicio'] . ' - ' . $duracao['Fim']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="button" class="btn btn-primary" id="confirmButton">Agendar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#confirmButton').on('click', function() {
        Swal.fire({
            title: 'Confirmação de Agendamento',
            text: "Você tem certeza que deseja agendar esta sala?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, agendar!',
            cancelButtonText: 'Não, cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'processa_agendamento.php',
                    type: 'POST',
                    data: $('#formAgendamento').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            title: response.status === 'success' ? 'Sucesso' : 'Erro',
                            text: response.message,
                            icon: response.status === 'success' ? 'success' : 'error',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            if (response.status === 'success') {
                                window.location.href = 'comprovante.php?id=' + response.IDagendamento;
                            }
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Erro',
                            text: 'Ocorreu um erro ao processar o agendamento.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
</script>
</body>
</html>

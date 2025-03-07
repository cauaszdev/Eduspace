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
    <title>Eduspace - Agendamento de Salas</title>
    <link rel="stylesheet" href="/css/agendamento.css"> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<body>
    <div id="particles-js" style="position: absolute; width: 100%; height: 100%; z-index: -1;"></div>
    <div class="background-animation"></div>
    <div class="container animate__animated animate__fadeInUp">
        <div class="text-center mb-5">
            <img src="/tec/img/font.svg" alt="Logo Eduspace" style="width: 100px; height: 100px;">
            <h2 class="text-3xl font-semibold text-gray-800">Agende uma Sala <span class="highlight">Eduspace</span></h2>
            <p class="text-gray-600 mt-2">Simplifique o seu agendamento com um toque.</p>
        </div>
        <form id="formAgendamento">
            <div class="mb-4">
                <label for="sala" class="form-label text-lg">Selecione uma sala disponível</label>
                <select class="form-select text-gray-800" id="sala" name="sala" required>
                    <option value="">Escolha uma sala</option>
                    <?php foreach ($salas as $sala): ?>
                        <option value="<?php echo $sala['IDsala']; ?>">
                            <?php echo $sala['Identificacao']; ?> - Capacidade: <?php echo $sala['Capacidade']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="materia" class="form-label text-lg">Selecione a matéria</label>
                <select class="form-select text-gray-800" id="materia" name="materia" required>
                    <option value="">Escolha uma matéria</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?php echo $materia['IDmateria']; ?>">
                            <?php echo $materia['Nome']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="data" class="form-label text-lg">Data</label>
                <input type="date" class="form-control text-gray-800" id="data" name="data" required>
            </div>

            <div class="mb-4">
                <label for="duracao" class="form-label text-lg">Duração</label>
                <select class="form-select text-gray-800" id="duracao" name="duracao" required>
                    <option value="">Escolha a duração</option>
                    <?php foreach ($duracoes as $duracao): ?>
                        <option value="<?php echo $duracao['IDduracao']; ?>">
                            <?php echo $duracao['Inicio'] . ' - ' . $duracao['Fim']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        <button type="button" class="btn btn-primary" id="confirmButton">
        <i class="fas fa-calendar-check mr-2"></i> Confirmar Agendamento
        </button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
<script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 20, 
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#3b82f6" 
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 5,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#3b82f6", 
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 1, 
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse" 
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 100, 
                        "duration": 0.8 
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });

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

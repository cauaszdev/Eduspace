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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/perfil.css">
</head>
<body>
<div id="particles-js" style="position: absolute; width: 100%; height: 100%; z-index: -1;"></div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5 bg-white rounded shadow-lg p-4">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-warning">
                        <?php echo $_SESSION['message']; ?>
                        <?php unset($_SESSION['message']); ?>
                    </div>
                <?php endif; ?>
                <?php if ($professor): ?>
                    <div class="text-center">
    <div class="imagem-container mb-3"> 
        <?php if (!empty($professor['imagem'])): ?>
            <img src="<?php echo htmlspecialchars($professor['imagem']); ?>" alt="Imagem do Professor" class="img-fluid rounded-circle border border-primary" />
        <?php else: ?>
            <div class="img-placeholder">Sem Imagem</div>
        <?php endif; ?>
    </div>
    <h1 class="display-4 text-black"><?php echo htmlspecialchars($professor['Nome']); ?></h1> 
    <p class="lead text-muted">Email: <?php echo htmlspecialchars($professor['Email']); ?></p>
    <p>Disponibilidade: <strong><?php echo htmlspecialchars($professor['Disponibilidade']); ?></strong></p>
    <p>Contato: <strong><?php echo htmlspecialchars($professor['Contato']); ?></strong></p>
</div>
<div class="materias my-4">
    <h2 class="text-black">Matérias Ensinadas</h2> 
    <?php if (!empty($materias)): ?>
        <ul class="list-group">
            <?php foreach ($materias as $materia): ?>
                <li class="list-group-item text-black"><?php echo htmlspecialchars($materia); ?></li> 
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-muted">Nenhuma matéria registrada.</p>
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
</script>
</body>
</html>

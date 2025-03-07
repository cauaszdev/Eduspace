<?php
include('conexao.php'); 

$mensagem = ""; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $lembrar = isset($_POST['lembrar']);

    if (strlen($email) == 0) {
        $mensagem = "Preencha seu e-mail.";
    } elseif (strlen($senha) == 0) {
        $mensagem = "Preencha sua senha.";
    } else {
        $email = $mysqli->real_escape_string($email);
        $senha = $mysqli->real_escape_string($senha);

        $sql_code = "SELECT * FROM professor WHERE Email = '$email'";
        $sql_query = $mysqli->query($sql_code) or die("Erro na consulta SQL: " . $mysqli->error);
        
        if ($sql_query->num_rows == 1) {
            $professor = $sql_query->fetch_assoc();
        
            if (password_verify($senha, $professor['Password'])) {
                session_start();
                $_SESSION['IDprof'] = $professor['IDprof'];
                $_SESSION['nome'] = $professor['Nome'];
        
                if ($lembrar) {
                    setcookie('email', $email, time() + (86400 * 30), "/");
                    setcookie('senha', $senha, time() + (86400 * 30), "/");
                } else {
                    if (isset($_COOKIE['email'])) {
                        setcookie('email', '', time() - 3600, "/");
                    }
                    if (isset($_COOKIE['senha'])) {
                        setcookie('senha', '', time() - 3600, "/");
                    }
                }
        
                header("Location: home.php");
                exit();
            } else {
                $mensagem = "E-mail ou senha incorretos.";
            }
        }
    }
}        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/tec/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <title>Login</title>
</head>
<body class="light-mode" id="body">

<div class="particles" id="particles-js"></div>

<div class="flex justify-center items-center h-screen">
    <div class="container max-w-md p-6">
        <img src="/tec/img/font.svg" alt="Eduspace" class="logo mx-auto mb-4" id="logo"> 
        <p class="text-center mb-4">Proporcionamos agilidade no seu agendamento, de forma 100% gratuita.</p>

        <?php if ($mensagem): ?>
            <p class="text-red-500 text-center mb-4"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm mb-1">E-mail</label>
                <input type="text" name="email" placeholder="@professor.enova.educacao.ba.gov.br" class="w-full p-2 rounded border border-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-200 transition" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>">
            </div>
            <div>
                <label class="block text-sm mb-1 flex justify-between items-center">
                    Senha
                    <a href="redefinirlink.php" class="text-blue-400 hover:underline">Esqueci minha senha</a>
                </label>
                <div class="relative">
                    <input id="senha" type="password" name="senha" placeholder="*****" class="w-full p-2 rounded border border-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-200 transition" value="<?php echo isset($_COOKIE['senha']) ? $_COOKIE['senha'] : ''; ?>">
                    <i class="fas fa-eye" id="toggleSenha" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
            </div>
            <button type="submit" class="w-full p-2 bg-blue-500 rounded text-white hover:bg-blue-600 transition">Entrar</button>
            <div class="checkbox-wrapper-43">
                <input type="checkbox" id="cbx-43" name="lembrar" <?php echo isset($_COOKIE['email']) ? 'checked' : ''; ?>>
                <label for="cbx-43" class="check">
                    <svg width="18px" height="18px" viewBox="0 0 18 18">
                        <path d="M1,9 L1,3.5 C1,2 2,1 3.5,1 L14.5,1 C16,1 17,2 17,3.5 L17,14.5 C17,16 16,17 14.5,17 L3.5,17 C2,17 1,16 1,14.5 L1,9 Z"></path>
                        <polyline points="1 9 7 14 15 4"></polyline>
                    </svg>
                </label>
                <span>Lembrar de mim</span>
            </div>
        </form>
    
        <button id="theme-toggle" class="theme-toggle-button mt-4 w-full p-2 bg-gray-200 rounded hover:bg-gray-300 transition">
            <span id="theme-text">Modo Escuro</span>
        </button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
<script>

const toggleSenha = document.getElementById('toggleSenha');
const senhaInput = document.getElementById('senha');
const body = document.getElementById('body');

toggleSenha.addEventListener('click', () => {
    const type = senhaInput.type === 'password' ? 'text' : 'password';
    senhaInput.type = type;

    toggleSenha.classList.toggle('fa-eye');
    toggleSenha.classList.toggle('fa-eye-slash');

if (type === 'text') {
        senhaInput.classList.add('text-visible');
    } else {
        senhaInput.classList.remove('text-visible');
    }
});

const toggleButton = document.getElementById('theme-toggle');
toggleButton.addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');
    document.body.classList.toggle('light-mode');

    if (document.body.classList.contains('dark-mode')) {
        toggleButton.textContent = 'Modo Claro';
    } else {
        toggleButton.textContent = 'Modo Escuro';
    }
});

document.body.classList.add('light-mode');


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

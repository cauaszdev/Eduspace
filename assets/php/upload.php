<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "agendamentosala");

if ($mysqli->connect_error) {
    die("Conexão falhou: " . $mysqli->connect_error);
}

if (isset($_SESSION['IDprof'])) {
    $id_professor = $_SESSION['IDprof'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['imagem'])) {
        $imagePath = 'uploads/' . basename($_FILES['imagem']['name']);

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $imagePath)) {
            $query = "UPDATE professor SET imagem = ? WHERE IDprof = ?";
            $stmt = $mysqli->prepare($query);

            if ($stmt) {
                $stmt->bind_param("si", $imagePath, $id_professor);

                if ($stmt->execute()) {
                    echo "Imagem atualizada com sucesso.";
                } else {
                    echo "Erro ao atualizar imagem: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Erro na preparação da consulta: " . $mysqli->error;
            }
        } else {
            echo "Erro ao mover o arquivo para o diretório de uploads.";
        }
    }
} else {
    echo "Usuário não está logado.";
}

$mysqli->close();
header("Location: perfil.php");
exit();
?>

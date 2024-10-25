<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 


$mysqli = new mysqli($servername, $username, $password, $dbname);


if ($mysqli->connect_error) {
    die("Falha ao conectar ao banco de dados: " . $mysqli->connect_error);
}
?>

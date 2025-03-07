<?php
header('Content-Type: application/json');
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "agendamentosala"; 


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Falha na conexão com o banco de dados']));
}

$query = "SELECT message, timestamp FROM notifications ORDER BY timestamp DESC";
$result = $conn->query($query);

$notifications = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}

$conn->close();
echo json_encode($notifications);
?>

<?php
$servername = "mysql.railway.internal";
$username = "root";
$password = "xFfssohUtwgMOzZMNzdWsxzpQVXxgzgR";
$dbname = "railway";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

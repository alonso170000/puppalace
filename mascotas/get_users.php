<?php
$host = 'localhost'; // Cambiar si es necesario
$user = 'root';      // Cambiar si es necesario
$password = '';      // Cambiar si es necesario
$dbname = 'animals'; // Nombre de tu base de datos

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Obtener el ID del usuario desde la URL, si existe
$usuario_id = isset($_GET['usuario_id']) ? (int) $_GET['usuario_id'] : 0;

if ($usuario_id > 0) {
    // Si se pasa un usuario_id, obtenemos solo ese usuario
    $sql = "SELECT usuario_id, nombre_usuario, correo_electronico, password FROM usuarios WHERE usuario_id = $usuario_id";
} else {
    // Si no se pasa un usuario_id, obtenemos todos los usuarios
    $sql = "SELECT usuario_id, nombre_usuario, correo_electronico FROM usuarios";
}

$result = $conn->query($sql);

$usuarios = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($usuarios);

$conn->close();
?>

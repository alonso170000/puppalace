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

// Obtener el ID del administrador desde la URL, si existe
$admin_id = isset($_GET['admin_id']) ? (int) $_GET['admin_id'] : 0;

if ($admin_id > 0) {
    // Si se pasa un admin_id, obtenemos solo ese administrador
    $sql = "SELECT admin_id, nombre_admin, correo_electronico, password FROM admins WHERE admin_id = $admin_id";
} else {
    // Si no se pasa un admin_id, obtenemos todos los administradores
    $sql = "SELECT admin_id, nombre_admin, correo_electronico FROM admins";
}

$result = $conn->query($sql);

$admins = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($admins);

$conn->close();
?>

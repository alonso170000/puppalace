<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "animals";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Error de conexión: ' . $conn->connect_error]));
}

// Obtener el ID del administrador desde el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));
$admin_id = $data->admin_id;

// Validar que el ID del administrador esté presente
if (empty($admin_id)) {
    echo json_encode(['success' => false, 'error' => 'ID de administrador no proporcionado']);
    exit;
}

// Consulta SQL para eliminar al administrador
$sql = "DELETE FROM admins WHERE admin_id = $admin_id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al eliminar el administrador: ' . $conn->error]);
}

// Cerrar la conexión
$conn->close();
?>

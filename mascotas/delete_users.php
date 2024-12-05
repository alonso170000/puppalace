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

// Obtener el ID del usuario desde el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));
$usuario_id = $data->usuario_id;

// Validar que el ID del usuario esté presente
if (empty($usuario_id)) {
    echo json_encode(['success' => false, 'error' => 'ID de usuario no proporcionado']);
    exit;
}

// Consulta SQL para eliminar al usuario
$sql = "DELETE FROM usuarios WHERE usuario_id = $usuario_id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al eliminar el usuario: ' . $conn->error]);
}

// Cerrar la conexión
$conn->close();
?>

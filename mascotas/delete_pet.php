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

// Obtener el ID de la mascota desde el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"));
$mascota_id = $data->mascota_id;

// Validar que el ID de la mascota esté presente
if (empty($mascota_id)) {
    echo json_encode(['success' => false, 'error' => 'ID de mascota no proporcionado']);
    exit;
}

// Consulta SQL para eliminar la mascota
$sql = "DELETE FROM mascotas WHERE mascota_id = $mascota_id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Error al eliminar la mascota: ' . $conn->error]);
}

// Cerrar la conexión
$conn->close();
?>

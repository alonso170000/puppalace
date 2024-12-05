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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $mascota_id = $_POST['mascota_id'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $sexo = $_POST['sexo'];
    $raza = $_POST['raza'];
    $tamano = $_POST['tamano'];
    $estado = $_POST['estado'];

    // Validar que los campos requeridos no estén vacíos
    if (empty($nombre) || empty($edad) || empty($sexo) || empty($raza) || empty($tamano) || empty($estado)) {
        echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
        exit;
    }

    // Consulta SQL para actualizar la mascota
    $sql = "UPDATE mascotas SET nombre='$nombre', edad=$edad, sexo='$sexo', raza='$raza', tamano='$tamano', estado='$estado' WHERE mascota_id=$mascota_id";

if ($conn->query($sql) === TRUE) {
    // Redirige a gestion.html, especificando que la acción de editar mascotas fue exitosa
    header("Location: gestion.html#editar-mascotas");
    exit;
} else {
    echo json_encode(['success' => false, 'error' => 'Error al actualizar la mascota: ' . $conn->error]);
}

    // Cerrar la conexión
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no válido']);
}
?>

<?php
// Conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'animals'; // Cambia esto al nombre de tu base de datos

$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Verificar que la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $mensaje = $_POST['mensaje'];

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO comentarios (nombre, apellido, email, telefono, mensaje) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nombre, $apellido, $email, $telefono, $mensaje);

    if ($stmt->execute()) {
        // Redirigir a la página "mascotas.html" después de un registro exitoso
        header("Location: mascotas.html");
        exit(); // Detener la ejecución después de la redirección
    } else {
        echo "Error al registrar el comentario: " . $stmt->error;
    }

    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>

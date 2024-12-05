<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "animals"; // Cambia esto con el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $sexo = $_POST['sexo'];
    $raza = $_POST['raza'];
    $tamano = $_POST['tamano'];
    $estado = $_POST['estado'];

    // Validar que el tamaño sea correcto
    if (!in_array($tamano, ['pequeño', 'mediano', 'grande'])) {
        die("El tamaño no es válido: $tamano");
    }

    // Procesar imagen
    if (isset($_FILES['imagen_mascota']) && $_FILES['imagen_mascota']['error'] === UPLOAD_ERR_OK) {
        $imagen = file_get_contents($_FILES['imagen_mascota']['tmp_name']);
    } else {
        die("Error al cargar la imagen.");
    }

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare("INSERT INTO mascotas (nombre, edad, sexo, raza, tamano, imagen_mascota, estado) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissbss", $nombre, $edad, $sexo, $raza, $tamano, $imagen, $estado);

    if ($stmt->execute()) {
        header("Location: gestion.html");
        exit();
    } else {
        die("Error al registrar la mascota: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>

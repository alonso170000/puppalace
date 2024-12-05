<?php
// Conexión a la base de datos
$servername = "localhost"; // Cambiar según tu configuración
$username = "root"; // Cambiar según tu configuración
$password = ""; // Cambiar según tu configuración
$dbname = "animals"; // Cambiar según tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_admin = $_POST['nombre_admin'];
    $correo_electronico = $_POST['correo_electronico'];
    $password_admin = $_POST['password_admin'];

    // Hacer hash de la contraseña
    $password_hashed = password_hash($password_admin, PASSWORD_DEFAULT);

    // Preparar la consulta SQL
    $sql = "INSERT INTO admins (nombre_admin, correo_electronico, password) 
            VALUES ('$nombre_admin', '$correo_electronico', '$password_hashed')";

    if ($conn->query($sql) === TRUE) {
        // Redirigir a la página "gestion.html" después de agregar el administrador
        header("Location: gestion.html");
        exit(); // Detener ejecución adicional después de la redirección
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

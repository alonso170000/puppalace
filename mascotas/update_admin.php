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
    $admin_id = $_POST['admin_id'];
    $nombre_admin = $_POST['nombre_admin'];
    $correo_electronico = $_POST['correo_electronico'];
    $password = $_POST['password']; // La nueva contraseña

    // Si la contraseña está vacía, mantén la contraseña anterior
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);  // Hashear la nueva contraseña
    } else {
        // Aquí puedes cargar la contraseña original si no la cambian
        $password = null;
    }

    // Validar que los campos requeridos no estén vacíos
    if (empty($nombre_admin) || empty($correo_electronico)) {
        echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
        exit;
    }

    // Si la contraseña fue modificada, actualiza el hash de la contraseña
    $sql = "UPDATE admins SET nombre_admin='$nombre_admin', correo_electronico='$correo_electronico'";
    if ($password !== null) {
        $sql .= ", password='$password'"; // Si se proporciona una nueva contraseña, se agrega al SQL
    }
    $sql .= " WHERE admin_id=$admin_id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al actualizar el administrador: ' . $conn->error]);
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Método de solicitud no válido']);
}
?>

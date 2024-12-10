<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Incluye la conexión a la base de datos
include '../conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

// Validación de datos recibidos
if (!isset($data['correo_electronico'], $data['password'])) {
    echo json_encode(["error" => "Faltan datos"]);
    exit();
}

$correo_electronico = $data['correo_electronico'];
$password = $data['password'];

// Consulta el usuario en la base de datos
$sql = "SELECT usuario_id, nombre_usuario, password FROM usuarios WHERE correo_electronico = '$correo_electronico'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verifica la contraseña
    if (password_verify($password, $user['password'])) {
        echo json_encode([
            "message" => "Inicio de sesión exitoso",
            "usuario" => [
                "usuario_id" => $user['usuario_id'],
                "nombre_usuario" => $user['nombre_usuario'],
                "correo_electronico" => $correo_electronico
            ]
        ]);
    } else {
        echo json_encode(["error" => "Contraseña incorrecta"]);
    }
} else {
    echo json_encode(["error" => "Usuario no encontrado"]);
}

$conn->close();
?>

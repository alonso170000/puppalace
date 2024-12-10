<?php
include 'conexion.php';
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_electronico = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar en la tabla de usuarios
    $sql_usuarios = "SELECT nombre_usuario, correo_electronico, password FROM usuarios WHERE correo_electronico = ?";
    $stmt_usuarios = $conn->prepare($sql_usuarios);
    $stmt_usuarios->bind_param("s", $correo_electronico);
    $stmt_usuarios->execute();
    $stmt_usuarios->store_result();

    if ($stmt_usuarios->num_rows > 0) {
        // Si existe en la tabla de usuarios
        $stmt_usuarios->bind_result($nombre_usuario, $correo_bd, $hashed_password);
        $stmt_usuarios->fetch();

        if (password_verify($password, $hashed_password)) {
            // Guardar datos del usuario en la sesión
            $_SESSION['nombre'] = $nombre_usuario;
            $_SESSION['correo'] = $correo_bd;

            // Redirige al HTML principal
            header("Location: mascotas.php");  // Asegúrate de que la ruta sea correcta
            exit();
        } else {
            $error_message = "Contraseña incorrecta. Intenta de nuevo.";
        }
    } else {
        // Si no está en la tabla usuarios, buscar en la tabla admins
        $sql_admins = "SELECT nombre_admin, correo_electronico, password FROM admins WHERE correo_electronico = ?";
        $stmt_admins = $conn->prepare($sql_admins);
        $stmt_admins->bind_param("s", $correo_electronico);
        $stmt_admins->execute();
        $stmt_admins->store_result();

        if ($stmt_admins->num_rows > 0) {
            // Si existe en la tabla de admins
            $stmt_admins->bind_result($nombre_admin, $correo_admin, $hashed_password);
            $stmt_admins->fetch();

            if (password_verify($password, $hashed_password)) {
                // Guardar datos del administrador en la sesión
                $_SESSION['nombre'] = $nombre_admin;
                $_SESSION['correo'] = $correo_admin;

                // Redirige al panel de administración
                header("Location: mascoadmin.php"); // Asegúrate de que la ruta sea correcta
                exit();
            } else {
                $error_message = "Contraseña incorrecta. Intenta de nuevo.";
            }
        } else {
            // Si no está en ninguna tabla
            $error_message = "La cuenta no existe. Por favor, regístrate.";
        }

        $stmt_admins->close();
    }

    $stmt_usuarios->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pup Palace - Inicio de Sesión</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="login-container">
            <img src="fotos/logo.png" alt="Pup Palace Logo" class="logo" style="width: 125px">
            <div class="form-box">
                <?php if (!empty($error_message)) : ?>
                    <div style="color: red;"><?= $error_message; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <label for="email">Correo Electronico</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                    
                    <button type="submit">Iniciar Sesión</button>
                </form>
                
                <p>¿No tienes una cuenta? <a href="registro.php">Regístrate</a></p>
            </div>
        </div>
    </div>
</body>
</html>

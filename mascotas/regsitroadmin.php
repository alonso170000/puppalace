<?php  
include 'conexion.php';  
session_start();  

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    // Recibe los datos del formulario  
    $nombre_admin = $_POST['name']; // Cambiado a nombre_admin  
    $correo_electronico = $_POST['email'];  
    $password = $_POST['password'];  

    // Encriptar la contraseÃ±a  
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);  

    // Verificar si el correo electrÃ³nico ya existe en la tabla admins  
    $sql = "SELECT * FROM admins WHERE correo_electronico = ?";  
    $stmt = $conn->prepare($sql);  
    $stmt->bind_param("s", $correo_electronico);  
    $stmt->execute();  
    $stmt->store_result();  

    if ($stmt->num_rows > 0) {  
        // Si el correo ya existe, muestra un mensaje de error  
        $error_message = "Este correo ya estÃ¡ registrado.";  
    } else {  
        // Si el correo no existe, insertar al nuevo admin  
        $sql = "INSERT INTO admins (nombre_admin, password, correo_electronico) VALUES (?, ?, ?)";  
        $stmt = $conn->prepare($sql);  
        $stmt->bind_param("sss", $nombre_admin, $hashed_password, $correo_electronico);  

        if ($stmt->execute()) {  
            // Si el registro es exitoso, almacenar en una variable para mostrar el mensaje de Ã©xito  
            $success_message = "Registro con éxito.";  
        } else {  
            // Si hay un error, mostrar mensaje  
            $error_message = "Error en el registro, por favor intenta de nuevo.";  
        }  
    }  
    $stmt->close();  
    $conn->close();  
}  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Pup Palace - Registro Admin</title>  
    <link rel="stylesheet" href="styles.css">  
</head>  
<body>  
    <div class="container">  
        <div class="login-container">  
            <img src="fotos/logo.png" alt="Pup Palace Logo" class="logo" style="width: 125px">  
            <div class="form-box">  
                <form action="" method="post" onsubmit="return validarContrasenas()">  
                    <label for="name">Nombre Admin</label> <!-- Cambiado a Nombre Admin -->  
                    <input type="text" id="name" name="name" required style="width: 335px; height: 35px;">  

                    <label for="email">Correo ElectrÃ³nico</label>  
                    <input type="email" id="email" name="email" required>  

                    <label for="password">ContraseÃ±a</label>  
                    <input type="password" id="password" name="password" required>  

                    <label for="confirm-password">Confirmar ContraseÃ±a</label>  
                    <input type="password" id="confirm-password" name="confirm-password" required>  

                    <button type="submit">Registrarse</button>  
                </form>  

                <!-- Mostrar el mensaje de error o Ã©xito -->  
                <?php if (isset($error_message)) : ?>  
                    <div style="color: red;"><?= $error_message; ?></div> <!-- Mensaje de error -->  
                <?php endif; ?>  
                <?php if (isset($success_message)) : ?>  
                    <div style="color: green;"><?= $success_message; ?></div> <!-- Mensaje de Ã©xito -->  
                    <script>  
                        // DespuÃ©s de mostrar el mensaje de Ã©xito, redirigir despuÃ©s de un segundo  
                        setTimeout(function() {  
                            window.location.href = "login.php"; // Redirige a login  
                        }, 1500); // 1500 milisegundos (1.5 segundos)  
                    </script>  
                <?php endif; ?>  

                <p>o regÃ­strate con</p>  
                <div class="social-login">  
                    <button class="social-btn facebook">Facebook</button>  
                    <button class="social-btn google">Google</button>  
                    <button class="social-btn apple">Apple</button>  
                </div>  
                <p>Â¿Ya tienes una cuenta? <a href="login.php">Inicia sesiÃ³n</a></p>  
            </div>  
        </div>  
    </div>  

    <script>  
        function validarContrasenas() {  
            const password = document.getElementById('password').value;  
            const confirmPassword = document.getElementById('confirm-password').value;  

            if (password !== confirmPassword) {  
                alert('Las contraseÃ±as no coinciden. Por favor, intenta de nuevo.');  
                return false; // Evita que se envÃ­e el formulario  
            }  
            return true; // Permite enviar el formulario si coinciden  
        }  
    </script>  
</body>  
</html>
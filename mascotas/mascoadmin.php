<?php
session_start();
if (!isset($_SESSION['nombre']) || !isset($_SESSION['correo'])) {
    header("Location: login.php"); // Redirige si no hay sesión activa
    exit();
}
$nombre = $_SESSION['nombre'];
$correo = $_SESSION['correo'];
?>

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Pup Palace</title>  
<style>  
    body {  
        margin: 0;  
        font-family: Arial, sans-serif;  
        color: white;  
        background-color: #000;  
    }  
    /* Barra de navegación fija */  
    header {  
        background-color: #8B0000;  
        padding: 10px;  
        display: flex;  
        justify-content: space-between;  
        align-items: center;  
        position: fixed;  
        top: 0;  
        width: 100%;  
        z-index: 1000;  
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);  
    }  
    nav {  
        display: flex;  
        gap: 20px;  
    }  
    nav a {  
        color: white;  
        text-decoration: none;  
    }  
    nav a.active {  
        color: yellow;  
    }  
    /* Banner de la primera sección como sección normal, no fija */  
    .banner {  
        background-image: url('fotos/perroygato.jpg');  
        background-size: cover;  
        background-position: center;  
        height: 600px;  
        display: flex;  
        flex-direction: column;  
        justify-content: center;  
        align-items: flex-start;  
        padding: 20px;  
        margin-top: 60px;  /* Para que no se sobreponga con el header fijo */  
    }  
    .banner h1 {  
        font-size: 36px;  
        margin: 0;  
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);  
    }  
    .adopt-btn {  
        background-color: #B22222;  
        color: white;  
        padding: 15px 25px;  
        border: none;  
        border-radius: 5px;  
        cursor: pointer;  
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);  
        margin-top: 10px;  
    }  
    .adopt-btn:hover {  
        background-color: #FF4500;  
    }  
    .section {  
        padding: 60px 20px;  
        margin-top: 60px;  /* Para evitar que se superponga con el header fijo */  
    }  
    .container {  
        max-width: 1200px;  
        margin: auto;  
        display: flex;  
        align-items: center;  
        gap: 20px;  
        flex-wrap: wrap;  
    }  
    .text-content, .info-container, .cards {  
        flex: 1;  
    }  
    .text-content h1, .heading, .subheading, .card h3 {  
        color: white;  
    }  
    .image-container img {  
        width: 100%;  
        max-width: 400px;  
        border-radius: 5px;  
    }  
    .cards {  
        display: flex;  
        gap: 20px;  
        flex: 1;  
    }  
    .card {  
        background-color: #8B0000;  
        border-radius: 8px;  
        padding: 20px;  
        flex: 1;  
        display: flex;  
        flex-direction: column;  
        align-items: center;  
        text-align: center;  
    }  
    .card img {  
        width: 100%;  
        height: auto;  
        max-width: 300px;  
        border-radius: 8px 8px 0 0;  
    }  
    /* Estilos exclusivos para la sección de contacto */  
    #contacto .form-container {  
        flex: 1;  
        padding: 20px;  
    }  
    #contacto .form-container input, #contacto .form-container textarea {  
        width: 100%;  
        padding: 10px;  
        margin-bottom: 20px;  
        border: 1px solid #B22222;  
        border-radius: 5px;  
        background-color: #121212;  
        color: white;  
    }  
    #contacto .form-container button {  
        background-color: #DC143C;  
        color: white;  
        padding: 10px 20px;  
        border: none;  
        border-radius: 5px;  
        cursor: pointer;  
    }  
    #contacto .form-container button:hover {  
        background-color: #FF4500;  
    }  
    /* Estilos para la ventana de perfil */  
    .perfil-card {  
        background-color: #8B0000;  
        border-radius: 8px;  
        padding: 20px;  
        width: 300px;  
        display: none; /* Inicialmente oculto */  
        position: fixed;  
        top: 100px;  
        right: 20px;  
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);  
    }  
    .perfil-card h2 {  
        margin: 0;  
        color: white;  
        font-size: 24px;  
    }  
    .perfil-card p {  
        color: white;  
        margin-top: 10px;  
    }
    /* Estilo para los botones en el perfil */
.perfil-opciones {
    display: flex;
    flex-direction: column; /* Coloca los botones en una columna */
    gap: 10px; /* Espaciado entre los botones */
}

.perfil-btn {
    display: block;
    background-color: #B22222;
    color: white;
    text-align: center;
    padding: 10px;
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
}

.perfil-btn:hover {
    background-color: #FF4500;
}

/* Línea divisoria */
.perfil-opciones hr {
    border: none;
    border-top: 1px solid #FFFFFF;
    margin: 10px 0;
}
  
    .cerrar-btn {  
        background-color: #B22222;  
        color: white;  
        padding: 10px 20px;  
        border: none;  
        border-radius: 5px;  
        cursor: pointer;  
        margin-top: 15px;  
    }  
    .cerrar-btn:hover {  
        background-color: #FF4500;  
    }  
</style><header>
    <div>
        <br>
        <img src="fotos/logoo.png" alt="Logo" height="69" width="79">
        <img src="fotos/titulo.png" alt="Título" style="height: 50px; margin-left: 10px;">
    </div>
    <nav>
        <a href="#inicio">Inicio</a>
        <a href="#nosotros">Nosotros</a>
        <a href="#ayudar">Ayudar</a>
        <a href="#contacto">Contacto</a>
        <a href="#" id="perfilBtn">Perfil</a> <!-- Agregado botón para desplegar perfil -->
    </nav>
</header>
<!-- Primera sección como sección normal, ahora se desplaza con el scroll -->  
<div id="inicio" class="banner section">  
    <h1>Encuentra a tu amigo perfecto aquí</h1>  
    <a href="adoptar.html"><button class="adopt-btn">Adoptar</button></a>  
</div>  

<!-- Otras secciones permanecen igual -->  
<div id="nosotros" class="section">  
    <div class="container">  
        <div class="text-content">  
            <h1>En Pup Palace estamos comprometidos con el cuidado y bienestar animal</h1>  
            <p>Somos un refugio de animales que se encarga del rescate y adopción de perros y gatos en Cancún. Nos esforzamos por conectar a personas con mascotas que se ajusten a su estilo de vida y fomentar una comunidad de amor y compasión hacia los animales.</p>  
        </div>  
        <div class="image-container">  
            <img src="fotos/perronegro.jpg" alt="Perro negro">  
        </div>  
    </div>  
</div>  

<div id="ayudar" class="section">  
    <h1 class="heading">Haz la diferencia y ellos te lo agradecerán</h1>  
    <p class="subheading">Tu apoyo es fundamental para que podamos continuar rescatando y cuidando a perros y gatos abandonados.</p>  
    <div class="cards container">  
        <div class="card">
            <img src="fotos/pug.jpg" alt="Adopta">  
            <h3>Adopta</h3>  
            <p>Al adoptar, no solo estás brindando una nueva vida a un amigo fiel, sino también ganando un compañero que te será leal toda la vida.</p>  
            <a href="adoptar.html"><button class="adopt-btn">Adoptar</button></a>  
        </div>  
        <div class="card">  
            <img src="fotos/puglentes.jpg" alt="Comparte">  
            <h3>Comparte</h3>  
            <p>Ayúdanos a difundir nuestra misión y los animales disponibles para adopción compartiendo nuestras publicaciones en tus redes sociales.</p>  
            <a href="adoptar.html"><button class="adopt-btn">Compartir</button></a>  
        </div>  
    </div>  
</div>  

<div id="contacto" class="section">  
    <div class="container">  
        <div class="form-container">  
            <h2>Contáctanos</h2>  
            <label for="nombre">Nombre <span style="color: red;">*</span></label>  
            <input type="text" id="nombre" placeholder="Nombre" required>  

            <label for="apellido">Apellido <span style="color: red;">*</span></label>  
            <input type="text" id="apellido" placeholder="Apellido" required>  

            <label for="correo">Correo electrónico <span style="color: red;">*</span></label>  
            <input type="email" id="correo" placeholder="Correo electrónico" required>  

            <label for="telefono">Teléfono <span style="color: red;">*</span></label>  
            <input type="tel" id="telefono" placeholder="Teléfono" required>  

            <label for="mensaje">Mensaje</label>  
            <textarea id="mensaje" placeholder="Escribe tu mensaje"></textarea>  

            <button type="submit">Enviar</button>  
        </div>  
        <div class="info-container">  
            <h2>Déjanos tus opiniones</h2>  
            <p>¿Tienes alguna pregunta, sugerencia o deseas más información sobre nuestra labor? Nos encantaría saber de ti. Completa el formulario y nos pondremos en contacto contigo a la brevedad.</p>  
        </div>  

<!-- Recuadro de Perfil que estará oculto por defecto -->
<div id="perfilCard" class="perfil-card">
    <h2>Perfil de Administrador</h2>
    <p>Hola, <span id="usuarioNombre"><?php echo htmlspecialchars($nombre); ?></span>!</p>
    <p id="usuarioCorreo">Correo: <?php echo htmlspecialchars($correo); ?></p>
    
    <!-- Botones con nueva estructura -->
    <div class="perfil-opciones">
        <a href="gestion.html" class="perfil-btn">Gestionar</a>
        <hr> <!-- Línea divisoria -->
        <a href="login.php" class="perfil-btn cerrar-btn">Cerrar sesión</a>
    </div>
</div>

<script>
    // Obtener los elementos
    const perfilBtn = document.getElementById('perfilBtn');
    const perfilCard = document.getElementById('perfilCard');

    // Función para mostrar/ocultar el recuadro del perfil
    perfilBtn.addEventListener('click', function() {
        if (perfilCard.style.display === 'none' || perfilCard.style.display === '') {
            perfilCard.style.display = 'block';
        } else {
            perfilCard.style.display = 'none';
        }
    });
</script>
</div>  
<script>  
    window.addEventListener("scroll", () => {  
        let sections = document.querySelectorAll(".section");  
        let links = document.querySelectorAll(".nav-link");  

        sections.forEach((section, index) => {  
            let top = section.offsetTop - 100;  
            let bottom = top + section.offsetHeight;  

            if (window.scrollY >= top && window.scrollY < bottom) {  
                links.forEach(link => link.classList.remove("active"));  
                links[index].classList.add("active");  
            }  
        });  
    });  
</script>  

</body>  
</html>   

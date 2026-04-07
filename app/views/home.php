<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Sistema de Gestión de Talleres</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php?page=home" class="navbar-brand">
                Gestion de Talleres
            </a>
            <div class="navbar-menu">
                <?php if (isset($_SESSION['id']) && $_SESSION['id']): ?>
                    <?php 
                    $nombreUsuario = $_SESSION['user'] ?? 'Usuario';
                    ?>
                    <span class="user-name">Hola, <?php echo htmlspecialchars($nombreUsuario); ?></span>
                    <?php 
                    $rolUsuario = $_SESSION['rol'] ?? '';
                    if ($rolUsuario == 'admin'): 
                    ?>
                        <a href="index.php?page=admin" class="nav-link">Panel Admin</a>
                    <?php endif; ?>
                    <a href="index.php?page=talleres" class="nav-link">Talleres</a>
                    <button id="btnLogout" class="btn btn-outline" style="padding: 0.5rem 1rem;">
                        Cerrar Sesion
                    </button>
                <?php else: ?>
                    <a href="index.php?page=login" class="nav-link">Iniciar Sesion</a>
                    <a href="index.php?page=registro" class="btn btn-primary" style="padding: 0.5rem 1rem;">
                        Registrarse
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="hero">
            <h1>Sistema de Gestion de Talleres</h1>
            <p>Plataforma integral para la administracion y gestion de talleres educativos</p>
            <?php if (!isset($_SESSION['id'])): ?>
                <div class="cta-buttons">
                    <a href="index.php?page=registro" class="btn btn-primary">
                        Comenzar Ahora
                    </a>
                    <a href="index.php?page=login" class="btn btn-outline">
                        Ya tengo cuenta
                    </a>
                </div>
            <?php else: ?>
                <div class="cta-buttons">
                    <a href="index.php?page=talleres" class="btn btn-primary">
                        Ver Talleres Disponibles
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="features">
            <div class="feature-card">
                <div class="feature-icon"></div>
                <h3>Gestion de Solicitudes</h3>
                <p>Solicita tu taller favorito y recibe confirmacion inmediata de tu inscripcion</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"></div>
                <h3>Panel Administrativo</h3>
                <p>Los administradores pueden gestionar solicitudes, aprobar o rechazar participantes</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"></div>
                <h3>Control de Cupos</h3>
                <p>Sistema inteligente de control de cupos disponibles en tiempo real</p>
            </div>
        </div>

        <div class="talleres-detalle">
            <h2>Nuestros Talleres</h2>
            <p>Conoce mas sobre los cursos que ofrecemos</p>
            
            <!-- Taller 1: PHP -->
            <div class="taller-detalle-card">
                <h3>Taller de PHP</h3>
                <div class="taller-descripcion">
                    Aprende PHP desde cero con el patron de arquitectura MVC. 
                    Este taller te permitira desarrollar aplicaciones web dinamicas y robustas, 
                    conectandote a bases de datos y manejando sesiones de usuario.
                </div>
                <div class="taller-info">
                    <div class="info-item">
                        <span>Duracion:</span>
                        <span>4 semanas</span>
                    </div>
                    <div class="info-item">
                        <span>Nivel:</span>
                        <span>Principiante - Intermedio</span>
                    </div>
                    <div class="info-item">
                        <span>Cupo maximo:</span>
                        <span>5 estudiantes</span>
                    </div>
                </div>
                <div class="taller-objetivos">
                    <h4>Lo que aprenderas:</h4>
                    <p>Fundamentos de PHP y sintaxis básica<br>
                    Programacion orientada a objetos<br>
                    Implementacion del patron MVC<br>
                    Conexion a bases de datos MySQL<br>
                    Manejo de sesiones y autenticacion</p>
                </div>
            </div>
            
            <!-- Taller 2: jQuery -->
            <div class="taller-detalle-card">
                <h3>Taller de jQuery</h3>
                <div class="taller-descripcion">
                    Domina jQuery, la biblioteca de JavaScript mas popular. Aprende a manipular el DOM, 
                    manejar eventos, realizar peticiones AJAX y crear interfaces dinamicas sin recargar 
                    la pagina. Ideal para mejorar la experiencia de usuario.
                </div>
                <div class="taller-info">
                    <div class="info-item">
                        <span>Duracion:</span>
                        <span>3 semanas</span>
                    </div>
                    <div class="info-item">
                        <span>Nivel:</span>
                        <span>Intermedio</span>
                    </div>
                    <div class="info-item">
                        <span>Cupo maximo:</span>
                        <span>3 estudiantes</span>
                    </div>
                </div>
                <div class="taller-objetivos">
                    <h4>Lo que aprenderas:</h4>
                    <p>Selectores y manipulacion del DOM<br>
                    Manejo de eventos y animaciones<br>
                    Peticiones AJAX con jQuery<br>
                    Creacion de formularios dinamicos<br>
                    Validaciones en tiempo real</p>
                </div>
            </div>
            
            <!-- Taller 3: MySQL -->
            <div class="taller-detalle-card">
                <h3>Taller de MySQL</h3>
                <div class="taller-descripcion">
                    Aprende a disenar y administrar bases de datos relacionales con MySQL. 
                    Desde la creacion de tablas y relaciones hasta consultas avanzadas, 
                    optimizacion y gestion de usuarios. Fundamentos esenciales para cualquier 
                    desarrollador backend.
                </div>
                <div class="taller-info">
                    <div class="info-item">
                        <span>Duracion:</span>
                        <span>4 semanas</span>
                    </div>
                    <div class="info-item">
                        <span>Nivel:</span>
                        <span>Principiante - Intermedio</span>
                    </div>
                    <div class="info-item">
                        <span>Cupo maximo:</span>
                        <span>4 estudiantes</span>
                    </div>
                </div>
                <div class="taller-objetivos">
                    <h4>Lo que aprenderas:</h4>
                    <p>Modelado y diseno de bases de datos<br>
                    Consultas SQL (SELECT, INSERT, UPDATE, DELETE)<br>
                    Joins y subconsultas<br>
                    Indices y optimizacion<br>
                    Procedimientos almacenados y triggers</p>
                </div>
            </div>
        </div>
    </div> <!-- Cierre del container -->

    <footer>
        <div class="footer">
            <p>SC502 - Caso de estudio 2 Administración Web Cliente/Servidor</p>
            <p>&copy; 2026 Paola Solorzano Mendez.</p>
        </div>
    </footer>

    <script>
        // Funcion para cerrar sesion
        document.getElementById("btnLogout")?.addEventListener("click", function() {
            fetch("index.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "option=logout"
            })
            .then(response => response.json())
            .then(data => {
                if(data.response === "00") {
                    window.location = "index.php?page=login";
                }
            });
        });
    </script>
</body>
</html>
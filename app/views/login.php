<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/auth.js"></script>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php?page=home" class="navbar-brand">
            Gestion de Talleres
        </a>
        <div class="navbar-menu">
            <a href="index.php?page=home" class="nav-link">
                ← Volver al inicio
            </a>
        </div>
    </div>
</nav>

<div class="auth-container">
    <div class="auth-card">
        <h2>Iniciar sesion</h2>
        <p class="auth-subtitle">Accede a tu cuenta</p>

        <form id="formLogin">
            <input type="text" name="username" id="username" placeholder="Usuario" class="auth-input" autocomplete="off">
            <input type="password" name="password" id="password" placeholder="Contrasena" class="auth-input">
            <button type="submit" class="btn btn-primary auth-btn">Ingresar</button>
            <a href="index.php?page=registro" class="auth-link">Crear cuenta</a>
        </form>
        
        <div class="auth-info">
            <p>usuario de prueba: usuario1 2 y 3 / 12345</p>
            <p>admin: admin / 12345</p>
        </div>
    </div>
</div>

<footer>
        <div class="footer">
            <p>SC502 - Caso de estudio 2 Administración Web Cliente/Servidor</p>
            <p>&copy; 2026 Paola Solorzano Mendez.</p>
        </div>
    </footer>

</body>
</html>
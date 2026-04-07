<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/register.js"></script>
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
        <h2>Crear cuenta</h2>
        <p class="auth-subtitle">Registrate para continuar</p>

        <form id="formRegister">
            <input type="text" name="username" id="username" placeholder="Usuario" class="auth-input" autocomplete="off">
            <input type="password" name="password" id="password" placeholder="Contrasena" class="auth-input">
            <button type="submit" class="btn btn-primary auth-btn">Registrarse</button>
            <a href="index.php?page=login" class="auth-link">Ya tengo cuenta</a>
        </form>
        
        <div class="auth-info">
            <p>El usuario solo puede contener letras, numeros y guion bajo</p>
            <p>La contraseña debe tener al menos 4 caracteres</p>
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
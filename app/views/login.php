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
            Gestión de Talleres
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

        <h2>Iniciar sesión</h2>
        <p class="auth-subtitle">Accede a tu cuenta</p>

        <form id="formLogin">

            <input
                type="text"
                name="username"
                id="username"
                placeholder="Usuario"
                class="auth-input">

            <input
                type="password"
                name="password"
                id="password"
                placeholder="Contraseña"
                class="auth-input">

            <button type="submit" class="btn btn-primary auth-btn">
                Ingresar
            </button>

            <a href="index.php?page=registro" class="auth-link">
                Crear cuenta
            </a>

        </form>

    </div>

</div>

</body>
</html>
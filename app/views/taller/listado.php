<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Talleres</title>

    <link rel="stylesheet" href="public/css/style.css">

    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/taller.js"></script>
<body>

<nav class="navbar">
    <div class="navbar-container">

        <a href="index.php?page=home" class="navbar-brand">
            Gestión de Talleres
        </a>

        <div class="navbar-menu">

            <a href="index.php?page=talleres" class="nav-link">
                Talleres
            </a>

            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <a href="index.php?page=admin" class="nav-link">
                    Gestionar
                </a>
            <?php endif; ?>

            <span class="user-name">
                <?= htmlspecialchars($_SESSION['user'] ?? 'Usuario') ?>
            </span>

            <button id="btnLogout" class="btn btn-outline">
                Cerrar sesión
            </button>

        </div>
    </div>
</nav>


<div class="container">

    <div class="page-header">
        <h2>Talleres disponibles</h2>
        <p>Selecciona un taller para solicitar inscripción</p>
    </div>

    <div id="listaTalleres" class="taller-grid">
        <!-- JS carga talleres aquí -->
    </div>

</div>

</body>

</html>
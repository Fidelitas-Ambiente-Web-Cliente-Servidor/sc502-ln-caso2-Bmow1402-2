<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Talleres</title>
    <link rel="stylesheet" href="public/css/style.css">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/taller.js"></script>
</head>
<body>

<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php?page=home" class="navbar-brand">
            Gestion de Talleres
        </a>
        <div class="navbar-menu">
            <a href="index.php?page=talleres" class="nav-link">Talleres</a>
            <span class="user-name">
                <?php 
                $nombreUsuario = $_SESSION['user'] ?? 'Usuario';
                echo htmlspecialchars($nombreUsuario); 
                ?>
            </span>
            <button id="btnLogout" class="btn btn-outline">Cerrar sesion</button>
        </div>
    </div>
</nav>

<div class="container">
    <div class="page-header">
        <h2>Talleres disponibles</h2>
        <p>Selecciona un taller para solicitar inscripción</p>
    </div>

    <div id="listaTalleres" class="taller-grid">
    </div>
    
    <!-- Sección de Mis Solicitudes -->
    <div class="page-header" style="margin-top: 3rem;">
        <h2> Mis Solicitudes</h2>
        <p>Estado de tus solicitudes</p>
    </div>
    
    <div class="admin-card">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Taller</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="misSolicitudes-body">
                <tr><td colspan="3">Cargando...</td></tr>
            </tbody>
        </table>
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